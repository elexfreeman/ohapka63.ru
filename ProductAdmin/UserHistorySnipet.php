<?php
?>
<table class="table">

    <tr>
        <th>№</th>
        <th>Дата оформления</th>
        <th>Дата доставки</th>
        <th>Состав заказа</th>
        <th>Получатель</th>
        <th>Способ оплаты</th>
        <th>Статус заказа</th>
        <th>Сумма</th>
        <th></th>
    </tr>

        <?php
            $sql="select * from s_orders o
                    join s_receiver r
                    on o.receiver_id=r.id
                    where o.user_id=".$modx->user->get('id');
    echo $sql;
          foreach ($modx->query($sql) as $row) {
              ?>
              <tr>
                  <td><a href="<?php echo 'http://' . $_SERVER['HTTP_HOST'] . '/ordercommit.html?qq=' . $row['url']; ?>"><?php echo $row['id']; ?></a></td>
                  <td><?php echo $row['order_date']; ?></td>
                  <td><?php echo $row['delivery_date']; ?></td>
                  <td></td>
                  <td><?php echo $row['receiver_name']; ?></td>
                  <td><?php echo $row['id']; ?></td>
                  <td><?php echo $row['status']; ?></td>
                  <td><?php echo $row['summa']; ?></td>

              </tr>
              <?php
          }

        ?>


</table>

<?php