<?php
//------------------------------------------------
/*

MYSQL
-- phpMyAdmin SQL Dump
-- version 4.1.7
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Фев 17 2015 г., 13:12
-- Версия сервера: 5.1.73-log
-- Версия PHP: 5.3.29-pl0-gentoo

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- База данных: `skremon2ru_dekor`
--

-- --------------------------------------------------------

--
-- Структура таблицы `s_categories_features`
--

CREATE TABLE IF NOT EXISTS `s_categories_features` (
  `category_id` int(11) NOT NULL,
  `feature_id` int(11) NOT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`category_id`,`feature_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `s_category`
--

CREATE TABLE IF NOT EXISTS `s_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `parent` text NOT NULL,
  `doc_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=21 ;

-- --------------------------------------------------------

--
-- Структура таблицы `s_features`
--

CREATE TABLE IF NOT EXISTS `s_features` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `position` int(11) NOT NULL,
  `in_filter` tinyint(1) DEFAULT NULL,
  `deleted` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `position` (`position`),
  KEY `in_filter` (`in_filter`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=53 ;

-- --------------------------------------------------------

--
-- Структура таблицы `s_options`
--

CREATE TABLE IF NOT EXISTS `s_options` (
  `product_id` int(11) NOT NULL,
  `feature_id` int(11) NOT NULL,
  `value` varchar(1024) NOT NULL,
  PRIMARY KEY (`product_id`,`feature_id`),
  KEY `value` (`value`(333)),
  KEY `product_id` (`product_id`),
  KEY `feature_id` (`feature_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `s_orders`
--

CREATE TABLE IF NOT EXISTS `s_orders` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `delivery_id` int(11) DEFAULT NULL,
  `delivery_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `payment_method_id` int(11) DEFAULT NULL,
  `paid` int(1) NOT NULL DEFAULT '0',
  `payment_date` datetime NOT NULL,
  `closed` tinyint(1) NOT NULL,
  `date` datetime DEFAULT NULL,
  `user_id` int(11) DEFAULT '0',
  `name` varchar(255) NOT NULL DEFAULT '',
  `address` varchar(255) NOT NULL DEFAULT '',
  `phone` varchar(255) NOT NULL DEFAULT '',
  `email` varchar(255) NOT NULL,
  `comment` varchar(1024) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `url` varchar(255) DEFAULT NULL,
  `payment_details` text NOT NULL,
  `ip` varchar(15) NOT NULL,
  `total_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `note` varchar(1024) NOT NULL,
  `discount` decimal(5,2) NOT NULL DEFAULT '0.00',
  `coupon_discount` decimal(10,2) NOT NULL DEFAULT '0.00',
  `coupon_code` varchar(255) NOT NULL,
  `separate_delivery` int(1) NOT NULL DEFAULT '0',
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `login` (`user_id`),
  KEY `written_off` (`closed`),
  KEY `date` (`date`),
  KEY `status` (`status`),
  KEY `code` (`url`),
  KEY `payment_status` (`paid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

-- --------------------------------------------------------

--
-- Структура таблицы `s_products`
--

CREATE TABLE IF NOT EXISTS `s_products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `articul` text NOT NULL,
  `category` int(11) NOT NULL,
  `title` text NOT NULL,
  `description` text NOT NULL,
  `doc_id` int(11) NOT NULL,
  `price1` float NOT NULL,
  `price2` float NOT NULL,
  `p_count` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;



--
-- Структура таблицы `s_photos`
--

CREATE TABLE IF NOT EXISTS `s_photos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sequence` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `size_id` int(11) NOT NULL,
  `flower_id` int(11) NOT NULL,
  `description_short` text NOT NULL,
  `photo` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`,`size_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=40 ;

    Захерить товары все
TRUNCATE TABLE s_buket_flowers;
TRUNCATE TABLE s_images;
TRUNCATE TABLE s_prices;
TRUNCATE TABLE s_products;


*/

//id шаблона списка товаров
define('modx_template_category', 3);

//id стартовой страницы списка товаров
define('modx_id_category', 2);

// id шаблона товаров
define('modx_template_product', 4);


error_reporting(2047);
ini_set("display_errors", 2);
//http://laromana.remkvart63.ru.swtest.ru/ProductAdmin/
// Подключаем
define('MODX_API_MODE', true);


define('upload_dir', '/files/goods/');


require '../index.php';

include('classSimpleImage.php');
require 'modules/AddonFunctions.php';


/*


*/
class Eblazavrik
{


    function getNavBar()
    {
        global $modx;
        include "templates/navBar.php";
    }


    //-----------------  Products  ----------------------
    function SetMainFlag()
    {
        global $modx;
        echo $_POST['product_id'];


        $sql = "UPDATE `s_products` set `flag_main`=0 where category=" . mysql_escape_string($_POST['category_id']);
        echo $sql;
        $modx->query($sql);
        $sql = "UPDATE `s_products` set `flag_main`=1 where id=" . mysql_escape_string($_POST['product_id']);
        echo $sql;
        $modx->query($sql);


    }

    function ProductAddFormShow()
    {
        global $modx;
        include "templates/ProductAddForm.php";

    }

    function ProductUpdate()
    {
        global $modx;
        echo "<pre>";
        var_dump($_POST);
        echo "</pre>";
        /*
                echo "<pre>";
                var_dump($_FILES);
                echo "</pre>";
        */

        //херим старые записи
        $product_id = mysql_escape_string($_POST['product_id']);

        $doc = $modx->getObject('modResource', $this->GetProductDoc($product_id));
        $doc->set('pagetitle', mysql_escape_string($_POST['title']));
        $doc->save();

        $cm = $modx->getCacheManager();
        $cm->refresh();


        $sqld = 'DELETE FROM s_images
        WHERE price_id in
        (select id from s_prices
        where product_id=' . $product_id . ');';
        $query = $modx->query($sqld);

        $sqld = 'DELETE FROM s_product_sezons
        WHERE  product_id=' . $product_id;
        $query = $modx->query($sqld);

        $sqld = 'DELETE FROM s_product_styles
        WHERE  product_id=' . $product_id;
        $query = $modx->query($sqld);

        $sqld = 'DELETE FROM s_product_gammas
        WHERE  product_id=' . $product_id;
        $query = $modx->query($sqld);

        $sqld = 'DELETE FROM s_product_sizes
        WHERE  product_id=' . $product_id;
        $query = $modx->query($sqld);


        $sqld = 'DELETE FROM s_prices WHERE product_id=' . $product_id;
        $query = $modx->query($sqld);


        //Вставляем в базу
        //   $sql1 = "UPDATE `s_products` SET `category`='" . mysql_escape_string($_POST['category_id']) . "' where id='" . $product_id . "';";
        $sql1 .= "UPDATE `s_products` SET `articul`='" . mysql_escape_string($_POST['art1']) . "' where id='" . $product_id . "';";
        $sql1 .= "UPDATE `s_products` SET `title`='" . mysql_escape_string($_POST['title']) . "' where id='" . $product_id . "';";

        $sql1 .= "UPDATE `s_products` SET `description`='" . mysql_escape_string($_POST['description']) . "' where id='" . $product_id . "';";
        $sql1 .= "UPDATE `s_products` SET `description2`='" . mysql_escape_string($_POST['description2']) . "' where id='" . $product_id . "';";


        if(isset($_POST['flag']))
        {
            $flag=1;
        }
        else
        {
            $flag=0;
        }
        $sql1 .= "UPDATE `s_products` SET `flag`='" . $flag . "' where id='" . $product_id . "';";


        // echo $sql1."<br>";
        $query = $modx->query($sql1);


        //  $lastID = $modx->lastInsertId();

        //echo " - СОСТАВ -";
        /*
                foreach ($_POST as $key => $value) {
                    if ($key{0} == 'f') //только caption с буквой F - first
                    {
                        $mm = explode("_", $key);

                        $sql2 = "INSERT INTO s_options (
                        `product_id`,
                        `feature_id`,
                        `value`
                         ) VALUES (

                         '" . $product_id . "',
                         '" . $mm[1] . "',
                         '" . mysql_escape_string($value) . "' ); ";
                        //echo $sql2;
                        $query = $modx->query($sql2);
                    }
                }

                //обрабатываем фото


                foreach ($_POST as $key => $value) {
                    //echo $key."<br>";
                    if ($key{0} == 'I') //только caption с буквой F - first
                    {
                        //$mm=explode("_",$key);
                        //echo "flower_F_count_".$mm[2];

                        $sql = "INSERT INTO s_photos (
                        `id`,
                        `product_id`,
                        `photo`)
                        values
                        (
                        NULL,
                        " . $product_id . ",
                        '" . $value . "'
                        )
                        ";
                       // echo $sql;
                        $query = $modx->query($sql);
                    }
                }

                $uploaddir = $_SERVER['DOCUMENT_ROOT'] . '/files/goods/';

                foreach ($_FILES as $F => $value) {
                    $FileName = rus2translit(basename($_FILES[$F]['name']));
                   // echo $FileName."<br>";

                    if (move_uploaded_file($_FILES[$F]['tmp_name'], $uploaddir . $FileName)) {
                       // echo  "Файл корректен и был успешно загружен.\n";

                        $image = new SimpleImage();
                        $image->load($uploaddir . $FileName);
                        $image->resizeToWidth(250);
                        $image->save($uploaddir . "250_" . $FileName);

                        $image->resizeToWidth(100);
                        $image->save($uploaddir . "100_" . $FileName);

                        // echo "UPLOAD $FileName DONE";
                        if($F=='img1')
                        {
                            $sql="update s_products set `img`='" . $FileName . "' where id= " . $product_id;

                            echo $sql;
                        }
                        else
                        {
                            $sql = "INSERT INTO s_photos (
                            `id`,
                            `product_id`,
                            `photo`)
                            values
                            (
                            NULL,
                            " . $product_id . ",
                            '" . $FileName . "'
                            )
                            ";
                        }
                       // echo $sql;
                        $query = $modx->query($sql);
                    }


                }
        */

        //  - 2 - табличная часть

        //Добавляем цены

        foreach ($_POST as $key => $value) {
            if ($key{0} == 'A') //только caption с буквой F - first
            {
                $mm = explode("_", $key);
                $PriceN = $mm[3]+0;

                $PriceActive=0;
                if(($_POST['admin_price_main_active']+0)==$PriceN)
                {
                    $PriceActive=1;
                }


                $sql2 = "INSERT INTO s_prices (
                `id`,
                `product_id`,
                `caption`,
                `rub`,
                `active`

                 ) VALUES (NULL,

                 '" . $product_id . "',
                 '" . mysql_escape_string($_POST['Aadmin_prices_caption_' . $PriceN]) . "',
                 '" . mysql_escape_string($_POST['admin_prices_price_' . $PriceN]) . "'
                 ,'$PriceActive'); ";
                echo $sql2;
                $query = $modx->query($sql2);


                $price_id = $modx->lastInsertId();
                echo "вставляем картинки $price_id <br>";
                foreach ($_POST as $keyImg => $valueImg) {
                    if ($keyImg{0} == 'i') //только caption с буквой F - first
                    {
                        $mm = explode("_", $keyImg);
                        //echo $keyImg." ".$mm[1]."<br>";
                        if (($mm[1] + 0) == (0 + $PriceN)) {
                            $ImgN = $mm[2];
                            $Filename = "img_" . $PriceN . "_" . $ImgN;
                            echo $Filename . "<br>";
                            $MainImg="mainimg_" . $PriceN . "_" . $ImgN;
                            $sqlImg = "INSERT INTO s_images (
                        `id`,
                        `price_id`,
                        `filename`,
                        `mainimg`
                         ) VALUES (NULL,


                         '" . mysql_escape_string($price_id) . "',
                         '" . mysql_escape_string($_POST[$Filename]) . "',
                         '" . mysql_escape_string($_POST[$MainImg]) . "'

                          ); ";
                            echo $sqlImg . "<br>";
                            $query = $modx->query($sqlImg);
                        }
                    }
                }

                //-------------------------------
                echo "вставляем состав $price_id <br>";
                foreach ($_POST as $keyImg => $valueImg) {
                    if ($keyImg{0} == 'F') //только caption с буквой F - first
                    {
                        $mm = explode("_", $keyImg);

                        echo "Состав = " . $keyImg . " " . $mm[1] . "PriceM=" . $PriceN . "<br>";
                        //если совпадают с текущей ценой
                        $flowerN = $mm[2];

                        $flower_id = 'FFlower_' . $PriceN . '_' . $flowerN;
                        $flower_count = "flower_" . $PriceN . "_count_" . $flowerN;
                        echo "--- " . $flower_id . " -- " . $flower_count . "<br>";

                        if (($mm[1] + 0) == (0 + $PriceN)) {
                            $flowerN = $mm[2];


                            $flower_id = 'FFlower_' . $PriceN . '_' . $flowerN;
                            $flower_count = "flower_" . $PriceN . "_count_" . $flowerN;

                            echo $flower_id . " " . $flower_count;

                            $sqlFlower = "INSERT INTO s_buket_flowers (
                        `id`,
                        `price_id`
                        ,`flower_id`
                        ,`f_count`
                         ) VALUES (NULL,
                         '" . mysql_escape_string($price_id) . "',
                         '" . mysql_escape_string($_POST[$flower_id]) . "',
                         '" . mysql_escape_string($_POST[$flower_count]) . "' ); ";
                            echo $sqlFlower . "<br>";
                            $query = $modx->query($sqlFlower);
                        }
                    }
                }


                echo "+++++++++++++++++++++++++++";

            }
            elseif($key{0} == 's')//вставляем сезоны
            {
                $mm = explode("_", $key);
                $sql_sezon="INSERT INTO s_product_sezons (
	`id`,
	`product_id`,
	`sezon_id`)
	VALUES (
	 NULL,
	  '" . $product_id . "',
	  '" . mysql_escape_string($mm[1]) . "'
	 );
	";
                echo $sql_sezon."<br>";
                $query = $modx->query($sql_sezon);
            }
            elseif($key{0} == 'Y')//вставляем сезоны
            {
                $mm = explode("_", $key);
                $sql_style="INSERT INTO s_product_styles (
	`id`,
	`product_id`,
	`style_id`)
	VALUES (
	 NULL,
	  '" . $product_id . "',
	  '" . mysql_escape_string($mm[1]) . "'
	 );
	";
                echo $sql_style."<br>";
                $query = $modx->query($sql_style);
            } elseif($key{0} == 'G')//вставляем сезоны
            {
                $mm = explode("_", $key);
                $sql_gammas="INSERT INTO s_product_gammas (
	`id`,
	`product_id`,
	`gamma_id`)
	VALUES (
	 NULL,
	  '" . $product_id . "',
	  '" . mysql_escape_string($mm[1]) . "'
	 );
	";
                echo $sql_gammas."<br>";
                $query = $modx->query($sql_gammas);
            }

            elseif($key{0} == 'I')//вставляем сезоны
            {
                $mm = explode("_", $key);
                $sql_sizes="INSERT INTO s_product_sizes (
	`id`,
	`product_id`,
	`size_id`)
	VALUES (
	 NULL,
	  '" . $product_id . "',
	  '" . mysql_escape_string($mm[1]) . "'
	 );
	";
                echo $sql_sizes."<br>";
                $query = $modx->query($sql_sizes);
            }

        }

        // - СОСТАВ -

        foreach ($_POST as $key => $value) {
            if ($key{0} == 'f') //только caption с буквой F - first
            {
                $mm = explode("_", $key);

                $sql2 = "INSERT INTO s_buket_flowers (
                `price_id`,
                `flower_id`,
                `f_count`
                 ) VALUES (

                 '" . $lastID . "',
                 '" . $mm[1] . "',
                 '" . mysql_escape_string($value) . "' ); ";
                //  echo $sql2;
                $query = $modx->query($sql2);
            }
        }

         //  header('Refresh: 0; url=index.php?action=ProductEditFormShow&product_id=' . $product_id);
          header('Refresh: 0; url=index.php?action=CategoryShow');

    }

    function GetProductOtionValue($product_id, $feature_id)
    {
        global $modx;
        $sql = "SELECT value FROM s_options where (product_id=$product_id)and(feature_id=$feature_id)";
        $query = $modx->query($sql);
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            return $row['value'];
        }
    }


    function GetProductImg($product_id)
    {
        global $modx;
        $sql = "select * from s_photos where product_id=" . mysql_escape_string($product_id) . " LIMIT 1";
        //echo $sql;
        $query = $modx->query($sql);
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            return $row['photo'];
        }
    }

    function GetCategoryDoc($category_id)
    {
        global $modx;
        $sql = "select * from s_category where id=" . $category_id;
        $query = $modx->query($sql);
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            return $row['doc_id'];
        }
    }

    function InsertProductDoc($parent_id = modx_id_category, $template_id = modx_template_product)
    {
        //проверить создается ли URL!!!

        global $modx;
        //Осздаем док в модексе
        $document = $modx->newObject('modResource');
        $document->set('createdby', $modx->user->get('id')); // - присваиваем автора ресурсу.
        $document->set('template', $template_id); // - присваиваем шаблон ресурсу.
        $document->set('isfolder', '0'); // - новый ресурс не будет контейнером.
        $document->set('published', '1'); // - будет опубликован.

        $MyTime = time();

        $document->set('createdon', $MyTime); // - дата создания контента.
        $document->set('pagetitle', $_POST['title']); // - заголовок материала.
        $document->set('alias', ''); // - псевдоним для ссылки.
        $document->set('description', ''); // - ID записи товара в базе


        //$document->set('introtext', '>>>!!!!Ответ нужно написать здесь!!!!<<<<');   // - цитата/анонс, introtext.
        //$document->setContent($_GET['message']);          // - содержимое ресурса.
        $document->set('parent', $parent_id);
        // - идентификатор родителя.

        //Сохраняем
        $document->save();
        $cm = $modx->getCacheManager();
        $cm->refresh();

        /*
                $MyID = $document->get('id');
                $MyDate = $document->get('publishedon');
                //$MyDate=date("d.m.Y", $MyDate);
                //Теперь записываем TV поля
                $document->set('reviewsText', null);
                $document->setTVValue('reviewsText', $_GET['otMsg']);

                $document->set('reviewsFIO', null);
                $document->setTVValue('reviewsFIO', $_GET['otName1']);

                $document->set('reviewsEmail', null);
                $document->setTVValue('reviewsEmail', $_GET['otEmail']);
        */
        $modx->cacheManager->refresh();
        return $document->get('id');
    }


    //вставляет в базу новы продукт-букет
    function ProductSave()
    {
        global $modx;

        echo "<pre>";
        var_dump($_POST);
        echo "</pre>";
/*
        echo "<pre>";
        var_dump($_FILES);
        echo "</pre>";
*/
        //Вставляем в базу

        if(isset($_POST['flag']))
        {
            $flag=1;
        }
        else
        {
            $flag=0;
        }
        $sql1 = "INSERT INTO s_products (
	`id`,
	`category`,
	`articul`,
	`title`,

	`description`,
	`description2`,
	`p_count`,
	`flag`

	 ) VALUES (
	 NULL,

	 '" . mysql_escape_string($_POST['category_id']) . "',
	 '" . mysql_escape_string($_POST['art1']) . "',
	 '" . mysql_escape_string($_POST['title']) . "',

	 '" . mysql_escape_string($_POST['description']) . "',
	 '" . mysql_escape_string($_POST['description2']) . "',
	 '" . mysql_escape_string($_POST['p_count']) . "'
	 ,'".$flag."'
	);  ";

         echo $sql1;
        $query = $modx->query($sql1);
        $product_id = $modx->lastInsertId();

        //вставляем в модкс

        $DocID = $this->InsertProductDoc((mysql_escape_string($_POST['category_id'])));
        // echo "вставляем id документа";
        $sql1 = "UPDATE `s_products` SET `doc_id`='" . mysql_escape_string($DocID) . "' where id='" . $product_id . "';";
        // echo $sql1;
        $query = $modx->query($sql1);





        //  - 2 - табличная часть

        //Добавляем цены

        foreach ($_POST as $key => $value) {
            if ($key{0} == 'A') //только caption с буквой F - first
            {
                $mm = explode("_", $key);
                $PriceN = $mm[3];

                $PriceActive=0;
                if(($_POST['admin_price_main_active']+0)==$PriceN)
                {
                    $PriceActive=1;
                }

                $sql2 = "INSERT INTO s_prices (
                `id`,
                `product_id`,
                `caption`,
                `rub`,
                `active`

                 ) VALUES (NULL,

                 '" . $product_id . "',
                 '" . mysql_escape_string($_POST['Aadmin_prices_caption_' . $PriceN]) . "',
                 '" . mysql_escape_string($_POST['admin_prices_price_' . $PriceN]) . "',
                  ".$PriceActive."
                  ); ";
                echo $sql2;
                $query = $modx->query($sql2);


                $price_id = $modx->lastInsertId();



                echo "вставляем картинки $price_id <br>";
                foreach ($_POST as $keyImg => $valueImg) {
                    if ($keyImg{0} == 'i') //только caption с буквой F - first
                    {
                        $mm = explode("_", $keyImg);
                        //echo $keyImg." ".$mm[1]."<br>";
                        if (($mm[1] + 0) == (0 + $PriceN)) {
                            $ImgN = $mm[2];
                            $Filename = "img_" . $PriceN . "_" . $ImgN;
                            echo $Filename . "<br>";
                            $MainImg="mainimg_" . $PriceN . "_" . $ImgN;
                            $sqlImg = "INSERT INTO s_images (
                        `id`,
                        `price_id`,
                        `filename`
                        ,`mainimg`
                         ) VALUES (NULL,


                         '" . mysql_escape_string($price_id) . "',
                         '" . mysql_escape_string($_POST[$Filename]) . "'
                         ,'" . mysql_escape_string($_POST[$MainImg]) . "'); ";
                            echo $sqlImg . "<br>";
                            $query = $modx->query($sqlImg);
                        }
                    }
                }

                //-------------------------------
                echo "вставляем состав $price_id <br>";
                foreach ($_POST as $keyImg => $valueImg) {
                    if ($keyImg{0} == 'F') //только caption с буквой F - first
                    {
                        $mm = explode("_", $keyImg);

                        echo "Состав = " . $keyImg . " " . $mm[1] . "PriceM=" . $PriceN . "<br>";
                        //если совпадают с текущей ценой
                        $flowerN = $mm[2];

                        $flower_id = 'FFlower_' . $PriceN . '_' . $flowerN;
                        $flower_count = "flower_" . $PriceN . "_count_" . $flowerN;
                        echo "--- " . $flower_id . " -- " . $flower_count . "<br>";

                        if (($mm[1] + 0) == (0 + $PriceN)) {
                            $flowerN = $mm[2];


                            $flower_id = 'FFlower_' . $PriceN . '_' . $flowerN;
                            $flower_count = "flower_" . $PriceN . "_count_" . $flowerN;

                            echo $flower_id . " " . $flower_count;

                            $sqlFlower = "INSERT INTO s_buket_flowers (
                        `id`,
                        `price_id`
                        ,`flower_id`
                        ,`f_count`
                         ) VALUES (NULL,
                         '" . mysql_escape_string($price_id) . "',
                         '" . mysql_escape_string($_POST[$flower_id]) . "',
                         '" . mysql_escape_string($_POST[$flower_count]) . "' ); ";
                            echo $sqlFlower . "<br>";
                            $query = $modx->query($sqlFlower);
                        }
                    }
                }


                echo "+++++++++++++++++++++++++++";

            }
            elseif($key{0} == 's')//вставляем сезоны
            {
                $mm = explode("_", $key);
                $sql_sezon="INSERT INTO s_product_sezons (
	`id`,
	`product_id`,
	`sezon_id`)
	VALUES (
	 NULL,
	  '" . $product_id . "',
	  '" . mysql_escape_string($mm[1]) . "'
	 );
	";
                echo $sql_sezon."<br>";
                $query = $modx->query($sql_sezon);
            }
            //----------------------------------------------
            //----------------------------------------------
            elseif($key{0} == 'Y')//вставляем сезоны
            {
                $mm = explode("_", $key);
                $sql_style="INSERT INTO s_product_styles (
	`id`,
	`product_id`,
	`style_id`)
	VALUES (
	 NULL,
	  '" . $product_id . "',
	  '" . mysql_escape_string($mm[1]) . "'
	 );
	";
                echo $sql_style."<br>";
                $query = $modx->query($sql_style);
            }

            elseif($key{0} == 'G')//вставляем сезоны
            {
                $mm = explode("_", $key);
                $sql_gammas="INSERT INTO s_product_gammas (
	`id`,
	`product_id`,
	`gamma_id`)
	VALUES (
	 NULL,
	  '" . $product_id . "',
	  '" . mysql_escape_string($mm[1]) . "'
	 );
	";
                echo $sql_gammas."<br>";
                $query = $modx->query($sql_gammas);
            }
            elseif($key{0} == 'I')//вставляем сезоны
            {
                $mm = explode("_", $key);
                $sql_sizes="INSERT INTO s_product_sizes (
	`id`,
	`product_id`,
	`size_id`)
	VALUES (
	 NULL,
	  '" . $product_id . "',
	  '" . mysql_escape_string($mm[1]) . "'
	 );
	";
                echo $sql_sizes."<br>";
                $query = $modx->query($sql_sizes);
            }
        }


        // - СОСТАВ -
        /*
        foreach ($_POST as $key => $value) {
            if ($key{0} == 'f') //только caption с буквой F - first
            {
                $mm = explode("_", $key);

                $sql2 = "INSERT INTO s_buket_flowers (
                `price_id`,
                `flower_id`,
                `f_count`
                 ) VALUES (

                 '" . $lastID . "',
                 '" . $mm[1] . "',
                 '" . mysql_escape_string($value) . "' ); ";
              //  echo $sql2;
                $query = $modx->query($sql2);
            }
        }
        */

           header('Refresh: 0; url=index.php?action=CategoryShow');
    }


    function ProductEditFormShow()
    {
        global $modx;
        include "templates/ProductEditForm.php";

    }

    function ProductsShow()
    {
        global $modx;
        include "templates/products.php";

    }

    function GetProductDoc($product_id)
    {
        global $modx;
        $sql = "select * from s_products where id=" . mysql_escape_string($product_id) . " LIMIT 1";
        //echo $sql;
        $query = $modx->query($sql);
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            return $row['doc_id'];
        }
    }


    function ProductsDelete()
    {
        global $modx;

        $product_id = mysql_escape_string($_POST['product_id']);

        $doc = $modx->getObject('modResource', $this->GetProductDoc($product_id));
        $doc->set('deleted', '1');
        $doc->save();

        $sqld = 'DELETE FROM s_flowers_range WHERE product_id=' . $product_id;
        $query = $modx->query($sqld);

        $sqld = 'DELETE FROM s_photos WHERE product_id=' . $product_id;
        $query = $modx->query($sqld);


        $sqld = 'DELETE FROM s_products WHERE id=' . $product_id;
        $query = $modx->query($sqld);

        $sqld = 'DELETE FROM s_product_gammas WHERE id=' . $product_id;
        $query = $modx->query($sqld);

        $sqld = 'DELETE FROM s_product_styles WHERE id=' . $product_id;
        $query = $modx->query($sqld);

        $sqld = 'DELETE FROM s_product_sezons WHERE id=' . $product_id;
        $query = $modx->query($sqld);

    }


    //-----------------  Gammas  ----------------------
    function GammasShow()
    {
        global $modx;
        include "templates/gammas.php";
    }

    function GammasGetEditForm()
    {
        global $modx;

        include "templates/GammasEditForm.php";

    }

    function GammasSave()
    {

        $sql = "INSERT INTO s_gammas (`id`, `title`)
        VALUES (NULL, '" .
            mysql_escape_string($_POST['title']) . "');";
        echo $sql;
        global $modx;
        $modx->query($sql);
    }

    function GammasDelete()
    {

        $sql = "DELETE FROM s_gammas WHERE id = " . mysql_escape_string($_POST['f_id']);
        echo $sql;
        global $modx;
        $modx->query($sql);
    }

    function GammasUpdate()
    {
        global $modx;
        $sql = "UPDATE s_gammas SET title = '" . $_POST['title'] . "' WHERE `s_gammas`.`id` = " . mysql_escape_string($_POST['f_id']);

        echo $sql;
        $modx->query($sql);
    }


    function GetProductGammasList()
    {

        global $modx;

        if(isset($_GET['product_id']))
        {
            $product_id=mysql_escape_string($_GET['product_id']);
        }
        else
        {
            $product_id=0;
        }
        ?>

    <!-- Modal -->
    <div class="modal fade" id="ModalAddGamma" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Добавить гамму</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="title">Название</label>
                        <input type="text" class="form-control" id="gamma_modal_title" placeholder="Название">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Отменить</button>
                    <button type="button" class="btn btn-primary" onclick="ProductGammaSave(<?php echo $product_id; ?>)">Сохранить</button>
                </div>
            </div>
        </div>
    </div>

    <label>Гаммы</label>
    <?php
        if(isset($_GET['product_id']))
        {


            $sql = "select * from s_product_gammas where product_id=".mysql_escape_string($_GET['product_id']);

            foreach($modx->query($sql) as $row_sp)
            {
                $s_product_gammas[]=$row_sp['gamma_id'];
            }



            $sql = "select * from s_gammas order by title";
            foreach($modx->query($sql) as $row)
            {
                ?>
            <div class="checkbox">
                <label>
                    <input type="checkbox"
                        <?php
                        if(in_array( $row['id'], $s_product_gammas)) echo " checked ";
                        ?>
                           name="Ggammas_<?php echo $row['id']; ?>"> <?php echo $row['title']; ?>
                </label>
            </div>
            <?php
            }

        }
        else
        {
            $sql = "select * from s_gammas";
            foreach($modx->query($sql) as $row)
            {
                ?>
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="Ggammas_<?php echo $row['id']; ?>"> <?php echo $row['title']; ?>
                </label>
            </div>

            <?php
            }

        }
        ?>
    <div class="gamma_add" onclick="ProductGammaAdd()"><img src="/site/tpl/img/add_prod.png" style="
    width: 50px;cursor: pointer;"></div>
    <?php

    }



//-----------------  Seazons  ----------------------
    function SezonsShow()
    {
        global $modx;
        include "templates/sezons.php";
    }

    function SezonsGetEditForm()
    {
        global $modx;

        include "templates/SezonsEditForm.php";

    }

    function SezonsSave()
    {

        $sql = "INSERT INTO s_seazons (`id`, `title`)
        VALUES (NULL, '" .
            mysql_escape_string($_POST['title']) . "');";
        echo $sql;
        global $modx;
        $modx->query($sql);
    }

    function SezonsDelete()
    {

        $sql = "DELETE FROM s_seazons WHERE id = " . mysql_escape_string($_POST['f_id']);
        echo $sql;
        global $modx;
        $modx->query($sql);
    }

    function SezonsUpdate()
    {
        global $modx;
        $sql = "UPDATE s_seazons SET title = '" . $_POST['title'] . "' WHERE `s_seazons`.`id` = " . mysql_escape_string($_POST['f_id']);

        echo $sql;
        $modx->query($sql);
    }

    //ajax

    //список сезоов для измн/доб продукта в форму ерез ajax
    //sezon_id - массив чекнутых



    function GetProductSezonList()
    {

        global $modx;

        if(isset($_GET['product_id']))
        {
            $product_id=mysql_escape_string($_GET['product_id']);
        }
        else
        {
            $product_id=0;
        }
        ?>

    <!-- Modal -->
    <div class="modal fade" id="ModalAddSeazon" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Добавить сезон</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="title">Название</label>
                        <input type="text" class="form-control" id="seazon_modal_title" placeholder="Название">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Отменить</button>
                    <button type="button" class="btn btn-primary" onclick="ProductSeazonSave(<?php echo $product_id; ?>)">Сохранить</button>
                </div>
            </div>
        </div>
    </div>


    <label>Категории букетов</label>
    <?php
        if(isset($_GET['product_id']))
        {


            $sql = "select * from s_product_sezons where product_id=".mysql_escape_string($_GET['product_id']);

            foreach($modx->query($sql) as $row_sp)
            {
                $s_product_sezons[]=$row_sp['sezon_id'];
            }



            $sql = "select * from s_seazons order by title";
            foreach($modx->query($sql) as $row)
            {
                ?>
            <div class="checkbox">
                <label>
                    <input type="checkbox"
                           <?php
                        if(in_array( $row['id'], $s_product_sezons)) echo " checked ";
                        ?>
                           name="sezon_<?php echo $row['id']; ?>"> <?php echo $row['title']; ?>
                </label>
            </div>
            <?php
            }

        }
        else
        {
            $sql = "select * from s_seazons";
            foreach($modx->query($sql) as $row)
            {
                ?>
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="sezon_<?php echo $row['id']; ?>"> <?php echo $row['title']; ?>
                </label>
            </div>

            <?php
            }

        }
        ?>
    <div class="seazon_add" onclick="ProductSeazonAdd()"><img src="/site/tpl/img/add_prod.png" style="
    width: 50px;cursor: pointer;"></div>
        <?php

    }


//-----------------  Styles  ----------------------
    function StylesShow()
    {
        global $modx;
        include "templates/styles.php";
    }

    function StylesGetEditForm()
    {
        global $modx;

        include "templates/StylesEditForm.php";

    }

    function StylesSave()
    {

        $sql = "INSERT INTO s_styles (`id`, `title`)
        VALUES (NULL, '" .
            mysql_escape_string($_POST['title']) . "');";
        echo $sql;
        global $modx;
        $modx->query($sql);
    }

    function StylesDelete()
    {

        $sql = "DELETE FROM s_styles WHERE id = " . mysql_escape_string($_POST['f_id']);
        echo $sql;
        global $modx;
        $modx->query($sql);
    }


//аякс для полуения списка стилей при доб.удл букета
    function GetProductStylesList()
    {
        global $modx;


        if(isset($_GET['product_id']))
        {
            $product_id=mysql_escape_string($_GET['product_id']);
        }
        else
        {
            $product_id=0;
        }
        ?>

    <!-- Modal -->
    <div class="modal fade" id="ModalAddStyle" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Добавить стиль</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="title">Название</label>
                        <input type="text" class="form-control" id="style_modal_title" placeholder="Название">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Отменить</button>
                    <button type="button" class="btn btn-primary" onclick="ProductStyleSave(<?php echo $product_id; ?>)">Сохранить</button>
                </div>
            </div>
        </div>
    </div>


        <label>Стили</label>
        <?php

        if(isset($_GET['product_id']))
        {


            $sql = "select * from s_product_styles where product_id=".mysql_escape_string($_GET['product_id']);


            foreach($modx->query($sql) as $row_sp)
            {
                $s_product_styles[]=$row_sp['style_id'];
            }




            $sql = "select * from s_styles order by title";
            foreach($modx->query($sql) as $row)
            {
                ?>
            <div class="checkbox">
                <label>
                    <input type="checkbox"
                        <?php
                        if(in_array( $row['id'], $s_product_styles)) echo " checked ";
                        ?>
                           name="Ystyle_<?php echo $row['id']; ?>"> <?php echo $row['title']; ?>
                </label>
            </div>
            <?php
            }

        }
        else
        {
            $sql = "select * from s_styles";
            foreach($modx->query($sql) as $row)
            {
                ?>
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="Ystyle_<?php echo $row['id']; ?>"> <?php echo $row['title']; ?>
                </label>
            </div>

            <?php
            }

        }
        ?>
    <div class="style_add" onclick="ProductStyleAdd()"><img src="/site/tpl/img/add_prod.png" style="
    width: 50px;cursor: pointer;"></div>
    <?php

    }


//-----------------  Sizes  ----------------------
    function SizesShow()
    {
        global $modx;
        include "templates/sizes.php";
    }

    function SizesGetEditForm()
    {
        global $modx;

        include "templates/SizesEditForm.php";

    }

    function SizesSave()
    {

        $sql = "INSERT INTO s_sizes (`id`, `title`)
        VALUES (NULL, '" .
            mysql_escape_string($_POST['title']) . "');";
        echo $sql;
        global $modx;
        $modx->query($sql);
    }

    function SizesDelete()
    {

        $sql = "DELETE FROM s_sizes WHERE id = " . mysql_escape_string($_POST['f_id']);
        echo $sql;
        global $modx;
        $modx->query($sql);
    }

    function SizesUpdate()
    {
        global $modx;
        $sql = "UPDATE s_sizes SET title = '" . $_POST['title'] . "' WHERE `s_sizes`.`id` = " . mysql_escape_string($_POST['f_id']);

        echo $sql;
        $modx->query($sql);
    }



//аякс для полуения списка стилей при доб.удл букета
    function GetProductSizesList()
    {
        global $modx;
        if(isset($_GET['product_id']))
        {
            $product_id=mysql_escape_string($_GET['product_id']);
        }
        else
        {
            $product_id=0;
        }
        ?>

    <!-- Modal -->
    <div class="modal fade" id="ModalAddSizes" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Добавить гамму</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="title">Название</label>
                        <input type="text" class="form-control" id="Sizes_modal_title" placeholder="Название">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Отменить</button>
                    <button type="button" class="btn btn-primary" onclick="ProductSizesSave(<?php echo $product_id; ?>)">Сохранить</button>
                </div>
            </div>
        </div>
    </div>


    <label>Размеры</label>
    <?php

        if(isset($_GET['product_id']))
        {


            $sql = "select * from s_product_sizes where product_id=".mysql_escape_string($_GET['product_id']);


            foreach($modx->query($sql) as $row_sp)
            {
                $s_product_sizes[]=$row_sp['size_id'];
            }




            $sql = "select * from s_sizes";
            foreach($modx->query($sql) as $row)
            {
                ?>
            <div class="checkbox">
                <label>
                    <input type="checkbox"
                        <?php
                        if(in_array( $row['id'], $s_product_sizes)) echo " checked ";
                        ?>
                           name="Isizes_<?php echo $row['id']; ?>"> <?php echo $row['title']; ?>
                </label>
            </div>
            <?php
            }

        }
        else
        {
            $sql = "select * from s_sizes";
            foreach($modx->query($sql) as $row)
            {
                ?>
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="Isizes_<?php echo $row['id']; ?>"> <?php echo $row['title']; ?>
                </label>
            </div>

            <?php
            }

        }

        ?>
    <div class="Sizes_add" onclick="ProductSizesAdd()"><img src="/site/tpl/img/add_prod.png" style="
    width: 50px;cursor: pointer;"></div>
    <?php

    }

//-----------------  Types  ----------------------
    function TypesShow()
    {
        global $modx;
        include "templates/types.php";
    }

    function TypesGetEditForm()
    {
        global $modx;

        include "templates/TypesEditForm.php";

    }

    function TypesSave()
    {

        $sql = "INSERT INTO s_types (`id`, `title`)
        VALUES (NULL, '" .
            mysql_escape_string($_POST['title']) . "');";
        echo $sql;
        global $modx;
        $modx->query($sql);
    }

    function TypesDelete()
    {

        $sql = "DELETE FROM s_types WHERE id = " . mysql_escape_string($_POST['f_id']);
        echo $sql;
        global $modx;
        $modx->query($sql);
    }

    function TypesUpdate()
    {
        global $modx;
        $sql = "UPDATE s_types SET title = '" . $_POST['title'] . "' WHERE `s_types`.`id` = " . mysql_escape_string($_POST['f_id']);

        echo $sql;
        $modx->query($sql);
    }


//-----------------  Category  ----------------------
    function CategoryShow()
    {
        global $modx;
        include "templates/category.php";
    }

    function CategoryGetEditForm()
    {
        global $modx;

        include "templates/CategoryEditForm.php";
    }

    function CategoryEdit()
    {
        global $modx;
        include "templates/CategoryEditForm.php";
    }

    function CategorySave()
    {

        global $modx;

        $sql = "INSERT INTO s_category (`id`, `title`, `parent`)
        VALUES (NULL, '" .
            mysql_escape_string($_POST['title']) . "','" . mysql_escape_string($_POST['parent']) . "');";

        $modx->query($sql);
        $lastID = $modx->lastInsertId();
        $DocID = $this->InsertProductDoc(mysql_escape_string($_POST['parent']), modx_template_category);
        //вставляем id документа
        $sql1 = "UPDATE `s_category`
        SET `doc_id`='" . mysql_escape_string($DocID) . "'
        where id='" . $lastID . "';";
        $query = $modx->query($sql1);
        echo json_encode(array("category_id" => $DocID));
    }

    function CategoryDelete()
    {

        $sql = "DELETE FROM s_category WHERE doc_id = " . mysql_escape_string($_POST['f_id']);
        echo $sql;
        global $modx;
        $modx->query($sql);


        $doc = $modx->getObject('modResource', ($_POST['f_id']));
        $doc->set('deleted', '1');
        $doc->save();
    }

    function CategoryUpdate()
    {
        global $modx;
        //echo "<pre>";
        // var_dump($_POST);
        // echo "</pre>";
        $sql = "UPDATE s_category SET
        title = '" . mysql_escape_string($_POST['title']) . "'
        WHERE `doc_id` = " . mysql_escape_string($_POST['category_id']);

        echo $sql;
        $modx->query($sql);

        $doc = $modx->getObject('modResource', $_POST['category_id']);
        $doc->set('pagetitle', mysql_escape_string($_POST['title']));
        $doc->save();

        // херим старые поля товаров
        //или не херим
        /*
                $sql="select * from s_features where name like '".mysql_escape_string($_POST['title']) ."';";
                $query = $modx->query($sql);
                while ($row = $query->fetch(PDO::FETCH_ASSOC)) {

                    echo $row[''];
                }
        */

        $sql = "UPDATE s_categories_features SET
                deleted = '1'
                WHERE `category_id` = " . mysql_escape_string($_POST['category_id']);
        //echo $sql;
        $query = $modx->query($sql);

        foreach ($_POST as $key => $value) {
            //echo $key."<br>";
            if ($key{0} == 'U') //только caption с буквой F - first
            {
                $mm = explode("_", $key);
                //echo "flower_F_count_".$mm[2];
                $f_count = $_POST["flower_F_count_" . $mm[2]];
                //echo "<br>Features ID:".$value;
                //echo "<br>Features Name:". $_POST["ufeatures_name_" . $mm[2]];;

                $sql = "UPDATE s_features SET
                name = '" . mysql_escape_string($_POST["ufeatures_name_" . $mm[2]]) . "'
                WHERE `id` = " . mysql_escape_string($value);
                //echo $sql."<br>";
                $query = $modx->query($sql);
                // echo $sql2;
                //$query = $modx->query($sql2);
                $sql = "UPDATE s_categories_features SET
                deleted = '0'
                WHERE (`category_id` = " . mysql_escape_string($_POST['category_id']) . ")AND
               (`feature_id` = " . mysql_escape_string($value) . ")
                ";
                //echo $sql."<br>";
                $query = $modx->query($sql);
            }
        }

        foreach ($_POST as $key => $value) {
            //echo $key."<br>";
            if ($key{0} == 'f') //только caption с буквой F - first
            {
                $mm = explode("_", $key);

                //echo "<br>Features Insert:". $value;;
                $sql = "INSERT INTO s_features (`id`, `name`, `position`)
        VALUES (NULL, '" .
                    mysql_escape_string($value) . "','1');";

                $modx->query($sql);
                $lastID = $modx->lastInsertId();
                //echo $sql."<br>";
                $sql = "INSERT INTO s_categories_features (`category_id`, `feature_id`)
        VALUES ('" .
                    mysql_escape_string($_POST['category_id']) . "','$lastID');";
                //echo $sql."<br>";
                $modx->query($sql);
                $lastID = $modx->lastInsertId();

            }
        }

        header('Refresh: 0; url=index.php?action=CategoryEdit&category_id=' . mysql_escape_string($_POST['category_id']));

    }

    function GetCategoryTitle($category_id)
    {
        global $modx;
        if (empty($category_id)) {
            return "Верхний уровень категорий";
        } else {
            $sql = "select title from s_category where doc_id=" . $category_id;
            $query = $modx->query($sql);
            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                return $row['title'];
            }
        }


    }

    function CategoryInfo()
    {
        global $modx;
        include "templates/CategoryInfo.php";

    }

    //-----------------  Clients ----------------------
    function ClientsShow()
    {
        global $modx;
        include "templates/clients.php";

    }

    //-----------------  Orders ----------------------
    function OrdersShow()
    {
        global $modx;
        include "templates/orders.php";

    }


//-----------------  Flowers  ----------------------

    function FlowersShow()
    {
        global $modx;
        include "templates/flowers.php";

    }


    function FlowersGetEditForm()
    {
        global $modx;

        include "templates/FlowersEditForm.php";
    }

    function FlowersEdit()
    {
        global $modx;
        include "templates/FlowersEditForm.php";
    }

    function FlowersSave()
    {

        global $modx;

        $flower_id=mysql_escape_string($_POST['flowers_id']);

        $sql = "INSERT INTO s_flowers (`id`, `title`)
        VALUES (NULL, '" .
            mysql_escape_string($_POST['title']) . "');";

        $modx->query($sql);
        $lastID = $modx->lastInsertId();
        //$DocID = $this->InsertProductDoc(mysql_escape_string($_POST['parent']), modx_template_category);
        //вставляем id документа
    /*    $sql1 = "UPDATE `s_category`
        SET `doc_id`='" . mysql_escape_string($DocID) . "'
        where id='" . $lastID . "';";
        $query = $modx->query($sql1);*/
        echo json_encode(array("lastID" => $lastID));
    }

    function FlowersDelete()
    {

        $sql = "DELETE FROM s_flowers WHERE doc_id = " . mysql_escape_string($_POST['f_id']);
        echo $sql;
        global $modx;
        $modx->query($sql);

/*
        $doc = $modx->getObject('modResource', ($_POST['f_id']));
        $doc->set('deleted', '1');
        $doc->save();*/
    }

    function FlowersUpdate()
    {
        global $modx;
        //echo "<pre>";
        // var_dump($_POST);
        // echo "</pre>";
        $flowers_id=mysql_escape_string($_POST['flowers_id']);

        $sql = "UPDATE s_flowers SET
        title = '" . mysql_escape_string($_POST['title']) . "'
        WHERE `id` = " . $flowers_id.";";


        $sql .= "UPDATE s_flowers SET
        articul = '" . mysql_escape_string($_POST['articul']) . "'
        WHERE `id` = " . $flowers_id.";";


        $sql .= "UPDATE s_flowers SET
        price = '" . mysql_escape_string($_POST['price']) . "'
        WHERE `id` = " . $flowers_id.";";


        $sql .= "UPDATE s_flowers SET
        quantity1 = '" . mysql_escape_string($_POST['quantity1']) . "'
        WHERE `id` = " . $flowers_id.";";


        $sql .= "UPDATE s_flowers SET
        quantity2 = '" . mysql_escape_string($_POST['quantity2']) . "'
        WHERE `id` = " . $flowers_id.";";


        $sql .= "UPDATE s_flowers SET
        description_short = '" . mysql_escape_string($_POST['description_short']) . "'
        WHERE `id` = " . $flowers_id.";";


        $sql .= "UPDATE s_flowers SET
        description_full = '" . mysql_escape_string($_POST['description_full']) . "'
        WHERE `id` = " . $flowers_id.";";








        $uploaddir = $_SERVER['DOCUMENT_ROOT'] . upload_dir;

        foreach ($_FILES as $F => $value) {
            $FileName = rus2translit(basename($_FILES[$F]['name']));
            // echo $FileName."<br>";

            if (move_uploaded_file($_FILES[$F]['tmp_name'], $uploaddir . $FileName)) {
                // echo  "Файл корректен и был успешно загружен.\n";

                $image = new SimpleImage();
                $image->load($uploaddir . $FileName);
                $image->resizeToWidth(250);
                $image->save($uploaddir . "250_" . $FileName);

                $image->resizeToWidth(100);
                $image->save($uploaddir . "100_" . $FileName);

                // echo "UPLOAD $FileName DONE";
                // if($F=='img1')
                {
                    $sql.="update s_flowers
                    set `image`='" . $FileName . "' where id= " . $flowers_id;

                   // echo $sql;
                }

                echo $sql;

            }


        }
        $query = $modx->query($sql);
        header('Refresh: 0; url=/ProductAdmin/index.php?action=FlowersShow');

    }

    function FlowersInfo()
    {
        global $modx;
        include "templates/CategoryInfo.php";

    }


    function Run()
    {
        global $modx;

        if (isset($_POST['action'])) //события post
        {
            //-----------------  Gammas  ----------------------
            if ($_POST['action'] == "GammasSave") {
                $this->GammasSave();
            } elseif ($_POST['action'] == "GammasDelete") {
                $this->GammasDelete();
            } elseif ($_POST['action'] == "GammasGetEditForm") {
                $this->GammasGetEditForm();
            } elseif ($_POST['action'] == "GammasUpdate") {
                $this->GammasUpdate();
            } //-----------------  Seazons  ----------------------
            elseif ($_POST['action'] == "SezonsSave") {
                $this->SezonsSave();
            } elseif ($_POST['action'] == "SezonsDelete") {
                $this->SezonsDelete();
            } elseif ($_POST['action'] == "SezonsGetEditForm") {
                $this->SezonsGetEditForm();
            } elseif ($_POST['action'] == "SezonsUpdate") {
                $this->SezonsUpdate();
            } //-----------------  Styles  ----------------------
            elseif ($_POST['action'] == "StylesSave") {
                $this->StylesSave();
            } elseif ($_POST['action'] == "StylesDelete") {
                $this->StylesDelete();
            } elseif ($_POST['action'] == "StylesGetEditForm") {
                $this->StylesGetEditForm();
            } elseif ($_POST['action'] == "StylesUpdate") {
                $this->StylesUpdate();
            } //-----------------  Sizes  ----------------------
            elseif ($_POST['action'] == "SizesSave") {
                $this->SizesSave();
            } elseif ($_POST['action'] == "SizesDelete") {
                $this->SizesDelete();
            } elseif ($_POST['action'] == "SizesGetEditForm") {
                $this->SizesGetEditForm();
            } elseif ($_POST['action'] == "SizesUpdate") {
                $this->SizesUpdate();
            } //-----------------  Types  ----------------------
            elseif ($_POST['action'] == "TypesSave") {
                $this->TypesSave();
            } elseif ($_POST['action'] == "TypesDelete") {
                $this->TypesDelete();
            } elseif ($_POST['action'] == "TypesGetEditForm") {
                $this->TypesGetEditForm();
            } elseif ($_POST['action'] == "TypesUpdate") {
                $this->TypesUpdate();

                //-----------------  Product  ----------------------
            } elseif ($_POST['action'] == 'ProductSave') {
                $this->ProductSave();
            } elseif ($_POST['action'] == 'SetMainFlag') {
                $this->SetMainFlag();
            } elseif ($_POST['action'] == 'ProductUpdate') {
                $this->ProductUpdate();
            } elseif ($_POST['action'] == 'ProductsDelete') {
                $this->ProductsDelete();
            } //-----------------  Category  ----------------------
            elseif ($_POST['action'] == "CategorySave") {
                $this->CategorySave();
            } elseif ($_POST['action'] == "CategoryDelete") {
                $this->CategoryDelete();
            } elseif ($_POST['action'] == "CategoryGetEditForm") {
                $this->CategoryGetEditForm();
            } elseif ($_POST['action'] == "CategoryUpdate") {
                $this->CategoryUpdate();
            } //-----------------  Flowers  ----------------------
            elseif ($_POST['action'] == "FlowersSave") {
                $this->FlowersSave();
            } elseif ($_POST['action'] == "FlowersDelete") {
                $this->FlowersDelete();
            } elseif ($_POST['action'] == "FlowersGetEditForm") {
                $this->FlowersGetEditForm();
            } elseif ($_POST['action'] == "FlowersUpdate") {
                $this->FlowersUpdate();
            }


        } elseif (!empty($_GET)) //события get
        {

            if (isset($_GET['action'])) {
                if ($_GET['action'] == "ProductAddFormShow") {
                    $this->ProductAddFormShow();
                } elseif ($_GET['action'] == "ProductEditFormShow") {
                    $this->ProductEditFormShow();
                } elseif ($_GET['action'] == 'SezonsShow') {
                    $this->SezonsShow();
                } elseif ($_GET['action'] == 'TypesShow') {
                    $this->TypesShow();
                } elseif ($_GET['action'] == 'GammasShow') {
                    $this->GammasShow();
                } elseif ($_GET['action'] == 'StylesShow') {
                    $this->StylesShow();
                } elseif ($_GET['action'] == 'SizesShow') {
                    $this->SizesShow();
                } elseif ($_GET['action'] == 'FlowersShow') {
                    $this->FlowersShow();
                } elseif ($_GET['action'] == 'CategoryShow') {
                    $this->CategoryShow();
                } elseif ($_GET['action'] == 'CategoryInfo') {
                    $this->CategoryInfo();
                } elseif ($_GET['action'] == 'CategoryEdit') {
                    $this->CategoryEdit();
                } elseif ($_GET['action'] == 'OrdersShow') {
                    $this->OrdersShow();
                } elseif ($_GET['action'] == 'ClientsShow') {
                    $this->ClientsShow();
                } elseif ($_GET['action'] == 'FlowersEdit') {
                    $this->FlowersEdit();
                } elseif ($_GET['action'] == 'GetProductSezonList') {
                    $this->GetProductSezonList();
                } elseif ($_GET['action'] == 'GetProductStylesList') {
                    $this->GetProductStylesList();
                } elseif ($_GET['action'] == 'GetProductGammasList') {
                    $this->GetProductGammasList();
                } elseif ($_GET['action'] == 'GetProductSizesList') {
                    $this->GetProductSizesList();
                }

            } else {

                $this->CategoryShow();

            }
        }
        else  $this->CategoryShow();
    }
}


?>