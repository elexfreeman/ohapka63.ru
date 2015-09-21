<?php
include "../core.php";



/*


c:\distr\cURL\bin\curl -F "importFile=@c:\elex\Sites\teplohot.ru\PRICE_ROST.csv" "http://teplohot.aktitest.ru/imports/" > log.txt

 * */






//Парсит свойства товара
function ParseFeature($f)
{
    if ($f != "") {
        //Удаляем херь из строки
        $temp = str_replace("<p>", ";", $f);

        $temp = str_replace("</p>", ";", $temp);

        $temp = str_replace(";;", ";", $temp);

        $temp = str_replace(" :", ":", $temp);

        $temp = str_replace(": ", ":", $temp);

        echo $temp."<br>";
        //разбиваем на с\масив
        $temp = explode(";", $temp);
        //$temp = explode(";", $temp);
        //делаем хэш-матрицу

        for ($i = 0; $i < count($temp); $i++) {
            $kk = explode(":", $temp[$i]);
            if (isset($kk[1])) $tmp[$kk[0]] = RemoveApostrof($kk[1]);
        }
        return $tmp;
    } else return null;

}


//Удаляет артикул из названия
function RemoveArticle($s)
{
    $pos = strpos($s, ' ');
    return substr($s, $pos+1);

}

function flush_buffers(){
    ob_end_flush();
    ob_flush();
    flush();
    ob_start();
}

function InsertFeature($s,$product_id,$category_id)
{
    global $modx;
    echo "-------------   ".$s."  -----------<br>";
    if(!empty($s))
    {
        $features=ParseFeature($s);
        if($features!=null)
        {
            echo  "feat";
            var_dump($features);
            foreach ($features as $key => $value) {
                if($key!="")
                {
                    // - 1 - ищем уже такое свойство
                    $sql="SELECT count(*) cc FROM s_features WHERE name='$key'";
                    foreach($modx->query($sql) as $row) {
                        $IsFeature=$row['cc']+0;
                    }
                    echo  $sql." ++<br/>";

                    //если такого свойства нету то вставлем
                    if($IsFeature==0)
                    {
                        $sql="INSERT INTO `s_features` (`id`, `name`, `position`)
                        VALUES (NULL, '".$key."', '1');";
                        echo  $sql." ++<br/>";
                        $modx->query($sql);
                        $feature_id = $modx->lastInsertId();
                    }
                    else
                    {
                        //ищем ID сво-ва
                        $sql="SELECT *  FROM s_features WHERE name='$key'";
                        foreach($modx->query($sql) as $row) {
                            $feature_id=$row['id']+0;
                        }
                    }

                    // - 2 - вставляем значение поля для товара
                    $sql="INSERT INTO `s_options` (`product_id`, `feature_id`, `value`)
                        VALUES ($product_id, $feature_id, '$value');";
                    echo  $sql." ++<br/>";
                    $modx->query($sql);

                    // - 3 - вставляем значение поля для категории
                    // - 1 - ищем уже такое свойство
                    $sql="SELECT count(*) cc FROM s_category_features WHERE (feature_id='$feature_id')and(category_id='$category_id')";
                    foreach($modx->query($sql) as $row) {
                        $IsFeature=$row['cc']+0;
                    }
                    echo  $sql." ++<br/>";
                    if($IsFeature==0)
                    {
                        $sql="INSERT INTO `s_category_features` (`category_id`, `feature_id`)
                        VALUES ($category_id, $feature_id);";
                        echo  $sql." ++<br/>";
                        $modx->query($sql);

                    }

                }


            }
        }
    }

}



function GetCountGr($name)
{
    global $modx;
    $sql="select count(*) cc from s_category where title='".$name."';";
     echo  $sql." ++<br/>";

    foreach($modx->query($sql) as $row) {
        //echo  $sql. " ++ ".$row['cc']. " ++<br/>";
        return $row['cc']+0;
    }

}

function GetCountBr($name,$parent)
{
    global $modx;
    $sql="select count(*) cc from s_category where title='".$name."';";
    echo  $sql." ++<br/>";

    foreach($modx->query($sql) as $row) {
        echo  $sql. " ++ ".$row['cc']. " ++<br/>";
        return $row['cc']+0;
    }

}




function RemoveApostrof($string)
{


    $string = str_replace("'", "", $string);
    $string = str_replace("\"", "", $string);
    return $string;

}



//c:\distr\cURL\bin>curl --form "importFile=@c:\elex\Sites\teplohot.ru\DES_CAT_SMP.csv" "http://teplohot.aktitest.ru/imports/"
//curl --form importFile=@c:\elex\Sites\teplohot.ru\DES_CAT_SMP.csv "http://teplohot.aktitest.ru/imports/"
//curl -X POST -H "Content-Type: multipart/form-data" http://teplohot.aktitest.ru/imports/ -d importFile=@c:/elex/Sites/teplohot.ru/DES_CAT_SMP.csv


//curl -i -X POST -H "Content-Type: multipart/form-data" -F "file=@c:/elex/Sites/teplohot.ru/DES_CAT_SMP.csv" "http://teplohot.aktitest.ru/imports/"




//$curl -X POST -u  admin:admin "http://teplohot.aktitest.ru/imports/" -Hcontent-type:application/xml -d @c:/elex/Sites/teplohot.ru/DES_CAT_SMP.csv

//    curl -u username:password -i -o c:/elex/Sites/teplohot.ru/DES_CAT_SMP.csv -Tc:/elex/Sites/teplohot.ru/DES_CAT_SMP.csv 'http://teplohot.aktitest.ru/imports/'


/*

curl -F "importFile=@c:\elex\Sites\teplohot.ru\DES_CAT_SMP.csv" "http://teplohot.aktitest.ru/imports/" > log.txt


 */

function Import_DC_IMS()
{
    global $modx;

    $today = date("Y-m-d_H_i_s");
    echo "-------------------------------------------------------------------";
    echo "*******************************************************************";
    echo $today;
    echo "*******************************************************************";
    include "csv.php";

    //var_dump($_FILES);
    //var_dump($_POST);

    $uploaddir = $_SERVER['DOCUMENT_ROOT'].'/imports/';
    $uploadfile = $uploaddir . basename($_FILES['importFile']['name']);

    echo  '<pre>';
    if (move_uploaded_file($_FILES['importFile']['tmp_name'], $uploadfile)) {
        echo  "Файл корректен и был успешно загружен.\n";
        $bk_file= $uploaddir."history/".$today."_".$_SERVER['REMOTE_ADDR']."_".basename($_FILES['importFile']['name']);
        echo $bk_file."<br>";
        copy($uploadfile,$bk_file);
        echo exec("gzip ".$bk_file)."<br>";
        try {

            echo "Открываем наш csv.<br>";
            $csv = new CSV($uploadfile);

            /**
             * Чтение из CSV  (и вывод на экран)
             */

            $get_csv = $csv->getCSV();
            foreach ($get_csv as $value) { //Проходим по строкам

                //херим предыдущие (пока что)
                //$modx->query("TRUNCATE TABLE s_orders_labels;");
                $value[0]=cp1251_to_utf8($value[0]);
                $value[1]=cp1251_to_utf8($value[1]);
                $value[2]=cp1251_to_utf8($value[2]);


                // - 1 - ищем такую дисконтную карту
                $d_id=0;
                $sql = "select * from  s_coupons where (code='" . $value[0] . "');";
                echo  $sql . " - 1 - ищем такую дисконтную карту<br>";
                foreach ($modx->query($sql) as $row) {
                    $d_id = $row['id'] + 0;
                }
                if($d_id>0) //если такая есть:
                {
                    $sql="UPDATE s_coupons SET value = '".($value[1]+0)."' WHERE id = ".$d_id;
                    echo $sql."<br>";
                    $modx->query($sql);
                }else
                {
                    //вставляем новую
                    $sql="INSERT INTO `s_coupons`
        (`id`, `code`, `name`, `expire`, `type`, `value`, `min_order_price`, `single`, `usages`)
         VALUES
         (NULL, '".($value[0])."', '".($value[2])."', NULL, 'percentage', '".($value[1]+0)."',
           '0', '0', '0');";
                    //  echo  "Таких брендов нет, вставлям новый: ".$sql. "<br/>";
                    $modx->query($sql);
                    echo  $sql."<br>";
                }
            }
        }
        catch (Exception $e) { //Если csv файл не существует, выводим сообщение
            echo  "Ошибка: " . $e->getMessage();
        }
    } else {
        echo  "Возможная атака с помощью файловой загрузки!\n";
    }



}

function UpdateModxStructure()
{
    global $modx;
    /*
    - 1 - удалеем все товары с макетами modx_template_category modx_template_product
    - 2 - обновляем autoincrement mysql
    - 3 - заполняем категории
    - 4 - заполняем товары

    INSERT INTO modx_site_content
(id, type, contentType, pagetitle, longtitle,
        description, alias, link_attributes,
        published, pub_date, unpub_date, parent,
        isfolder, introtext, content, richtext,
        template, menuindex, searchable,
        cacheable, createdby, createdon,
        editedby, editedon, deleted, deletedon,
        deletedby, publishedon, publishedby,
        menutitle, donthit, privateweb, privatemgr,
        content_dispo, hidemenu, class_key, context_key,
        content_type, uri, uri_override, hide_children_in_tree,
        show_in_tree, properties)
        VALUES (NULL, 'document', 'text/html', 'О магазине', 'О магазине', '', 'o-magazine', '', true, 0, 0, 0, false, '', '', true, 2, 1, true, true, 1, 1421901846, 0, 0, false, 0, 0, 1421901846, 1, '', false, false, false, false, false, 'modDocument', 'web', 1, 'o-magazine.html', false, false, true, null);

    */

    // - 1 -
    $sql="delete from modx_site_content where (template=3)or(template=4)";
    $modx->query($sql);

    // - 2 -
    $sql="select (max(id)+1) a from modx_site_content";
   // $maxID=0;
    foreach($modx->query($sql) as $row) {
        //echo  $sql. " ++ ".$row['cc']. " ++<br/>";
        $maxID=$row['a']+0;
    }

    $sql = "ALTER TABLE modx_site_content SET AUTO_INCREMENT=".$maxID;
    $modx->query($sql);

    // - 3 -
    $sql="select c1.id, c1.title,c1.longtitle,c1.parent,c2.title parent_title from s_category c1
  left
   join s_category c2
  on c2.id=c1.parent

  order by c1.parent";
     foreach($modx->query($sql) as $row) {
         //echo  $sql. " ++ ".$row['cc']. " ++<br/>";

         $parent=modx_id_category;
         echo $parent."<br>";

         $sql_parent="select id from modx_site_content where  pagetitle='".$row['parent_title']."';";
         foreach($modx->query($sql_parent) as $row_parent) {
             $parent=$row_parent['id'];
         }
         echo $parent."<br>";



         $sql_incert="INSERT INTO modx_site_content
(id, type, contentType, pagetitle, longtitle,
        description, alias, link_attributes,
        published, pub_date, unpub_date, parent,
        isfolder, introtext, content, richtext,
        template, menuindex, searchable,
        cacheable, createdby, createdon,
        editedby, editedon, deleted, deletedon,
        deletedby, publishedon, publishedby,
        menutitle, donthit, privateweb, privatemgr,
        content_dispo, hidemenu, class_key, context_key,
        content_type, uri, uri_override, hide_children_in_tree,
        show_in_tree, properties)
        VALUES (NULL, 'document', 'text/html', '".$row['title']."', '".$row['title']."', '', '".encodestring($row['title'])."',
         '', true, 0, 0, ".$parent.", false, '', '', true, ".modx_template_category.", 1, true, true, 1, 1421901846, 0, 0, false, 0, 0, 1421901846, 1, '',
         false, false, false, false, false, 'modDocument', 'web', 1, '".encodestring($row['title']).".html', false, false, true, null);

;";
         echo $sql_incert;
         $modx->query($sql_incert);
     }


    // - 4 -
    $sql="select p.title, c.title title_category, m.id from s_products p
join s_category c
  on p.category=c.id

  join modx_site_content m
  on m.pagetitle=c.title;";
    foreach($modx->query($sql) as $row) {
        $sql_incert="INSERT INTO modx_site_content
    (id, type, contentType, pagetitle, longtitle,
            description, alias, link_attributes,
            published, pub_date, unpub_date, parent,
            isfolder, introtext, content, richtext,
            template, menuindex, searchable,
            cacheable, createdby, createdon,
            editedby, editedon, deleted, deletedon,
            deletedby, publishedon, publishedby,
            menutitle, donthit, privateweb, privatemgr,
            content_dispo, hidemenu, class_key, context_key,
            content_type, uri, uri_override, hide_children_in_tree,
            show_in_tree, properties)
            VALUES (NULL, 'document', 'text/html', '".$row['title']."', '".$row['title']."', '', '".encodestring($row['title'])."',
             '', true, 0, 0, ".$row['id'].", false, '', '', true, ".modx_template_product.", 1, true, true, 1, 1421901846, 0, 0, false, 0, 0, 1421901846, 1, '',
             false, false, false, false, false, 'modDocument', 'web', 1, '".encodestring($row['title']).".html', false, false, true, null);

    ;";
        echo $sql_incert;
        $modx->query($sql_incert);
    }

    $sql="
update s_products p1,(select * from modx_site_content o
        ) t1
  set p1.doc_id=t1.id, p1.category=t1.parent
  where p1.title=t1.pagetitle;";
    $modx->query($sql);

        $sql="
update s_category p1,(select * from modx_site_content o
        ) t1
  set p1.doc_id=t1.id
  where p1.title=t1.pagetitle;";
    $modx->query($sql);



}

function Import_PRICE_KROSS()
{
    global $modx;

    $today = date("Y-m-d_H_i_s");
    echo "-------------------------------------------------------------------";
    echo "*******************************************************************";
    echo $today;
    echo "*******************************************************************";
    include "csv.php";

    //var_dump($_FILES);
    //var_dump($_POST);

    $uploaddir = $_SERVER['DOCUMENT_ROOT'].'/imports/';
    $uploadfile = $uploaddir . basename($_FILES['importFile']['name']);

    echo  '<pre>';
    if (move_uploaded_file($_FILES['importFile']['tmp_name'], $uploadfile)) {
        echo  "Файл корректен и был успешно загружен.\n";
        $bk_file= $uploaddir."history/".$today."_".$_SERVER['REMOTE_ADDR']."_".basename($_FILES['importFile']['name']);
        echo $bk_file."<br>";
        copy($uploadfile,$bk_file);
        echo exec("gzip ".$bk_file)."<br>";
        try {

            echo "Открываем наш csv.<br>";
            $csv = new CSV($uploadfile);

          //  $modx->query("TRUNCATE TABLE s_cross ;");
            /**
             * Чтение из CSV  (и вывод на экран)
             */

            $get_csv = $csv->getCSV();
            foreach ($get_csv as $value) { //Проходим по строкам

                //херим предыдущие (пока что)
                //$modx->query("TRUNCATE TABLE s_orders_labels;");
                $value[0]=cp1251_to_utf8($value[0]);
                $value[1]=cp1251_to_utf8($value[1]);
                $value[2]=cp1251_to_utf8($value[2]);




                //вставляем новую
                $sql="INSERT INTO `s_cross`
        (`osn_code`, `kross_code`)
         VALUES
         ('".($value[0])."', '".($value[1])."');";
                //  echo  "Таких брендов нет, вставлям новый: ".$sql. "<br/>";
                $modx->query($sql);
                echo  $sql."<br>";

            }
        }
        catch (Exception $e) { //Если csv файл не существует, выводим сообщение
            echo  "Ошибка: " . $e->getMessage();
        }
    } else {
        echo  "Возможная атака с помощью файловой загрузки!\n";
    }



}


function Insertcategory($s,$parent)
{
    global $modx;

    if($s!="")
    {

        $tt=explode(":",$s);
        echo $s."<br>";;
        //если все еще есть элементы
        if ((count($tt)>0))
        {
            //проверяем 0 элемент
            echo  "ищем кол-во брендов с таким парентом<br>";
            $sql="select count(*) cc from  s_category
        where (title='".$tt[0]."')AND(parent=".$parent.");";
             echo  $sql."<br>";
            $cc=0;
            foreach($modx->query($sql) as $row)
            {
                $cc=$row['cc']+0;
            }
            echo  "Кол0во брендов: ".$cc."<br>";
            if($cc==0)
            {

                $sql="INSERT INTO `s_category`
    (`id`, `parent`, `title`, `longtitle`, `doc_id`)
     VALUES
     (NULL,'".$parent."', '".mysql_escape_string($tt[0])."', '".mysql_escape_string($tt[0])."','0');";
                  echo  "Таких брендов нет, вставлям новый: ".$sql. "<br/>";
                $modx->query($sql);
                 echo  $sql."<br>";
                $l_id = $modx->lastInsertId();
            }
            else
            {
                $sql="select id from  s_category where
             (title='".$tt[0]."')AND(parent=".$parent.");";
                echo  $sql."<br>";
                foreach($modx->query($sql) as $row) {
                    $l_id=$row['id'];
                }
            }
            unset($tt[0]);
            $tt=implode(":",$tt);
            Insertcategory($tt,$l_id);
        }
    }
}

function Import_PRICE_ROST()
{
    global $modx;

    $today = date("Y-m-d_H_i_s");
    echo "-------------------------------------------------------------------";
    echo "*******************************************************************";
    echo $today;
    echo "*******************************************************************";
    include "csv.php";

    //var_dump($_FILES);
    //var_dump($_POST);

    $uploaddir = $_SERVER['DOCUMENT_ROOT'].'/imports/';
    $uploadfile = $uploaddir . basename($_FILES['importFile']['name']);

    echo  '<pre>';
    if (move_uploaded_file($_FILES['importFile']['tmp_name'], $uploadfile)) {
        echo  "Файл корректен и был успешно загружен.\n";
        $bk_file= $uploaddir."history/".$today."_".$_SERVER['REMOTE_ADDR']."_".basename($_FILES['importFile']['name']);
        echo $bk_file."<br>";
        copy($uploadfile,$bk_file);
        echo exec("gzip ".$bk_file)."<br>";
        try {
            //   $csv = new CSV($uploadfile); //Открываем наш csv
            $csv = new CSV($uploadfile); //Открываем наш csv
            /**
             * Чтение из CSV  (и вывод на экран)
             */

            $get_csv = $csv->getCSV();

            //много однотипных запросов база блокирует
            $cat='';//имя категории



            $modx->query("TRUNCATE TABLE s_category ;");

            $modx->query("TRUNCATE TABLE s_orders_labels;");
            $modx->query("TRUNCATE TABLE s_product_count;");
            $modx->query("TRUNCATE TABLE tem1;");
            $modx->query("TRUNCATE TABLE s_options;");
            $modx->query("TRUNCATE TABLE s_category_features;");
            $modx->query("TRUNCATE TABLE s_features;");
            $modx->query("TRUNCATE TABLE s_products;");
            $modx->query("TRUNCATE TABLE s_products_category;");



            //Для полной очистки базы раскоментить
            /*




            $modx->query("TRUNCATE TABLE s_orders;");
            $modx->query("TRUNCATE TABLE s_purchases;");
*/

            // - Заполнем категории -
            foreach ($get_csv as $value) { //Проходим по строкам


                $value[2]=cp1251_to_utf8($value[2]);
                $value[3]=cp1251_to_utf8($value[3]);
                $value[4]=cp1251_to_utf8($value[4]);

                //Заполняем категории если таковых не имеем


                // - 1 - ищем id группы
                /// echo  "- Новая группа - ".$value[2]."<br>";
                if(GetCountGr($value[3])>0)
                {
                    echo "ищем id группы<br>";

                    $sql="select id from  s_category where title='".$value[3]."';";
                    foreach($modx->query($sql) as $row) {
                        $parrent=$row['id'];
                    }

                }
                else
                {
                    $sql="INSERT INTO `s_category`
    (`id`, `parent`, `title`, `longtitle`, `doc_id`)
     VALUES
     (NULL, '0', '".mysql_escape_string($value[3])."', '".mysql_escape_string($value[3])."','0');";
                   echo  $sql. "<br/>";
                    $modx->query($sql);
                    $parrent = $modx->lastInsertId();
                }

                 if(GetCountGr($value[4])==0)
                 {
                     $sql="INSERT INTO `s_category`
    (`id`, `parent`, `title`, `longtitle`, `doc_id`)
     VALUES
     (NULL, '$parrent', '".mysql_escape_string($value[4])."', '".mysql_escape_string($value[4])."','0');";
                     echo  $sql. "<br/>";
                     $modx->query($sql);
                 }



            }



            // - Заполнем товары -
            // - Все категории уже заполнены

            $count=0;
            foreach ($get_csv as $value) { //Проходим по строкам

                $value[0]=cp1251_to_utf8($value[0]);
                $value[1]=cp1251_to_utf8($value[1]);
                $value[2]=cp1251_to_utf8($value[2]);
                $value[3]=cp1251_to_utf8($value[3]);
                $value[4]=cp1251_to_utf8($value[4]);
                $value[5]=cp1251_to_utf8($value[5]);
                $value[6]=cp1251_to_utf8($value[6]);
                $value[7]=cp1251_to_utf8($value[7]);
                $value[8]=cp1251_to_utf8($value[8]);
                $value[9]=cp1251_to_utf8($value[9]);
                $value[10]=cp1251_to_utf8($value[10]);
                $value[11]=cp1251_to_utf8($value[11]);
                $value[12]=cp1251_to_utf8($value[12]);
                $value[13]=cp1251_to_utf8($value[13]);

/*
                //Проверяем фотки
                $PhotoDir = $_SERVER['DOCUMENT_ROOT'].'/files/goods/';
                $Photo_f="250_".rus2translit($value[18])."_f.jpg";
                $Photo_d="250_".rus2translit($value[18])."_d.jpg";
                $Photo_o="250_".rus2translit($value[18])."_o.jpg";
                $Photo_o2="250_".rus2translit($value[18])."_o2.jpg";
                $Photo_a="250_".rus2translit($value[18])."_a.jpg";
                $Photo_a2="250_".rus2translit($value[18])."_a2.jpg";
*/
                $fActive=true;
                /*
                if(file_exists($PhotoDir.$Photo_f))
                {

                    $fActive=true;
                }
                elseif(file_exists($PhotoDir.$Photo_d))
                {
                    $fActive=true;
                }
                elseif(file_exists($PhotoDir.$Photo_o))
                {
                    $fActive=true;
                }
                elseif(file_exists($PhotoDir.$Photo_o2))
                {
                    $fActive=true;
                }
                elseif(file_exists($PhotoDir.$Photo_a))
                {
                    $fActive=true;
                }
                elseif(file_exists($PhotoDir.$Photo_a2))
                {
                    $fActive=true;
                }
                */

                if ($fActive) {

                  //  $value[4] = '';
                  //  $value[5] = '';

                    echo "<br><br> -----------  товар " . $value[1] . " ----------------------<br>";
/*
                    //Заполняем пустоты
                    if($value[2]=="")
                    {
                        $value[2]=$value[3];
                        $value[3]=$value[4];

                        $value[4]="";

                    }

                    if($value[3]=="")
                    {
                        $value[3]=$value[4];

                        $value[4]="";
                    }
*/
                    $sku = $value[0]; //артикл

                    if ($value[4] != "") {
                        echo "ищем id группы<br>";

                        foreach ($modx->query("select id from  s_category where title='" . $value[4] . "';") as $row) {
                            $GrID = $row['id'];
                            $parent = $GrID; //получили id атегории товара
                        }

                    }

                    echo "Ищем по артикулу уже занесенный товар и обновляем запись по нему" . "<br/>";
                    $sql = "
                select p.id id from s_products p

                where p.articul like '" . $sku . "'";
                    echo $sql . "<br/>";
                    $product_id = 0;
                    foreach ($modx->query($sql) as $row) {
                        $product_id = $row['id'];
                        echo $row['id'] . "<br>";
                    }
                    $category_id = $parent;

                    if ($product_id == 0) {

                        echo " - такого товара нету -" . "<br/>";
                        echo " - Вставляем товар -" . "<br/>";
                        $sql = "INSERT INTO `s_products`
                        (`id`, `articul`, `category`, `title`,`longtitle`,`price1`,`price2`, `p_count`,`img`,`ed`)
                    VALUES
                    (NULL
                    ,'" . mysql_escape_string($value[0]) . "'
                    ,'" . $category_id . "'
                    ,'" . mysql_escape_string($value[1]) . "'
                    ,'" . mysql_escape_string($value[1]) . "'
                    ,'" . mysql_escape_string($value[5]) . "'
                    ,'" . mysql_escape_string($value[6]) . "'
                    ,'" . mysql_escape_string($value[7]) . "'
                    ,'" . mysql_escape_string($value[11]) . "'
                    ,'" . mysql_escape_string($value[10]) . "'

                    );";

                        echo  $sql . "<br/>";
                        $modx->query($sql);
                        $lastId = $modx->lastInsertId();
                        $product_id = $lastId;



                        echo  "-------------------------------------------------------------" . "<br/>";
                        echo  "Вставляем свойства товара" . "<br/>";
                        $value[11] = cp1251_to_utf8($value[11]);
                       // InsertFeature($value[11], $product_id, $category_id);
                        echo  "////////////////////////////////////////////////////////////";

                    }

                    //временная таблица для отбора старых товаров, которые удалили из бызы
                  //  $sql_t = "INSERT INTO `tem1` (`kk`,`sku`) VALUES ('$product_id','$sku');";
                  //  echo $sql_t . "<br/>";
                  //  $modx->query($sql_t);
                  //  print_r($modx->errorInfo());
                }
            }
            // $modx->query('UPDATE `s_variants` SET `sku` = REPLACE(`sku`,"С","C" )');


            //Убираем товары которые на загрузились
/*
            foreach ($get_csv as $value)
            {
                $art=$value[0];
                $modx->query('INSERT INTO `tem1` (`id`) VALUES ("$art")');


                $sql="select p.id id from s_products p
                join s_variants v
                on
                v.product_id= p.id where v.sku like '".$art."'";
                echo $sql. "<br/>";
            }

            //Удаляем записи которые не были загружены из файла

            $sql="
                delete from s_products
                where id in

                (
                select id from (
                select

                    *
                    from s_products p
                left join tem1 t
                on t.kk = p.id

                ) d  where kk is null
                )
";
            echo $sql."<br>";
            $modx->query($sql);

            $sql="delete from s_category where name=''";
            $modx->query($sql);


            //---------------------------------------------------------------
            //---------------------------------------------------------------
            //Специально убираем в радиаторы KERMI и BUDERUS

            // - 1 - ищем id атегории радиаторов
            $sql='update s_products_category
            set category_id=(SELECT id FROM s_category where name="РАДИАТОРЫ")
            where
            category_id=(
            SELECT id FROM s_category
            where name="KERMI#Германия"
                )';
            $modx->query($sql);



            $sql='update s_products_category
            set category_id=(SELECT id FROM s_category where name="РАДИАТОРЫ")
            where
            category_id=(
            SELECT id FROM s_category
            where name="BUDERUS#Германия"
            )';

            $sql='update s_products_category
            set category_id=(SELECT id FROM s_category where name="РАДИАТОРЫ")
            where
            category_id=(
            SELECT id FROM s_category
            where name="Комплектующие  GABI PLUS#Италия"
            )';


            $modx->query($sql);

            $sql="DELETE FROM `s_category` WHERE `name` = 'BUDERUS#Германия'";
            $modx->query($sql);

            $sql="DELETE FROM `s_category` WHERE `name` = 'KERMI#Германия'";
            $modx->query($sql);

            $sql="DELETE FROM `s_category` WHERE `name` = 'Комплектующие  GABI PLUS#Италия'";
            $modx->query($sql);

*/
            //----------------------------------
            // херим пустые категории
            $sql="delete from s_category
WHERE id in ( select id from
(
select c.id
    from s_category c
  left join s_products_category ps
  on ps.category_id=c.id

    where (ps.category_id is null)and(c.parent_id>0)
) tmptable
)
;";

            $modx->query($sql);
/*

            //меняем наименования из поля наименования
            $sql='
            update s_products p1,(select * from s_options o
            join s_features f
            on f.id=o.feature_id
            where f.name="Наименование") t1
            set p1.name=t1.value
            where p1.id=t1.product_id
            ;
            ';

            $modx->query($sql);

*/
             UpdateModxStructure();
            //---------------------------------------------------------------
            //---------------------------------------------------------------

        }
        catch (Exception $e) { //Если csv файл не существует, выводим сообщение
            echo  "Ошибка: " . $e->getMessage();
        }
    } else {
        echo  "Возможная атака с помощью файловой загрузки!\n";
    }

    echo "<h3>Кол-во загруженных товаров: ".$count."</h3>";
    echo  'Некоторая отладочная информация:';
    // print_r($_FILES);

    print "</pre>";
}

//загрузка списка филиалов
function Import_Filial()
{
    global $modx;

    $today = date("Y-m-d_H_i_s");
    echo "-------------------------------------------------------------------";
    echo "*******************************************************************";
    echo $today;
    echo "*******************************************************************";
    include "csv.php";

    //var_dump($_FILES);
    //var_dump($_POST);

    $uploaddir = $_SERVER['DOCUMENT_ROOT'].'/imports/';
    $uploadfile = $uploaddir . basename($_FILES['importFile']['name']);

    echo  '<pre>';
    if (move_uploaded_file($_FILES['importFile']['tmp_name'], $uploadfile)) {
        echo  "Файл корректен и был успешно загружен.\n";
        $bk_file= $uploaddir."history/".$today."_".$_SERVER['REMOTE_ADDR']."_".basename($_FILES['importFile']['name']);
        echo $bk_file."<br>";
        copy($uploadfile,$bk_file);
        try {
            //   $csv = new CSV($uploadfile); //Открываем наш csv
            $csv = new CSV($uploadfile); //Открываем наш csv
            $get_csv = $csv->getCSV();
            $modx->query("TRUNCATE TABLE s_filials;");
            foreach ($get_csv as $value) { //Проходим по строкам
                /*
                                echo  "Код: " . cp1251_to_utf8($value[0]) . "<br/>";
                                echo  "Наименование кат: " .cp1251_to_utf8($value[1])  . "<br/>";
                */

                $value[0]=cp1251_to_utf8(mysql_escape_string($value[0]));
                $value[1]=cp1251_to_utf8(mysql_escape_string($value[1]));
                $value[2]=cp1251_to_utf8(mysql_escape_string($value[2]));
                $value[3]=cp1251_to_utf8(mysql_escape_string($value[3]));
                $value[4]=cp1251_to_utf8(mysql_escape_string($value[4]));
                $value[5]=cp1251_to_utf8(mysql_escape_string($value[5]));
                $value[6]=cp1251_to_utf8(mysql_escape_string($value[6]));

                if($value[0]!="КОД")
                {
                    $sql="INSERT INTO `s_filials`
        (`id`, `keycod`, `caption`, `address`, `timework`, `email`, `phone`, `person`)
         VALUES
         (NULL
         , '".$value[0]."'
         , '".$value[1]."'
         , '".$value[2]."'
         , '".$value[3]."'
         , '".$value[4]."'
         , '".$value[5]."'
         , '".$value[6]."'

          );";
                    echo  "Вставляем филиал: <br/>";
                    echo  $sql. "<br/>";
                    $modx->query($sql);
                    $sql_d="INSERT INTO `s_delivery` (`id`, `name`, `description`, `free_from`, `price`, `enabled`, `position`, `separate_payment`)
VALUES (NULL, '".$value[1]."', '', '0', '0', '1', '0', NULL);
                  );";
                    $modx->query($sql_d);
                    echo $sql_d."<br>";
                }


            }

        }
        catch (Exception $e) { //Если csv файл не существует, выводим сообщение
            echo  "Ошибка: " . $e->getMessage();
        }
    } else {
        echo  "Возможная атака с помощью файловой загрузки!\n";
    }
}

function Import_DOSTAVKA()
{
    global $modx;

    $today = date("Y-m-d_H_i_s");
    echo "-------------------------------------------------------------------";
    echo "*******************************************************************";
    echo $today;
    echo "*******************************************************************";
    include "csv.php";

    //var_dump($_FILES);
    //var_dump($_POST);

    $uploaddir = $_SERVER['DOCUMENT_ROOT'].'/imports/';
    $uploadfile = $uploaddir . basename($_FILES['importFile']['name']);

    echo  '<pre>';
    if (move_uploaded_file($_FILES['importFile']['tmp_name'], $uploadfile)) {
        echo  "Файл корректен и был успешно загружен.\n";
        $bk_file= $uploaddir."history/".$today."_".$_SERVER['REMOTE_ADDR']."_".basename($_FILES['importFile']['name']);
        echo $bk_file."<br>";
        copy($uploadfile,$bk_file);
        try {
            //   $csv = new CSV($uploadfile); //Открываем наш csv
            $csv = new CSV($uploadfile); //Открываем наш csv
            $get_csv = $csv->getCSV();
            $sql="";
            $sql_d="";
            $modx->query("TRUNCATE TABLE s_dostavka;");
            $modx->query("TRUNCATE TABLE s_delivery_payment;");
            $modx->query("TRUNCATE TABLE s_delivery;");
            foreach ($get_csv as $value) { //Проходим по строкам
                /*
                                echo  "Код: " . cp1251_to_utf8($value[0]) . "<br/>";
                                echo  "Наименование кат: " .cp1251_to_utf8($value[1])  . "<br/>";
                */

                $value[0]=cp1251_to_utf8(mysql_escape_string($value[0]));
                $value[1]=cp1251_to_utf8(mysql_escape_string($value[1]))+0;



                $sql.="INSERT INTO `s_dostavka`
                (`id`, `place`, `price`)
                 VALUES
                 (NULL
                 , '".$value[0]."'
                 , '".$value[1]."'
                  );";

                $sql_d="INSERT INTO `s_delivery` (`id`, `name`, `description`, `free_from`, `price`, `enabled`, `position`, `separate_payment`)
VALUES (NULL, '".$value[0]."', '', '1000000', '".$value[1]."', '1', '0', '0');
                  );";
                $modx->query($sql_d);
                echo $sql_d."<br>";
                $lastId = $modx->lastInsertId();
                $sql_dp="INSERT INTO `s_delivery_payment` (`delivery_id`, `payment_method_id`) VALUES ('$lastId', '1');";
                $modx->query($sql_dp);echo $sql_dp."<br>";

                $sql_dp="INSERT INTO `s_delivery_payment` (`delivery_id`, `payment_method_id`) VALUES ('$lastId', '13');";
                $modx->query($sql_dp);echo $sql_dp."<br>";
                $sql_dp="INSERT INTO `s_delivery_payment` (`delivery_id`, `payment_method_id`) VALUES ('$lastId', '14');";
                $modx->query($sql_dp);echo $sql_dp."<br>";

            }
            $modx->query($sql);

            $sql_d="INSERT INTO `s_delivery` (`id`, `name`, `description`, `free_from`, `price`, `enabled`, `position`, `separate_payment`)
VALUES (0, 'Экспресс доставка', '', '1000000', '500', '1', '0', '0');";

            $modx->query($sql_d);
            $sql_d="UPDATE `s_delivery` SET `id` = '1000' WHERE `name` = 'Экспресс доставка';";
            $modx->query($sql_d);
            $sql_dp="INSERT INTO `s_delivery_payment` (`delivery_id`, `payment_method_id`) VALUES ('1000', '1');";
            $modx->query($sql_dp);echo $sql_dp."<br>";

            $sql_dp="INSERT INTO `s_delivery_payment` (`delivery_id`, `payment_method_id`) VALUES ('1000', '13');";
            $modx->query($sql_dp);echo $sql_dp."<br>";
            $sql_dp="INSERT INTO `s_delivery_payment` (`delivery_id`, `payment_method_id`) VALUES ('1000', '14');";
            $modx->query($sql_dp);echo $sql_dp."<br>";
        }
        catch (Exception $e) { //Если csv файл не существует, выводим сообщение
            echo  "Ошибка: " . $e->getMessage();
        }
    } else {
        echo  "Возможная атака с помощью файловой загрузки!\n";
    }

}

function UploadImage()
{
    $uploaddir = $_SERVER['DOCUMENT_ROOT'].'/files/goods/';
    echo ($_FILES['importFile']['name'])."<br>";
    $FileName=rus2translit(($_FILES['importFile']['name']));
    echo "<pre>";
    var_dump($_FILES);
    echo "</pre>";
    echo "Start UPLOAD :".$FileName;

    if (move_uploaded_file($_FILES['importFile']['tmp_name'], $uploaddir.$FileName)) {
        // echo  "Файл корректен и был успешно загружен.\n";
        include('classSimpleImage.php');
        $image = new SimpleImage();
        $image->load($uploaddir.$FileName);
        $image->resizeToWidth(250);
        if("250_".$FileName!='250__d.jpg')
            $image->save($uploaddir."250_".$FileName);

        $image->resizeToWidth(100);
        $image->save($uploaddir."100_".$FileName);

        echo "UPLOAD $FileName DONE";

    }


}


function GetOrders()
{
    global $modx;
    /*
    echo   json_encode(array("caption"=>"GetOrders"));

    $sql="SELECT id,name FROM s_payment_methods where enabled=1";
    foreach($modx->query($sql) as $row) {
        echo "<pre>";

        echo   json_encode($row);
        echo "</pre>";
    }*/
    $sql='SELECT
o.name,
o.address,
o.phone,
o.email,
o.date,
o.id order_id,
p.product_name,
p.price,
p.amount,
p.sku
,o.status


FROM s_purchases p
join s_orders o
on o.id=p.order_id

where o.status < 2';

    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=data.csv');

// create a file pointer connected to the output stream
    $output = fopen('php://output', 'w');

// output the column headings
    fputcsv($output, array('name', 'address', 'phone', 'email', 'date', 'order_id', 'product_name', 'price', 'amount', 'sku','status'),";"," ");
    foreach($modx->query($sql) as $row) {

        $tt['name']= iconv("utf-8", "windows-1251", $row['name']);
        $tt['address']= iconv("utf-8", "windows-1251", $row['address']);
        $tt['phone']= iconv("utf-8", "windows-1251", $row['phone']);
        $tt['email']= iconv("utf-8", "windows-1251", $row['email']);
        $tt['date']= iconv("utf-8", "windows-1251", $row['date']);
        $tt['order_id']= iconv("utf-8", "windows-1251", $row['order_id']);
        $tt['product_name']= iconv("utf-8", "windows-1251", $row['product_name']);
        $tt['price']= iconv("utf-8", "windows-1251", $row['price']);
        $tt['amount']= iconv("utf-8", "windows-1251", $row['amount']);
        $tt['sku']= iconv("utf-8", "windows-1251", $row['sku']);

        if($row['status']=='0')
        {
            $tt['status']= iconv("utf-8", "windows-1251", 'Новый');
        }
        else
        {
            $tt['status']= iconv("utf-8", "windows-1251", 'Оплачен');
        }


        fputcsv($output, $tt,";"," ");

    }

    fclose($output);

}


function ImportFILTR()
{
    global $modx;

    $today = date("Y-m-d_H_i_s");
    echo "-------------------------------------------------------------------";
    echo "*******************************************************************";
    echo $today;
    echo "*******************************************************************";
    include "csv.php";

    //var_dump($_FILES);
    //var_dump($_POST);

    $uploaddir = $_SERVER['DOCUMENT_ROOT'].'/imports/';
    $uploadfile = $uploaddir . basename($_FILES['importFile']['name']);

    echo  '<pre>';
    if (move_uploaded_file($_FILES['importFile']['tmp_name'], $uploadfile)) {
        echo  "Файл корректен и был успешно загружен.\n";
        $bk_file= $uploaddir."history/".$today."_".$_SERVER['REMOTE_ADDR']."_".basename($_FILES['importFile']['name']);
        echo $bk_file."<br>";
        copy($uploadfile,$bk_file);
        try {
            //   $csv = new CSV($uploadfile); //Открываем наш csv
            $csv = new CSV($uploadfile); //Открываем наш csv
            $get_csv = $csv->getCSV();
            $sql="";
            $sql_d="";
            $modx->query("TRUNCATE TABLE s_filtr;");

            foreach ($get_csv as $value) { //Проходим по строкам
                /*
                                echo  "Код: " . cp1251_to_utf8($value[0]) . "<br/>";
                                echo  "Наименование кат: " .cp1251_to_utf8($value[1])  . "<br/>";
                */

                $value[0]=cp1251_to_utf8(mysql_escape_string($value[0]));
                $value[1]=cp1251_to_utf8(mysql_escape_string($value[1]));
                $value[2]=cp1251_to_utf8(mysql_escape_string($value[2]));
                $value[3]=cp1251_to_utf8(mysql_escape_string($value[3]))+0;

                $sql="INSERT INTO `s_filtr`
                (`id`, `catalog`, `filtr`, `f_value`, `f_type`)
                 VALUES
                 (NULL, '".$value[0]."', '". $value[1]."', '". $value[2]."', '". $value[3]."');";
                echo $sql."<br>";
                $modx->query($sql);



            }



        }
        catch (Exception $e) { //Если csv файл не существует, выводим сообщение
            echo  "Ошибка: " . $e->getMessage();
        }
    } else {
        echo  "Возможная атака с помощью файловой загрузки!\n";
    }


}

function GetUsers()
{
    global $modx;
    /*
    echo   json_encode(array("caption"=>"GetOrders"));

    $sql="SELECT id,name FROM s_payment_methods where enabled=1";
    foreach($modx->query($sql) as $row) {
        echo "<pre>";

        echo   json_encode($row);
        echo "</pre>";
    }*/
    $sql='SELECT * FROM s_users';

    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=data.csv');

// create a file pointer connected to the output stream
    $output = fopen('php://output', 'w');

// output the column headings
    fputcsv($output, array('name', 'address', 'phone', 'email', 'coupon', 'enabled'),";"," ");
    foreach($modx->query($sql) as $row) {

        $tt['name']= iconv("utf-8", "windows-1251", $row['name']);
        $tt['address']= iconv("utf-8", "windows-1251", $row['address']);
        $tt['phone']= iconv("utf-8", "windows-1251", $row['phone']);
        $tt['email']= iconv("utf-8", "windows-1251", $row['email']);
        $tt['coupon']= iconv("utf-8", "windows-1251", $row['coupon']);
        $tt['enabled']= iconv("utf-8", "windows-1251", $row['enabled']);

        fputcsv($output, $tt,";"," ");

    }

    fclose($output);

}

//загрузка цветочков
function import_FLOWERS()
{
    global $modx;

    $today = date("Y-m-d_H_i_s");
    echo "-------------------------------------------------------------------";
    echo "*******************************************************************";
    echo $today;
    echo "*******************************************************************";
    include "csv.php";

    //var_dump($_FILES);
    //var_dump($_POST);

    $uploaddir = $_SERVER['DOCUMENT_ROOT'].'/imports/';
    $uploadfile = $uploaddir . basename($_FILES['importFile']['name']);

    echo  '<pre>';
    if (move_uploaded_file($_FILES['importFile']['tmp_name'], $uploadfile)) {
        echo  "Файл корректен и был успешно загружен.\n";
        $bk_file= $uploaddir."history/".$today."_".$_SERVER['REMOTE_ADDR']."_".basename($_FILES['importFile']['name']);
        echo $bk_file."<br>";
        copy($uploadfile,$bk_file);
        echo exec("gzip ".$bk_file)."<br>";
        try {
            //   $csv = new CSV($uploadfile); //Открываем наш csv
            $csv = new CSV($uploadfile); //Открываем наш csv
            /**
             * Чтение из CSV  (и вывод на экран)
             */

            $get_csv = $csv->getCSV();

            //много однотипных запросов база блокирует
            $cat='';//имя категории



           /* $modx->query("TRUNCATE TABLE s_category ;");

            $modx->query("TRUNCATE TABLE s_orders_labels;");
            $modx->query("TRUNCATE TABLE s_product_count;");
            $modx->query("TRUNCATE TABLE tem1;");
            $modx->query("TRUNCATE TABLE s_options;");
            $modx->query("TRUNCATE TABLE s_category_features;");
            $modx->query("TRUNCATE TABLE s_features;");
            $modx->query("TRUNCATE TABLE s_products;");
            $modx->query("TRUNCATE TABLE s_products_category;");*/

            foreach ($get_csv as $value)
            { //Проходим по строкам


            }


            }
        catch (Exception $e) { //Если csv файл не существует, выводим сообщение
            echo  "Ошибка: " . $e->getMessage();
        }
    } else {
        echo  "Возможная атака с помощью файловой загрузки!\n";
    }

    echo "<h3>Кол-во загруженных товаров: ".$count."</h3>";
    echo  'Некоторая отладочная информация:';
    // print_r($_FILES);

    echo "</pre>";
}

function EmptyAction()
{
?>
<div class="container">
    <form enctype="multipart/form-data" method="POST">
        <input type="hidden" name="action" value="import">

        <div class="form-group">
            <label>Файл для загрузки</label>
            <input type="file" name="importFile">
            <p class="help-block">Загрузите файл:</p>
        </div>

        <button type="submit" class="btn btn-default">Загрузить</button>
    </form>
</div>
<?php
}


function RunImport()
{
    if(!empty($_FILES))
    {
        if(basename($_FILES['importFile']['name'])=="import_0945.csv")
        {

            Import_PRICE_ROST();

        }
        elseif(basename($_FILES['importFile']['name'])=="DC_IMS.csv")
        {

            Import_DC_IMS();

        }
        elseif(basename($_FILES['importFile']['name'])=="PRICE_KROSS.csv")
        {

            Import_PRICE_KROSS();

        }
        elseif(basename($_FILES['importFile']['name'])=="FILIAL.csv")
        {

            Import_Filial();

        }
        elseif(basename($_FILES['importFile']['name'])=="DOSTAVKA.csv")
        {

            Import_DOSTAVKA();

        }
        elseif(basename($_FILES['importFile']['name'])=="FILTR.csv")
        {

            ImportFILTR();

        }
        else
        {

            UploadImage();
        }
    }
    elseif(isset($_GET['action'])and($_GET['action']=="GetOrders"))
    {
        GetOrders();
    }
    elseif(isset($_GET['action'])and($_GET['action']=="GetUsers"))
    {
        GetUsers();
    }

    else
    {
        EmptyAction();
    }
}


include "../templates/head.php";
?>

<body>

<?php
RunImport();
?>
</body>
</html>


