<?php
$category_id = $scriptProperties['id'];
$title = $scriptProperties['title'];
$sql = "
select * from s_products where title='".$title."';";


//--------------------------------------------------
//      Курс валют ЦБР
/*
$list = array();

$xml = new DOMDocument();
$url = 'http://www.cbr.ru/scripts/XML_daily.asp?date_req=' . date('d.m.Y');

if (@$xml->load($url))
{
    $list = array();

    $root = $xml->documentElement;
    $items = $root->getElementsByTagName('Valute');

    foreach ($items as $item)
    {
        $code = $item->getElementsByTagName('CharCode')->item(0)->nodeValue;
        $curs = $item->getElementsByTagName('Value')->item(0)->nodeValue;
        $list[$code] = floatval(str_replace(',', '.', $curs));
    }
}


$cur="USD";
// echo "йСПЯ USD = ".isset($this->list[$cur]) ? $this->list[$cur] : 0;

$CurentCursUSD=isset($list[$cur]) ? $list[$cur] : 0;

$cur="EUR";
$CurentCursEUR=isset($list[$cur]) ? $list[$cur] : 0;

*/
//**************************************************


foreach ($modx->query($sql) as $row) {


    ?>
<script>
    function ShowValute(valute)
    {
        if(valute=='eur')
        {
        //.removeClass
            $(".rub").removeClass('active');
            $(".eur").removeClass('active');
            $(".usd").removeClass('active');
            $(".eur").addClass('active');

            $(".priceRUB").hide();
            $(".priceUSD").hide();
            $(".priceEUR").show();
        }

        if(valute=='usd')
        {
            //.removeClass
            $(".rub").removeClass('active');
            $(".eur").removeClass('active');
            $(".usd").removeClass('active');
            $(".usd").addClass('active');

            $(".priceRUB").hide();
            $(".priceUSD").show();
            $(".priceEUR").hide();
        }


        if(valute=='rub')
        {
            //.removeClass
            $(".rub").removeClass('active');
            $(".eur").removeClass('active');
            $(".usd").removeClass('active');
            $(".rub").addClass('active');

            $(".priceRUB").show();
            $(".priceUSD").hide();
            $(".priceEUR").hide();
        }
    }
</script>
<div id="product">
    <div class="product_photo">

    </div>
    <div class="product_prices">
        <h1><?php echo $row['title']." ".$row['id']; ?></h1>
        <div class="titles">

            <div class="left">
                Цена
            </div>
            <div class="right">
                <span class="active rub" onclick="ShowValute('rub');">
                    <span>РУБ</span>
                </span>
                <span class="usd" onclick="ShowValute('usd');">
                    <span>USD</span>
                </span>
                <span class="eur" onclick="ShowValute('eur');">
                     <span>EUR</span>
                </span>
            </div>
        </div>
        <form>
            <?php
            $sql_prices="select * from s_prices where product_id=".$row['id'];
            foreach ($modx->query($sql_prices) as $row_prices) {


                ?>
                <label>
                    <input <?php
                        if($row_prices['active']=='1')
                        {
                            echo " checked ";
                        }
                        ?>

                            type="radio" name="kol" onclick="GetSostavBuketa(<?php echo $row_prices['id']; ?>)">
                    <span class="count"><?php echo $row_prices['caption']; ?></span>
                    <span class="priceRUB"><strong><?php echo $row_prices['rub']; ?></strong>  руб</span>
                    <span class="priceEUR" style="display:none;"><strong><?php echo round($row_prices['rub']/$CurentCursEUR); ?></strong>  EUR</span>
                    <span class="priceUSD" style="display:none;"><strong><?php echo round($row_prices['rub']/$CurentCursUSD); ?></strong>  USD</span>
                </label>
                <?php
                if($row_prices['active']=='1')
                {
                    ?>
                    <script>
                        $(document).ready(function(){
                            GetSostavBuketa(<?php echo $row_prices['id']; ?>);
                        });
                    </script>

                    <?php
                }
            }

            ?>

            <div class="soc">
                <div class="right">
                    <img src="/site/tpl/img/product_visa.png">
                    <img src="/site/tpl/img/product_mastercard.png">
                </div>
            </div>
            <input type="submit" value="Заказать">
        </form>
        <div class="phone">
            Есть вопросы? Звоните!<br>
            <span>+7 846 333-07-11</span>
        </div>
    </div>
    <div class="product_info">
        <div class="sostav">
            <p class="spec_zag">Состав букета:</p>
            <div class="sostav_info">
                Роза красная, Гран-при, 60 см 25 шт, Салал, Бумага упоковочная, Лента
            </div>
        </div>
        <div class="about">
            <p class="spec_zag">О букете:</p>
            <div class="about_info">
                <?php echo $row['description']; ?>
            </div>
            <span class="show_more">Подробнее</span>
        </div>
    </div>
</div>

<?php

}