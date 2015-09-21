<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Elex
 * Date: 13.04.15
 * Time: 11:58
 * To change this template use File | Settings | File Templates.
 */
define('upload_dir', '/files/goods/');
if (isset($_GET['action'])) {
    if (($_GET['action'] == 'OrderCommit')and($_SESSION['veriword']==$_GET['ca'])) {


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

        $user_fio = 0;
        if (isset($_GET['user_fio'])) $user_fio = mysql_escape_string($_GET['user_fio']);

        $user_email = 0;
        if (isset($_GET['user_email'])) $user_email = mysql_escape_string($_GET['user_email']);

        $user_phone = 0;
        if (isset($_GET['user_phone'])) $user_phone = mysql_escape_string($_GET['user_phone']);
        
        $delivery_date = 0;
        if (isset($_GET['delivery_date'])) $delivery_date = mysql_escape_string($_GET['delivery_date']);


        $user_remind_flag=0;
        $receiver_call=0;
        if (isset($_GET['user_remind_flag'])) $user_remind_flag = 1;
        if (isset($_GET['receiver_call'])) $receiver_call = 1;
        if (isset($_GET['receiver_free_photo'])) $receiver_free_photo = 1;
        if (isset($_GET['receiver_photo'])) $receiver_photo = 1;
        if (isset($_GET['w_akc'])) $w_akc = 1;
        if (isset($_GET['user_recall'])) $user_recall = 1;



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

        //echo  $sql . "<br/>";
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
                            echo upload_dir . $rowIMain['filename'];
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
      //  echo $sql_update_summa;
        $modx->query($sql_update_summa);


        //херим сесионные данные заказа
        foreach ($_SESSION as $key => $value) {
            if (substr($key, 0, 3) == 'pro') {
                echo $key . " " . $value . " " . substr($key, 0, 3);
                unset($_SESSION[$key]);
            }
        }

//--------------------------------------------
        //  СООБЩЕНИЕ


        $sql = "select * from s_orders where id='" . $_SESSION['LastOrderID'] . "';";
        $msg='<div class="cart_list_products">';
        foreach ($modx->query($sql) as $row) {
            // echo "<pre>";
            //  print_r($row);
            //  echo"</pre>";

            $status = $row['status'] + 0;
            $order_id = $row['id'];
            $delivery_date = $row['delivery_date'];

            $coupon_code = $row['coupon_code'];
            $coupon_value = $row['coupon_value'];
            $user_fio = $row['user_fio'];
            $user_phone = $row['user_phone'];
            $user_email = $row['user_email'];
            $receiver_id = $row['receiver_id'];
            $user_id = $row['user_id'];
            $order_date = $row['order_date'];
            $summa = $row['summa'];
            $user_remind_flag = $row['user_remind_flag'];
            $receiver_call = $row['receiver_call'];

            $receiver_free_photo = $row['receiver_free_photo'];
            $receiver_photo = $row['receiver_photo'];
            $w_akc = $row['w_akc'];
            $user_recall = $row['user_recall'];
            $url=$row['qq'];

        }

        $order_date = strtotime($order_date);
        $order_date = date("d.m.Y h:m", $order_date);
        $delivery_date = strtotime($delivery_date);
        $delivery_date = date("d.m.Y h:m", $delivery_date);


        $msg.="<h1>Заказ № ".$order_id."</h1>";

        $msg.='
<div class="cart_products">
    <div class="top">
        <h3>Дата размещения: <span class="black"></span>'.$order_date.'</h3>
        <h3>Номер заказа: '.$order_id.' </h3>
        <h3>Дата доставки: '.$delivery_date.' </h3>

    </div>
    ';
        $msg.='<table class="table">';

        $sql = "select * from s_purchases where order_id=" . $order_id;
        foreach ($modx->query($sql) as $row) {
            $msg.='
            <tr>
                <td><img src="'.upload_dir . $row['img'].'" class="img-card"></td>
                <td>Название букета “'.$row['product_name'].'”</td>
                <td>'.$row['price'].' руб.</td>
                <td>'.$row['amount'].'шт.
                </td>
                <td>'.($row['price'] * $row['amount']).' руб.</td>
            </tr>
           ';
        }

        $msg.='
    </table>
    <div class="bottom">
        <div class="left">

        </div>
        <div class="right">
            <span>Итого к оплате</span>'.$summa.' руб.
        </div>
    </div>

';



        if($user_remind_flag==1)
        {

            $msg.='<div class="">Напомнить об этой дате через год</div>';

        }
        if($receiver_call==1)
        {
            $msg.='<div class="">Требуется предварительный звонок получателю для уточнения времени и адреса доставки</div>';

        }

        if($receiver_free_photo==1)
        {
            $msg.='<div class="">Бесплатная фотография заказа</div>';
        }

        if($receiver_photo==1)
        {
            $msg.='<div class="">Фотография момента вручение заказа получателю (50 руб.)</div>';
        }
        if($w_akc==1)
        {
            $msg.='<div class="">Хочу получать информацию о акциях и скидках</div>';
        }
        if($user_recall==1)
        {
            $msg.='<div class="">Перезвоните мне, у меня остались вопросы</div>';
        }

$msg.='</div>


<p>Вы всегда можете проверить состояние заказа по ссылке:<br>
	<a href="http://'.$_SERVER['HTTP_HOST'].'/ordercommit.html?qq='.$url.'">http://'.$_SERVER['HTTP_HOST'].'/ordercommit.html?qq='.$url.'</a>	</p>

	<p><strong>Обращаем Ваше внимание</strong>, что окончательная стоимость заказа, а также количество услуг, товаров и подарков, будут подтверждены после обработки заказа сотрудником Компании. </p>

	<p><strong>С уважением,<br>«ohapka63.ru»</strong></p>

	<hr>

	<p>© 2015 «ohapka63.r»</p>
';
//--------------------------------------
//--------------------------------------
       // echo $msg;
        $subject = "ваш заказ № " . $_SESSION['LastOrderID'];
        //отпраляем емаил
        $modx->getService('mail', 'mail.modPHPMailer');
        $modx->mail->set(modMail::MAIL_BODY, $msg);
        $modx->mail->set(modMail::MAIL_FROM, $modx->getOption('emailsender'));

        $modx->mail->set(modMail::MAIL_FROM_NAME, $modx->getOption('site_name'));

        $modx->mail->set(modMail::MAIL_SENDER, $modx->getOption('emailsender'));

        $modx->mail->set(modMail::MAIL_SUBJECT, $subject);
        $modx->mail->address('to', $user_email);
        $modx->mail->address('reply-to', $adminEmail);
        $modx->mail->setHTML(true);
        if (!$modx->mail->send()) {
            echo "erro";
        }
        $modx->mail->reset();
        //---------------------------------------------------

//-----------------------------------------------------------------------
//-----------------------------------------------------------------------
        // - 4 - редиректим на стр заказа


        //далее редиректим на order
      //  header('Location: http://' . $_SERVER['HTTP_HOST'] . '/ordercommit.html?qq=' . $url);


    }

} elseif (isset($_GET['qq'])) //это просмотр заказа
{
    $sql = "select * from s_orders where url='" . mysql_escape_string($_GET['qq']) . "';";

    foreach ($modx->query($sql) as $row) {
       // echo "<pre>";
      //  print_r($row);
      //  echo"</pre>";

        $status = $row['status'] + 0;
        $order_id = $row['id'];
        $delivery_date = $row['delivery_date'];

        $coupon_code = $row['coupon_code'];
        $coupon_value = $row['coupon_value'];
        $user_fio = $row['user_fio'];
        $user_phone = $row['user_phone'];
        $user_email = $row['user_email'];
        $receiver_id = $row['receiver_id'];
        $user_id = $row['user_id'];
        $order_date = $row['order_date'];
        $summa = $row['summa'];
        $user_remind_flag = $row['user_remind_flag'];
        $receiver_call = $row['receiver_call'];

        $receiver_free_photo = $row['receiver_free_photo'];
        $receiver_photo = $row['receiver_photo'];
        $w_akc = $row['w_akc'];
        $user_recall = $row['user_recall'];

    }
    $url=mysql_escape_string($_GET['qq']);
    ?>
    <div class="card">
<h3 class="card-form-h3">Заказ № <?php echo $order_id; ?> </h3>
<h3  class="card-form-h3">
    Статус: <?php
    if ($status == 0) echo "В обработке";
    if ($status == 1) echo "Оплачен";
    if ($status == 2) echo "Доставлен";
    ?>
</h3>
<div class="cart_products">
    <div class="top1">
        <h3>Дата размещения: <span class="black"><?php 
        $order_date = strtotime($order_date);
        $order_date = date("d.m.Y h:m", $order_date);
        echo $order_date; ?></span></h3>
        <h3>Номер заказа: <?php echo $order_id; ?> </h3>
        <h3>Дата доставки: <?php 
        
        $delivery_date = strtotime($delivery_date);
        $delivery_date = date("d.m.Y h:m", $delivery_date);
        echo $delivery_date; ?></h3>
        
    </div>
    <table class="table">
        <?php
        $sql = "select * from s_purchases where order_id=" . $order_id;
        foreach ($modx->query($sql) as $row) {
            ?>
            <tr>
                <td><img src="<?php echo upload_dir . $row['img']; ?>" class="img-card"></td>
                <td>Название букета “<?php echo $row['product_name']; ?>”</td>
                <td><?php echo $row['price']; ?> руб.</td>
                <td><?php echo $row['amount']; ?> шт.
                </td>
                <td><?php echo $row['price'] * $row['amount']; ?> руб.</td>
            </tr>
            <?php
        }
        ?>
    </table>
    <div class="bottom">
        <div class="left">
            <?php
            //Код купона на скидку:
            //if(isset($coupon_code)) echo $coupon_code;
?>
        </div>
        <div class="right">

            <?php
            /*
            $skidka=0;
            if(isset($coupon_code) and (isset($coupon_value))and(($coupon_code+0)>0))
            {
                $skidka=round($summa*$coupon_value/100);
                ?>
                <span>Итого:</span> <?php echo $summa; ?> руб.<br>
                <span>Ваша скидка %:</span> <?php echo $coupon_value; ?><br>
                <span>Скидка, руб:</span> <?php echo $skidka; ?> руб.<br>
                <?php
            }
*/
            ?>
            <span>Итого к оплате</span> <?php
            //echo $summa-$skidka;
            echo $summa;
            ?> руб.
        </div>
    </div>



    <?php

    if($user_remind_flag==1)
    {
        ?>
        <div class="">Напомнить об этой дате через год</div>
        <?php
    }
    if($receiver_call==1)
    {
        ?>
        <div class="">Требуется предварительный звонок получателю для уточнения времени и адреса доставки</div>
        <?php
    }

    if($receiver_free_photo==1)
    {
        ?>
        <div class="">Бесплатная фотография заказа</div>
        <?php
    }

    if($receiver_photo==1)
    {
        ?>
        <div class="">Фотография момента вручение заказа получателю (50 руб.)</div>
        <?php
    }
    if($w_akc==1)
    {
        ?>
        <div class="">Хочу получать информацию о акциях и скидках</div>
        <?php
    }
    if($user_recall==1)
    {
        ?>
        <div class="">Перезвоните мне, у меня остались вопросы</div>
        <?php
    }

    if ($status == 0) {
        // 2.
        // Оплата заданной суммы с выбором валюты на сайте ROBOKASSA
        // Payment of the set sum with a choice of currency on site ROBOKASSA

        // регистрационная информация (логин, пароль #1)
        // registration info (login, password #1)
        $mrh_login = "ohapka63.ru";
        $mrh_pass1 = "1qazxsw2";

        // номер заказа
        // number of order
        $inv_id = 0;

        // описание заказа
        // order description
        $inv_desc = "http://" . $_SERVER['HTTP_HOST'] . '/ordercommit.html?qq=' . $url;

        // сумма заказа
        // sum of order
        $out_summ = $summa;

        // тип товара
        // code of goods
        $shp_item = "1";

        // предлагаемая валюта платежа
        // default payment e-currency
        $in_curr = "";

        // язык
        // language
        $culture = "ru";

        // формирование подписи
        // generate signature
        $crc  = md5("$mrh_login:$out_summ:$inv_id:$mrh_pass1:Shp_item=$shp_item");
        //return  $crc;


        print "<html>".
            "<form class='cart_punkt_vidachi'  action='https://merchant.roboxchange.com/Index.aspx' method=POST>".
            "<input type=hidden name=MrchLogin value=$mrh_login>".
            "<input type=hidden name=OutSum value=$out_summ>".
            "<input type=hidden name=InvId value=$inv_id>".
            "<input type=hidden name=Desc value='$inv_desc'>".
            "<input type=hidden name=SignatureValue value=$crc>".
            "<input type=hidden name=Shp_item value='$shp_item'>".
            "<input type=hidden name=IncCurrLabel value=$in_curr>".
            "<input type=hidden name=Culture value=$culture>".
            "<input type=submit value='Перейти к оплате' class='w-button card-submit'>".
            "</form></html>";


    }
    ?>
</div>
</div>

<?php
}
