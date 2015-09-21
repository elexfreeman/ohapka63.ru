<h2>Заказы</h2>


<div class="container">
    <div class="table-responsive">
    <table class="table">

        <tr>
            <th>№</th>
            <th>Пользователь</th>
            <th>email</th>
            <th>Телефон</th>
            <th>Дата оформления</th>
            <th>Дата доставки</th>
            <th>Состав заказа</th>
            <th>Получатель</th>
            <th>Способ оплаты</th>
            <th>Статус заказа</th>
            <th>Сумма</th>
            <th>Бесплатная фотография заказа</th>
            <th>Фотография момента вручение заказа получателю (50 руб.)</th>
        </tr>

        <?php
        $sql="select
o.id order_id,
o.delivery_id delivery_id,
o.delivery_price delivery_price,
o.delivery_date delivery_date,
o.order_date order_date,
o.user_remind_flag user_remind_flag,
o.receiver_free_photo receiver_free_photo,
o.receiver_photo receiver_photo,
o.receiver_id,
o.url,
o.user_id,
o.user_phone,
o.user_email,
o.`status` order_status,
o.summa,
u.username,
r.receiver_name

from s_orders o
join s_receiver r
on o.receiver_id=r.id


left join  modx_users   u
on u.id=o.user_id
order by o.id desc
;";
                   ;
        //echo $sql;
        foreach ($modx->query($sql) as $row) {
            ?>
            <tr>
                <td><a href="<?php echo 'http://' . $_SERVER['HTTP_HOST'] . '/ordercommit.html?qq=' . $row['url']; ?>"><?php echo $row['order_id']; ?></a></td>
                <td><a href="<?php echo 'http://' . $_SERVER['HTTP_HOST'] . '/ProductAdmin/?action=ShowUser&user_id='.$row['user_id']; ?>"><?php echo $row['username']; ?></a></td>
                <td><?php echo $row['user_email']; ?></td>
                <td><?php echo $row['user_phone']; ?></td>
                <td><?php echo $row['order_date']; ?></td>
                <td><?php echo $row['delivery_date']; ?></td>
                <td></td>
                <td><?php echo $row['receiver_name']; ?></td>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['order_status']; ?></td>
                <td><?php echo $row['summa']; ?></td>
                <td><?php
                        if($row['receiver_free_photo']=='1') echo 'Да'; else echo 'Нет';

                    ?></td>
                <td><?php
                    if($row['receiver_photo']=='1') echo 'Да'; else echo 'Нет';
                   ?></td>
            </tr>
            <?php
        }

        ?>


    </table>
</div>
</div>