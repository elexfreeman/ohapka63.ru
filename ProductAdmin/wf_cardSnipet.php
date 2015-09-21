<?php
define('upload_dir', '/files/goods/');
$user = $modx->getUser();
$profile = $modx->user->getOne('Profile');
if ($user->get('username') != '(anonymous)') {
    $fields = $profile->get('extended');
}


//Ищем кол-во товаров в крзине



$ses=$_SESSION;

$count=0;
foreach($ses as $key1=>$value1) {

    if (substr($key1, 0, 3) == 'pro') {
        $count++;
    }
}

if($count>0) {

    ?>


    <div class="card-product-list">
        <?php
        $summa = 0;

        foreach ($ses as $key1 => $value1) {

            if (substr($key1, 0, 3) == 'pro') {
                $value1 = $value1 + 0;
                if ($value1 > 0) {
                    $kk = explode("_", $key1);


                    $sql = "select * from s_products WHERE id=" . $kk[1];
                    // echo $key1." ".$sql."<br>";
                    foreach ($modx->query($sql) as $row) {
                        ?>
                        <div class="w-row card-products-row">
                            <div class="w-col w-col-2 w-col-small-2 w-col-tiny-2 card-img-column">
                                <img class="card-product-img" src="<?php
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
                                ?>">
                            </div>
                            <div class="w-col w-col-3 w-col-small-3 w-col-tiny-3 card-column-title">
                                <div>Название букета “<?php echo $row['title']; ?>”</div>
                            </div>
                            <div class="w-col w-col-2 w-col-small-2 w-col-tiny-2 card-column-count">
                                <div><?php

                                    //высчитываем цену товара
                                    $sql_mainimg = "select * from s_prices pr
                                            join s_products p
                                            on p.id=pr.product_id
                                            where (p.id=" . $row['id'] . ")and(pr.active=1);";
                                    foreach ($modx->query($sql_mainimg) as $rowIMain) {
                                        echo $rowIMain['rub'];
                                        $summa = $summa + ($rowIMain['rub'] * (0 + $value1));
                                        // echo $summa;
                                    }


                                    ?> руб.
                                </div>
                            </div>
                            <div class="w-col w-col-2 w-col-small-2 w-col-tiny-2 card-column-count2">
                                <div><input type="text" class="w-input" value="<?php echo $value1; ?>"
                                            id="product_count_<?php echo $row['id']; ?>"
                                            onchange="CardProductChangeCount(<?php echo $row['id']; ?>);"
                                        ></div>
                            </div>
                            <div class="w-col w-col-2 w-col-small-2 w-col-tiny-2 card-column-count">
                                <div><?php echo $rowIMain['rub'] * $value1;

                                    ?> руб.
                                </div>
                            </div>
                            <div class="w-col w-col-1 w-col-small-1 w-col-tiny-1 card-column-count">
                                <div onclick="CardProductDelete(<?php echo $row['id']; ?>);"
                                     class="click card_product_delete_<?php echo $row['id']; ?>"><strong>X</strong>
                                </div>
                            </div>
                        </div>


                    <?php

                    }


                }

            }

        }

        ?>

        <div class="card-product-itog">
            <div>Итого к оплате: <span class="card-itog"><?php echo $summa; ?> руб.</span></div>
        </div>

    </div>


    <div class="card">
        <div class="w-form">
            <form id="email-form" name="email-form" data-name="Email Form" action="/ordercommit.html">
                <input type="hidden" name="action" value="OrderCommit">
                <label class="card-form-label" for="delivery_date">Когда доставить? (дата и время доставки)</label>
                <input class="w-input" id="delivery_date" type="text" name="delivery_date" required="required"
                       data-name="delivery_date">

                <h3 class="card-form-h3">Кому доставлять букет? (получатель)</h3>
                <label class="card-form-label" for="receiver_name">Как зовут получателя?</label>
                <input class="w-input" id="receiver_name" type="text" placeholder="Косов Андрей Владимирович"
                       name="receiver_name" data-name="receiver_name">

                <label class="card-form-label" for="receiver_phone">Какой у него номер телефона?</label>
                <input class="w-input" id="receiver_phone" type="text" placeholder="8 800 2000 300"
                       name="receiver_phone" data-name="receiver_phone">

                <label class="card-form-label" for="receiver_sity">В каком городе живет?</label>
                <input class="w-input" id="receiver_sity" type="text" placeholder="Самара" name="receiver_sity"
                       data-name="receiver_sity">

                <label class="card-form-label" for="receiver_street">Улица</label>
                <input class="w-input" id="receiver_street" type="text" placeholder="Самарская" name="receiver_street"
                       data-name="receiver_street">

                <label class="card-form-label" for="receiver_house">Номер дома</label>
                <input class="w-input" id="receiver_house" type="text" placeholder="32" name="receiver_house"
                       data-name="receiver_house">

                <label class="card-form-label" for="receiver_corpus">Корпус</label>
                <input class="w-input" id="receiver_corpus" type="text" placeholder="1" name="receiver_corpus"
                       data-name="receiver_corpus">

                <label class="card-form-label" for="receiver_podezd">Подъезд</label>
                <input class="w-input" id="receiver_podezd" type="text" placeholder="2" name="receiver_podezd"
                       data-name="receiver_podezd">

                <label class="card-form-label" for="receiver_etaj">Этаж</label>
                <input class="w-input" id="receiver_etaj" type="text" placeholder="3" name="receiver_etaj"
                       data-name="receiver_etaj">

                <label class="card-form-label" for="receiver_kvartira">Номер квартиры</label>
                <input class="w-input" id="receiver_kvartira" type="text" placeholder="65" name="receiver_kvartira"
                       data-name="receiver_kvartira">

                <label class="card-form-label" for="receiver_domofon_code">Код домофона</label>
                <input class="w-input" id="receiver_domofon_code" type="text" placeholder="125"
                       name="receiver_domofon_code" data-name="receiver_domofon_code">

                <label class="card-form-label" for="dopinfo">Дополнительная информация:</label>
                <textarea class="w-input" id="dopinfo" name="dopinfo" data-name="dopinfo"></textarea>

                <h3 class="card-form-h3">Как нам с Вами связаться?</h3>
                <label class="card-form-label" for="user_fio">Как Вас зовут?</label>
                <input class="w-input" id="user_fio" type="text" placeholder="Антон Помидоров"
                       name="user_fio" data-name="user_fio" required="required">

                <label class="card-form-label" for="user_phone">Ваш телефон?</label>
                <input class="w-input" id="user_phone" type="text" placeholder="+7 932 145 87 12" name="user_phone"
                       data-name="user_phone" required="required">

                <label class="card-form-label" for="user_email">Ваша электронная почта?</label>
                <input class="w-input" id="user_email" type="text" placeholder="example@mail.ru" name="user_email"
                       data-name="user_email" required="required">

                <label class="card-form-label" for="ca">Введите текст с картинки</label>
                <img src="assets/components/captcha/captcha.php" alt="Captcha Image"/><br>
                <input class="w-input" id="ca" type="text" name="ca" data-name="ca" required="required">
                <?php
                //echo $_SESSION['veriword'];
                $_SESSION['m_veriword'] = $_SESSION['veriword'];
                ?>
                <input onclick="OrderSubmit();" class="w-button card-submit OrderCommitBtn" type="button"
                       value="Подтвердить заказ" data-wait="Please wait...">

                <button type="submit" class="" style="display: none;">Подтвердить заказ</button>


                <h3 class="card-form-h3">Остались вопросы? Звоните!<br>
                    <span class="card-phone">+7 (846) 990 09 32, +7 927 260 09 32 <br>(с 9:00 до 21:00)</span>
                </h3>
            </form>
            <div class="w-form-done"><p>Thank you! Your submission has been received!</p></div>
            <div class="w-form-fail"><p>Oops! Something went wrong while submitting the form</p></div>
        </div>
    </div>

<?php
}
else

{
    ?>
    <div class="card">
        <h3 class="card-form-h3">Корзина пустая</h3>
        </div>
<?php
}