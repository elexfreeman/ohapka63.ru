<?php

define('MODX_API_MODE', true);


define('upload_dir', '/files/goods/');


require 'index.php';
if (!defined('MODX_API_MODE')) {
    define('MODX_API_MODE', true);
}
@include(dirname(dirname(__FILE__)) . '/config.core.php');
if (!defined('MODX_CORE_PATH'))
    define('MODX_CORE_PATH', dirname(dirname(__FILE__)) . '/core/');
@include_once (MODX_CORE_PATH . "model/modx/modx.class.php");
$modx = new modX();
$modx->initialize('web');



function OrderCommit()
    {
        global $modx;

//-----------------------------------------------------------------------
//-----------------------------------------------------------------------
    // - 1 - добавляем получателя в БАЗУ

    $receiver_name = 0;
    if (isset($_GET['receiver_name'])) $receiver_name = $_GET['receiver_name'];

    $receiver_phone = 0;
    if (isset($_GET['receiver_phone'])) $receiver_phone = $_GET['receiver_phone'];

    $receiver_sity = 0;
    if (isset($_GET['receiver_sity'])) $receiver_sity = $_GET['receiver_sity'];

    $receiver_street = 0;
    if (isset($_GET['receiver_street'])) $receiver_street = $_GET['receiver_street'];

    $receiver_house = 0;
    if (isset($_GET['receiver_house'])) $receiver_house = $_GET['receiver_house'];

    $receiver_corpus = 0;
    if (isset($_GET['receiver_corpus'])) $receiver_corpus = $_GET['receiver_corpus'];

    $receiver_podezd = 0;
    if (isset($_GET['receiver_podezd'])) $receiver_podezd = $_GET['receiver_podezd'];

    $receiver_etaj = 0;
    if (isset($_GET['receiver_etaj'])) $receiver_etaj = $_GET['receiver_etaj'];

    $receiver_corpus = 0;
    if (isset($_GET['receiver_corpus'])) $receiver_corpus = $_GET['receiver_etaj'];

    $receiver_kvartira = 0;
    if (isset($_GET['receiver_kvartira'])) $receiver_kvartira = $_GET['receiver_kvartira'];

    $receiver_domofon_code = 0;
    if (isset($_GET['receiver_domofon_code'])) $receiver_domofon_code = $_GET['receiver_domofon_code'];

    $receiver_free_photo = 0;
    if (isset($_GET['receiver_free_photo'])) $receiver_free_photo = $_GET['receiver_free_photo'];

    $receiver_photo = 0;
    if (isset($_GET['receiver_photo'])) $receiver_photo = $_GET['receiver_photo'];



    // - 2 - оформляем заказ
    $max = 10;
    $chars = "qazxswedcvfrtgbnhyujmkip23456789QAZXSWEDCVFRTGBNHYUJMKLP";
    // Количество символов в пароле.

    // Определяем количество символов в $chars
    $size = StrLen($chars) - 1;

    // Определяем пустую переменную, в которую и будем записывать символы.
    $url = null;

    // Создаём url.
    while ($max--)
        $url .= $chars[rand(0, $size)];


    $coupon_code = 0;
    if (isset($_SESSION['coupon_code'])) $coupon_code = $_SESSION['coupon_code'];

    $coupon_value = 0;
    if (isset($_SESSION['coupon_value'])) $coupon_value = $_SESSION['coupon_value'];

    $user_fio = '';
    if (isset($_GET['user_fio'])) $user_fio = mysql_escape_string($_GET['user_fio']);

    $user_email = '';
    if (isset($_GET['user_email'])) $user_email = mysql_escape_string($_GET['user_email']);

    $user_phone = '';
    if (isset($_GET['user_phone'])) $user_phone = mysql_escape_string($_GET['user_phone']);

    $delivery_date = 0;
    if (isset($_GET['delivery_date'])) $delivery_date = mysql_escape_string($_GET['delivery_date']);

    //Чекаем корректность полей
    //echo $user_fio;
    $request['status']=0;
    if($user_fio=='')
    {
        $request['status_text']='Введите ФИО';
    }
    elseif($user_email=='')
    {
        $request['status_text']='Введите email';
    }
    elseif($user_phone=='')
    {
        $request['status_text']='Введите телефон';
    }
    else
    {
        $request['status']=1;
        $user_remind_flag=0;
        $receiver_call=0;
        if (isset($_GET['user_remind_flag'])) $user_remind_flag = 1;
        if (isset($_GET['receiver_call'])) $receiver_call = 1;
        if (isset($_GET['receiver_free_photo'])) $receiver_free_photo = 1;
        if (isset($_GET['receiver_photo'])) $receiver_photo = 1;
        if (isset($_GET['w_akc'])) $w_akc = 1;
        if (isset($_GET['user_recall'])) $user_recall = 1;


        if (($_GET['receiver'] + 0) == 0) {
            $sql_receiver = "INSERT INTO `s_receiver`
                        (`id`,
                         `receiver_name`,
                         `receiver_phone`,
                          `receiver_sity`,
                          `receiver_street`,
                          `receiver_house`,
                          `receiver_corpus`,
                          `receiver_podezd`,
                          `receiver_etaj`,
                          `receiver_kvartira`,
                          `receiver_domofon_code`,
                          `receiver_free_photo`,
                          `receiver_photo`,
                          `user_id`
                         )
                    VALUES

                    (
                    NULL,
                    '" . $receiver_name . "',
                    '" . $receiver_phone . "',
                    '" . $receiver_sity . "',
                    '" . $receiver_street . "',
                    '" . $receiver_house . "',
                    '" . $receiver_corpus . "',
                    '" . $receiver_podezd . "',
                    '" . $receiver_etaj . "',
                    '" . $receiver_kvartira . "',
                    '" . $receiver_domofon_code . "',
                    '" . $receiver_free_photo . "',
                    '" . $receiver_photo . "',
                    '" . $modx->user->get('id') . "'


                    )
                    ";
            $modx->query($sql_receiver);
            $receiver_id = $modx->lastInsertId();
           // echo $sql_receiver . "<br/>";
            ;

        } else {
            $reciever = mysql_escape_string($_GET['receiver']);
            $sql_receiver = "UPDATE s_receiver SET `receiver_name` = '" . $receiver_name . "' WHERE id = " . $reciever;
            $sql_receiver .= ";UPDATE s_receiver SET `receiver_phone` = '" . $receiver_phone . "' WHERE id = " . $reciever;
            $sql_receiver .= ";UPDATE s_receiver SET `receiver_sity` = '" . $receiver_sity . "' WHERE id = " . $reciever;
            $sql_receiver .= ";UPDATE s_receiver SET `receiver_street` = '" . $receiver_street . "' WHERE id = " . $reciever;
            $sql_receiver .= ";UPDATE s_receiver SET `receiver_house` = '" . $receiver_house . "' WHERE id = " . $reciever;
            $sql_receiver .= ";UPDATE s_receiver SET `receiver_corpus` = '" . $receiver_corpus . "' WHERE id = " . $reciever;
            $sql_receiver .= ";UPDATE s_receiver SET `receiver_etaj` = '" . $receiver_etaj . "' WHERE id = " . $reciever;
            $sql_receiver .= ";UPDATE s_receiver SET `receiver_kvartira` = '" . $receiver_podezd . "' WHERE id = " . $reciever;
            $sql_receiver .= ";UPDATE s_receiver SET `receiver_domofon_code` = '" . $receiver_domofon_code . "' WHERE id = " . $reciever;
            $sql_receiver .= ";UPDATE s_receiver SET `receiver_free_photo` = '" . $receiver_free_photo . "' WHERE id = " . $reciever;
            $sql_receiver .= ";UPDATE s_receiver SET `receiver_photo` = '" . $receiver_photo . "' WHERE id = " . $reciever;

            $modx->query($sql_receiver);
            $receiver_id = $reciever;
            //echo $sql_receiver . "<br/>";
            ;

        }


//-----------------------------------------------------------------------
//-----------------------------------------------------------------------


        $sql = "INSERT INTO `s_orders`
                        (`id`,
                         `order_date`,
                         `delivery_date`,
                         `user_id`,
                          `coupon_code`,
                          `coupon_value`,
                          `user_fio`,
                          `user_phone`,
                          `user_email`,
                          `url`,
                          `receiver_id`,
                          `status`,
                          `user_remind_flag`,
                          `receiver_call`,
                          `receiver_free_photo`,
                          `receiver_photo`,
                          `w_akc`,
                          `user_recall`
                          )
                    VALUES
                    (NULL
                    ,NOW()
                    ,'" . $delivery_date . "'
                    ,'" . $modx->user->get('id') . "'
                    ,'" . $coupon_code . "'
                    ,'" . $coupon_value . "'
                    ,'" . $user_fio . "'
                    ,'" . $user_phone . "'
                    ,'" . $user_email . "'
                    ,'$url'
                    ,'$receiver_id'
                    ,'0',
                    '".$user_remind_flag."',
                    '".$receiver_call."',
                    '".$receiver_free_photo."',
                    '".$receiver_photo."',
                    '".$w_akc."',
                    '".$user_recall."'

                    );";

       //  echo  $sql . "<br/>";
        $modx->query($sql);
        $order_id = $modx->lastInsertId();

        $_SESSION['LastOrderID'] = $order_id;
        $_SESSION['LastOrderURL'] = $url;

//-----------------------------------------------------------------------
//-----------------------------------------------------------------------
        // - 3 - добавляем товары в заказ



        $summa = 0;

        $products = null;

        foreach ($_SESSION as $key1 => $value1) {


            if (substr($key1, 0, 3) == 'pro') {
                $product = null;
                $value1 = $value1 + 0;
                if ($value1 > 0) {
                    $kk = explode("_", $key1);
                    $sql = "select * from s_products WHERE id=" . $kk[1];
                    // echo $key1." ".$sql."<br>";
                    foreach ($modx->query($sql) as $row) {

                        //высчитываем картинку товара
                        $sql_mainimg = "select * from s_prices pr
                                            join s_products p
                                            on p.id=pr.product_id

                                            join s_images i
                                            on i.price_id=pr.id


                                            where (p.id=" . $row['id'] . ")and(pr.active=1)and(i.mainimg=1);";
                        foreach ($modx->query($sql_mainimg) as $rowIMain) {
                           // echo upload_dir . $rowIMain['filename'];
                            $product['img'] = $rowIMain['filename'];
                        }
                        //название букета


                        //высчитываем цену товара
                        $sql_mainimg = "select * from s_prices pr
                                            join s_products p
                                            on p.id=pr.product_id
                                            where (p.id=" . $row['id'] . ")and(pr.active=1);";

                        foreach ($modx->query($sql_mainimg) as $rowIMain) {
                            $product['price'] = $rowIMain['rub'];
                            $summa = $summa + ($rowIMain['rub'] * (0 + $value1));
                            // echo $summa;
                        }


                        $product['product_name'] = $row['title'];
                        $product['hit_flag'] = $row['hit_flag'];
                        $product['akcia_flag'] = $row['akcia_flag'];
                        $product['articul'] = $row['articul'];
                        $product['id'] = $row['id'];
                        $product['akcia_flag'] = $row['akcia_flag'];
                        $product['amount'] = $value1;

                    }
                    $products[] = $product;
                }


            }

        }

        $sql_insert = null;
        foreach ($products as $product) {
            $sql_insert .= "INSERT INTO `s_purchases`
                        (`id`,
                         `order_id`,
                         `product_name`,
                          `price`,
                          `amount`,
                          `articul`,
                          `img`,
                          `hit_flag`,
                          `akcia_flag`

                          )
                    VALUES
                    (NULL
                    ,'$order_id'
                    ,'" . $product['product_name'] . "'
                    ,'" . $product['price'] . "'
                    ,'" . $product['amount'] . "'
                    ,'" . $product['articul'] . "'
                    ,'" . $product['img'] . "'
                    ,'" . $product['hit_flag'] . "'
                    ,'" . $product['akcia_flag'] . "'
                    );";


        }


        //echo  $sql_insert . "<br/>";
        $modx->query($sql_insert);

        //сумма заказа
        $sql_update_summa = "UPDATE s_orders SET `summa` = '" . $summa . "' WHERE id = " . $order_id;
        //echo $sql_update_summa;
        $modx->query($sql_update_summa);
/*

        //херим сесионные данные заказа
        foreach ($_SESSION as $key => $value) {
            if (substr($key, 0, 3) == 'pro') {
                echo $key . " " . $value . " " . substr($key, 0, 3);
                unset($_SESSION[$key]);
            }
        }
*/
        $message = $modx->getChunk('OrderCommitEmail');



        $subject = "ваш заказ № " . $_SESSION['LastOrderID'];
        //отпраляем емаил
        $modx->getService('mail', 'mail.modPHPMailer');
        $modx->mail->set(modMail::MAIL_BODY, $message);
        $modx->mail->set(modMail::MAIL_FROM, $modx->getOption('emailsender'));

        $modx->mail->set(modMail::MAIL_FROM_NAME, $modx->getOption('site_name'));

        $modx->mail->set(modMail::MAIL_SENDER, $modx->getOption('emailsender'));

        $modx->mail->set(modMail::MAIL_SUBJECT, $subject);
        $modx->mail->address('to', $user_email);
        $modx->mail->address('reply-to', $adminEmail);
        $modx->mail->setHTML(true);
        if (!$modx->mail->send()) {
            $request['mailError']=1;
        }
        $modx->mail->reset();
        //---------------------------------------------------
        $request['status']=1;
        $request['url']=$url;
    }



    echo   json_encode($request);
    //echo   json_encode($_GET);
}


//Возвращает количество товаров в корзине
function GetCardCountProduct()
{
    $cc=0;
    foreach($_SESSION as $key=>$value)
    {
        if(substr($key,0,3)=='pro') $cc=$cc+$value;
        //echo $key." ".$value." ".substr($key,0,3);


    }
    return $cc;
}


if(isset($_GET['action']))
{
    if($_GET['action']=='product_photo')
    {
        ?>
    <img src="<?php
    $sql_img="select * from s_prices pr

join s_images i
 on i.price_id=pr.id

where (pr.id=".mysql_escape_string($_GET['id']).")and(i.mainimg=1);

";


        foreach($modx->query($sql_img) as $rowIMain)
        {
            echo upload_dir.$rowIMain['filename'];
        }
?>">
    <div class="product_photo_small">


           <?php
                $sql_img="select * from s_prices pr

join s_images i
 on i.price_id=pr.id

where (pr.id=".mysql_escape_string($_GET['id']).")and(i.mainimg=0);

";


                foreach($modx->query($sql_img) as $rowIMain)
                {
                    ?>
                    <div>
                        <img src="<?php echo upload_dir.$rowIMain['filename']; ?>">
                    </div>
                    <?php
                }
                ?>




    </div>
        <?php
    }

    //возвращает состав букета в виде печатания строки
    elseif($_GET['action']=='sostav_info')
    {

        $sql="select * from s_buket_flowers  b

join s_flowers f
on f.id=b.flower_id

where b.price_id=".mysql_escape_string($_GET['id']).";";
        foreach($modx->query($sql) as $rowI)
        {
            $tmp=$rowI['title']." ".$rowI['quantity']." шт,";
            echo substr($tmp, 0, -1);;

        }


    }

    //добавление в корзину
    elseif($_GET['action']=='AddToCard')
    {

       // if(isset($_SESSION['product_'.$_GET['product_id']]))
       // {
           // unset($_SESSION['product_'.$_GET['product_id']]);



            $count=$_SESSION['product_'.$_GET['product_id']]+0;
            $_SESSION['product_'.$_GET['product_id']]=$_SESSION['product_'.$_GET['product_id']]+1;//увеличиваем
            if($count==1) $ww=' букет ';
            elseif($count==2) $ww=' букета ';
            elseif($count==3) $ww=' букета ';
            elseif($count==4) $ww=' букета ';
            else $ww=' букетов ';


        //вычисляем сумму
        //----------------------------------------------------------
        //----------------------------------------------------------
        $summa=0;

        foreach($_SESSION as $key1=>$value1)
        {

            if(substr($key1,0,3)=='pro')
            {
                $value1=$value1+0;
                if($value1>0)
                {
                    $kk=explode("_",$key1);


                    $sql="select * from s_products WHERE id=".$kk[1];
                    // echo $key1." ".$sql."<br>";
                    foreach ($modx->query($sql) as $row) {

                            //высчитываем цену товара
                            $sql_mainimg = "select * from s_prices pr
                                            join s_products p
                                            on p.id=pr.product_id
                                            where (p.id=" . $row['id'] . ")and(pr.active=1);";
                            foreach ($modx->query($sql_mainimg) as $rowIMain) {
                               // echo $rowIMain['rub'];
                                $summa=$summa+($rowIMain['rub']*(0+$value1));
                                // echo $summa;
                            }
                    }
                }
            }
        }

        //----------------------------------------------------------
        //----------------------------------------------------------

            echo   json_encode(array("status"=>"1","count"=>GetCardCountProduct(),"text1"=>$ww,"summa"=>$summa)); //удалили из корзины

      //  }
      //  else
     //   {
     //       $_SESSION['product_'.$_GET['product_id']]=mysql_escape_string($_GET['product_count']);
     //       echo   json_encode(array("status"=>"1","count"=>GetCardCountProduct())); //добавили
    //   }


    }
    elseif($_GET['action']=='ss')
    {
        echo "<pre>";
        var_dump($_SERVER);
        echo "</pre>";
    }

    //Осистить корзину
    elseif($_GET['action']=='ClearCard')
    {
        foreach($_SESSION as $key=>$value)
        {

            if(substr($key,0,3)=='pro')
            {
                echo $key." ".$value." ".substr($key,0,3);

                unset($_SESSION[$key]);
            }


        }
    }

    //удаление из корзины товара
    elseif($_GET['action']=='CardProductDelete')
    {
        if(isset($_SESSION['product_'.$_GET['product_id']]))
        {
            unset($_SESSION['product_'.$_GET['product_id']]);
            echo   json_encode(array("status"=>"1")); //удалили из корзины
        }
        else echo   json_encode(array("status"=>"0")); //хер там нету такого товара


    }

    //Изменение в корзине кол-ва товара
   elseif($_GET['action']=='CardProductChangeCount')
    {
        if(isset($_SESSION['product_'.$_GET['product_id']]))
        {

            if((0+$_GET['product_count'])>0)
            {
                $_SESSION['product_'.$_GET['product_id']]=($_GET['product_count']+0);
                echo   json_encode(array("status"=>"1")); //удачно изменилос
            }
            else echo   json_encode(array("status"=>"0")); //хер там <0
        }

    }

    //Изменение значения купона на скидку  в card
    elseif($_GET['action']=='CardCouponChange')
    {
        $sql="select * from s_coupons where coupon_code='".mysql_escape_string($_GET['coupon_code'])."';";
        $coupon_code=0;
        foreach($modx->query($sql) as $rowI)
        {
            $coupon_code=$rowI['coupon_code'];
            $_SESSION['coupon_code']=$coupon_code;
            $_SESSION['coupon_value']=$rowI['coupon_value'];

            echo   json_encode(array("status"=>"1")); //удачно изменилос
        }
        if($coupon_code==0)
        {
            echo   json_encode(array("status"=>"0")); //хер там 0
        }
        else
        {

        }
    }
    //Изменение значения купона на скидку  в card
    elseif($_GET['action']=='IsCa')
    {
        if( $_SESSION['veriword']==$_GET['ca'])
        {
            OrderCommit();
        }
        else
        {
            $request['status']=0;
            $request['status_text']='Неверная капча';
            echo   json_encode($request); //хер там 0
        }
    }
    //Данные выбранного получателя в корзиене
    elseif($_GET['action']=='GetReceiver')
    {

        if(($_GET['receiver_id']+0)==0)
        {
            ?>

        <div>
            <span>ФИО</span>
            <input placeholder="Косов Андрей Владимирович" type="text" class="spec_input" name="receiver_name">
            <span>Телефон</span>
            <input placeholder="+7 906 123-45-67" type="text" class="spec_input" name="receiver_phone">
        </div>
        <div>
            <span>Населенный пункт</span>
            <input  type="text" class="spec_input" name="receiver_sity" >
        </div>
        <div>
            <span>Улица</span>
            <input  type="text" class="spec_input" name="receiver_street" >
        </div>
        <div>
            <span>Дом</span>
            <input  type="text" class="spec_input" name="receiver_house" >
        </div>
        <div>
            <span>Корпус</span>
            <input  type="text" class="spec_input" name="receiver_corpus" >
        </div>
        <div>
            <span>Подъезд</span>
            <input  type="text" class="spec_input" name="receiver_podezd" >
        </div>
        <div>
            <span>Этаж</span>
            <input  type="text" class="spec_input" name="receiver_etaj">
        </div>
        <div>
            <span>Квартира</span>
            <input  type="text" class="spec_input" name="receiver_kvartira">
        </div>
        <div>
            <span>Код домофона</span>
            <input  type="text" class="spec_input" name="receiver_domofon_code">
        </div>
        <p>Дополнительная информация:</p>
        <textarea class="spec_input"></textarea>
        <div><input type="checkbox"  name="receiver_free_photo"> Бесплатная фотография заказа</div>
        <div><input type="checkbox"  name="receiver_photo"> Фотография момента вручение заказа получателю (50 руб.)</div>


        <?php
        }
        else
        {

            $sql="select * from s_receiver where id='".mysql_escape_string($_GET['receiver_id'])."';";
            echo $sql;
            $rowI=$modx->query($sql);
            foreach($modx->query($sql) as $rowI)
            {
                ?>

            <div>
                <span>ФИО</span>
                <input placeholder="Косов Андрей Владимирович" type="text" class="spec_input" name="receiver_name" value="<?php echo $rowI['receiver_name']; ?>">
                <span>Телефон</span>
                <input placeholder="+7 906 123-45-67" type="text" class="spec_input" name="receiver_phone" value="<?php echo $rowI['receiver_phone']; ?>">
            </div>
            <div>
                <span>Населенный пункт</span>
                <input  type="text" class="spec_input" name="receiver_sity" value="<?php echo $rowI['receiver_sity']; ?>">
            </div>
            <div>
                <span>Улица</span>
                <input  type="text" class="spec_input" name="receiver_street" value="<?php echo $rowI['receiver_street']; ?>">
            </div>
            <div>
                <span>Дом</span>
                <input  type="text" class="spec_input" name="receiver_house" value="<?php echo $rowI['receiver_house']; ?>">
            </div>
            <div>
                <span>Корпус</span>
                <input  type="text" class="spec_input" name="receiver_corpus" value="<?php echo $rowI['receiver_corpus']; ?>">
            </div>
            <div>
                <span>Подъезд</span>
                <input  type="text" class="spec_input" name="receiver_podezd" value="<?php echo $rowI['receiver_podezd']; ?>">
            </div>
            <div>
                <span>Этаж</span>
                <input  type="text" class="spec_input" name="receiver_etaj" value="<?php echo $rowI['receiver_etaj']; ?>">
            </div>
            <div>
                <span>Квартира</span>
                <input  type="text" class="spec_input" name="receiver_kvartira" value="<?php echo $rowI['receiver_kvartira']; ?>">
            </div>
            <div>
                <span>Код домофона</span>
                <input  type="text" class="spec_input" name="receiver_domofon_code" value="<?php echo $rowI['receiver_domofon_code']; ?>">
            </div>
            <p>Дополнительная информация:</p>
            <textarea class="spec_input"></textarea>
            <div><input type="checkbox"  name="receiver_free_photo"> Бесплатная фотография заказа</div>
            <div><input type="checkbox"  name="receiver_photo"> Фотография момента вручение заказа получателю (50 руб.)</div>


            <?php
            }
        }





    }


}