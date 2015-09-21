<?php
define('upload_dir', '/files/goods/');
$user = $modx->getUser();
$profile = $modx->user->getOne('Profile');
if ($user->get('username') != '(anonymous)') {
    $fields = $profile->get('extended');
}



$ses=$_SESSION;


?>


<div class="cart_products table-responsive">
    <div class="top">
     <!--    <span>Дата размещения: <span class="black">30.01.2015 (Получеется после подтверждения)</span></span> -->
        <!-- <span>Номер заказа: 987 (Получеется после подтверждения)</span> -->
        <!-- <span style="margin-right:5px;">Дата доставки:</span> <input class="spec_input" name="delivery_date" id="delivery_date" type="text"> -->
    </div>
    <table class="table">
        <?php
        $summa=0;

        foreach($ses as $key1=>$value1)
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
                        ?>
                        <tr>
                            <td><img class="img-rounded img-card" src="<?php
                            //высчитываем картинку товара
                                $sql_mainimg = "select * from s_prices pr
                                            join s_products p
                                            on p.id=pr.product_id

                                            join s_images i
                                            on i.price_id=pr.id


                                            where (p.id=" . $row['id'] . ")and(pr.active=1)and(i.mainimg=1);";
                                foreach ($modx->query($sql_mainimg) as $rowIMain) {
                                    echo upload_dir . $rowIMain['filename'];
                                }
                                ?>"></td>
                            <td>Название букета “<?php echo $row['title']; ?>”</td>
                            <td><?php
                            
                            //высчитываем цену товара
                                $sql_mainimg = "select * from s_prices pr
                                            join s_products p
                                            on p.id=pr.product_id
                                            where (p.id=" . $row['id'] . ")and(pr.active=1);";
                                foreach ($modx->query($sql_mainimg) as $rowIMain) {
                                    echo $rowIMain['rub'];
                                    $summa=$summa+($rowIMain['rub']*(0+$value1));
                                   // echo $summa;
                                }


                                ?> руб.</td>
                            <td><input type="text" value="<?php echo $value1;?>" id="product_count_<?php echo $row['id']; ?>"
                                       onchange="CardProductChangeCount(<?php echo $row['id']; ?>);"
                            ></td>
                            <td><?php echo  $rowIMain['rub']*$value1;
                            
                            ?> руб.</td>
                            <td><span class="card_product_delete_<?php echo $row['id']; ?>" onclick="CardProductDelete(<?php echo $row['id']; ?>);"><img src="/site/tpl/img/cross.png"></span></td>
                        </tr>
                        <?php

                    }

                }

            }

        }



        ?>

    </table>
</div>

    <div class="form-horizontal">
   
   <!--
        <div class="form-group">
            <label  class="col-sm-4 control-label">Код купона на скидку:</label>
            <div class="col-sm-5">
                <input class="spec_input coupon_code  form-control" value='<?php
                if(isset($ses['coupon_code'])) echo $ses['coupon_code'];
                ?>' type="text">
            </div>
            <div class="col-sm-3">
                <button class="btn btn-default coupon_change" onclick="CardCouponChange();" type="button">Применить</button>
            </div>
        </div>
-->
            
            <?php 
            $skidka=0;
            if(isset($ses['coupon_code']) and (isset($ses['coupon_value']))and(($ses['coupon_value']+0)>0))
            {
                $skidka=round($summa*$ses['coupon_value']/100);
                    ?>



                <div class="form-group">
                    <label  class="col-sm-4 control-label" style="padding-top: 0;">Итого:</label>
                    <div class="col-sm-8">
                        <span><?php echo $summa; ?> руб.</span>
                    </div>
                </div>

                <div class="form-group">
                    <label  class="col-sm-4 control-label" style="padding-top: 0;">Ваша скидка %:</label>
                    <div class="col-sm-8">
                        <span><?php echo $ses['coupon_value']; ?></span>
                    </div>
                </div>
                <div class="form-group">
                    <label  class="col-sm-4 control-label" style="padding-top: 0;">Скидка, руб:</label>
                    <div class="col-sm-8">
                        <span><?php echo $skidka; ?> руб.</span>
                    </div>
                </div>

                    <?php
            }
            
            ?>

        <div class="form-group">
            <label  class="col-sm-4 control-label" style="padding-top: 0;">Итого к оплате:</label>
            <div class="col-sm-8">
                <span> <?php echo $summa-$skidka; ?> руб.</span>
            </div>
        </div>


    </div>

    <br>
    <hr>
<form action="/ordercommit.html" id="OrderForm" class="form-horizontal">
<input type="hidden" name="action" value="OrderCommit">




    <div class="form-group">
        <label  class="col-sm-4 control-label">Когда доставить</label>
        <div class="col-sm-8">
            <input class="spec_input" id="delivery_date" type="text" name="delivery_date">
        </div>
    </div>
<!--
    <div class="form-group">
        <div class="col-sm-offset-4 col-sm-8">
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="user_remind_flag"> Напомнить об этой дате через год
                </label>
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-4 col-sm-8">
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="receiver_call"> Требуется предварительный звонок получателю для уточнения времени и адреса доставки
                </label>
            </div>
        </div>
    </div>
-->
<hr>
<div class="cart_poluchatel">
    <h4>ПОЛУЧАТЕЛЬ</h4>
    <?php
/*
        if ($user->get('username') != '(anonymous)') {
            $sql_receiver="select * from s_receiver where user_id=".$user->get('id');
            ?>
            <div>
                <span>Я уже отправлял этому получателю (для зарегистрированных)</span>
                <select class="spec_input receiver" name="receiver" onchange='GetReceiver($( ".receiver option:selected" ).val());'>
                    <option value="0">Новый</option>
            <?php
            foreach ($modx->query($sql_receiver) as $row_receiver)
            {
                ?>
                <option value="<?php echo $row_receiver['id']; ?>"><?php echo $row_receiver['receiver_name']; ?></option>
                <?php
            }


            ?>

                </select>
            </div>
            <?php
        }*/
    ?>


    <!-- --------------------------------------- -->
    <!--            ПОЛУЧАТЕЛЬ                  -->
    <div id="receiver_data">
        <div class="form-group">
            <label  class="col-sm-4 control-label">ФИО</label>
            <div class="col-sm-8">
                <input placeholder="Косов Андрей Владимирович" type="text" class="spec_input form-control" name="receiver_name">
            </div>
        </div>

        <div class="form-group">
            <label  class="col-sm-4 control-label">Телефон</label>
            <div class="col-sm-8">
                <input placeholder="+7 906 123-45-67" type="text" class="spec_input form-control" name="receiver_phone">
            </div>
        </div>

        <div class="form-group">
            <label  class="col-sm-4 control-label">Населенный пункт</label>
            <div class="col-sm-8">
                <input  type="text" class="spec_input form-control" name="receiver_sity">
            </div>
        </div>

        <div class="form-group">
            <label  class="col-sm-4 control-label">Улица</label>
            <div class="col-sm-8">
                <input  type="text" class="spec_input form-control" name="receiver_street">
            </div>
        </div>

        <div class="form-group">
            <label  class="col-sm-4 control-label">Дом</label>
            <div class="col-sm-8">
                <input  type="text" class="spec_input form-control" name="receiver_house">
            </div>
        </div>

        <div class="form-group">
            <label  class="col-sm-4 control-label">Корпус</label>
            <div class="col-sm-8">
                <input  type="text" class="spec_input form-control" name="receiver_corpus">
            </div>
        </div>

        <div class="form-group">
            <label  class="col-sm-4 control-label">Подъезд</label>
            <div class="col-sm-8">
                <input  type="text" class="spec_input form-control" name="receiver_podezd">
            </div>
        </div>

        <div class="form-group">
            <label  class="col-sm-4 control-label">Этаж</label>
            <div class="col-sm-8">
                <input  type="text" class="spec_input form-control" name="receiver_etaj">
            </div>
        </div>

        <div class="form-group">
            <label  class="col-sm-4 control-label">Квартира</label>
            <div class="col-sm-8">
                <input  type="text" class="spec_input form-control" name="receiver_kvartira">
            </div>
        </div>

        <div class="form-group">
            <label  class="col-sm-4 control-label">Код домофона</label>
            <div class="col-sm-8">
                <input  type="text" class="spec_input form-control" name="receiver_domofon_code">
            </div>
        </div>
        <div class="form-group">
            <label  class="col-sm-4 control-label">Дополнительная информация:</label>
            <div class="col-sm-8">
                <textarea class="spec_input form-control" name="dopinfo"></textarea>
            </div>
        </div>
<!--
        <div class="form-group">
            <div class="col-sm-offset-4 col-sm-8">
                <div class="checkbox">
                    <label>
                        <input type="checkbox"  name="receiver_free_photo"> Бесплатная фотография заказа
                    </label>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-4 col-sm-8">
                <div class="checkbox">
                    <label>
                        <input type="checkbox"  name="receiver_photo"> Фотография момента вручение заказа получателю (50 руб.)
                    </label>
                </div>
            </div>
        </div>
-->


    </div>
</div>  <hr>
<!-- --------------------------------------- -->
<!--            ЗАКАЗЧИК                  -->
<?php
if ($user->get('username') != '(anonymous)') {
    ?>
<div class="cart_cont_dan">
    <h4>Ваши контактные данные</h4>


    <div class="form-group">
        <label  class="col-sm-4 control-label">ФИО</label>
        <div class="col-sm-8">
            <input class="spec_input  form-control" type="text"
                   placeholder="Косов Андрей Владимирович"
                   name="user_fio"  value="<?php echo $profile->get('fullname');?>">
        </div>
    </div>

    <div class="form-group">
        <label  class="col-sm-4 control-label">Телефон</label>
        <div class="col-sm-8">
            <input class="spec_input form-control" type="text"
                   value="<?php echo $profile->get('phone');?>"
                   placeholder="+7 906 123-45-67"  name="user_phone">
        </div>
    </div>

    <div class="form-group">
        <label  class="col-sm-4 control-label">E-mail</label>
        <div class="col-sm-8">
            <input class="spec_input  form-control" type="email"
                   value="<?php echo $profile->get('email');?>"
                   placeholder="+7 906 123-45-67"  name="user_email">
        </div>
    </div>





</div>

    <?php
}

else
{
    ?>
<div class="cart_cont_dan">
    <h4>Ваши контактные данные</h4>


    <div class="form-group">
        <label  class="col-sm-4 control-label">ФИО</label>
        <div class="col-sm-8">
            <input class="spec_input  form-control" type="text" required
                   placeholder="Косов Андрей Владимирович"
                   name="user_fio"  value="">
        </div>
    </div>

    <div class="form-group">
        <label  class="col-sm-4 control-label">Телефон</label>
        <div class="col-sm-8">
            <input class="spec_input form-control" type="text" required
                   value=""
                   placeholder="+7 906 123-45-67"  name="user_phone">
        </div>
    </div>

    <div class="form-group">
        <label  class="col-sm-4 control-label">E-mail</label>
        <div class="col-sm-8">
            <input class="spec_input  form-control" type="email" required
                   value=""
                   placeholder="+7 906 123-45-67"  name="user_email">
        </div>
    </div>



</div>
    <?php
}
?>
<div class="form-group capcha">
    <label class="col-sm-4 control-label" for="ca">Введите капчу</label>
    <div class="col-sm-8">
        <img src="assets/components/captcha/captcha.php" alt="Captcha Image" /><br>
    </div>
</div>


<?php
//echo $_SESSION['veriword'];
$_SESSION['m_veriword']=$_SESSION['veriword'];
?>


<div class="form-group capcha">

    <div class="col-sm-offset-4 col-sm-8">
        <input type="text" name='ca'  class="spec_input  form-control" value="">
    </div>
</div>

<div class="form-group">
    <label  class="col-sm-4 control-label" style="padding-top: 0;">Сумма вашего заказа:</label>
    <div class="col-sm-8">
        <span> <?php echo $summa-$skidka; ?> руб.</span>
    </div>
</div>
<hr>

            <button type="button" class="btn btn-lg  OrderCommitBtn" onclick="OrderSubmit();">Подтвердить заказ</button>
            <button type="submit" class="" style="display: none;">Подтвердить заказ</button>


        <h4>Остались вопросы? звоните +7 (846) 990 09 32, +7 927 260 09 32 (с 7:30 до 20:00)</h4>

<hr>
<div class="form-group">
    <div class="col-sm-offset-4 col-sm-8">
        <div class="checkbox">
            <label>
                <input type="checkbox" name="user_recall"> Перезвоните мне, у меня остались вопросы
            </label>
        </div>
    </div>
</div>

</form>
