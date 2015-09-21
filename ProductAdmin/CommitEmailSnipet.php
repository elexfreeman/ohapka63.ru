<?php
/**
 * Created by JetBrains PhpStorm.
 * User: User
 * Date: 30.08.15
 * Time: 8:44order_id=".$_SESSION['LastOrderID']
 * To change this template use File | Settings | File Templates.
 */

$sql = "select * from s_orders where id='" . $_SESSION['LastOrderID'] . "';";

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

?>

<h1>Заказ № <?php echo $order_id; ?> </h1>
<h3>
    Статус: <?php
    if ($status == 0) echo "В обработке";
    if ($status == 1) echo "Оплачен";
    if ($status == 2) echo "Доставлен";
    ?>
</h3>
<div class="cart_products">
    <div class="top">
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