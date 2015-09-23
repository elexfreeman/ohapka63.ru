<?php
define('upload_dir', '/files/goods/');

if (isset($scriptProperties['seazon'])) $seazon = $scriptProperties['seazon'];


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

$sql = "SELECT
    p.id,
p.title,
p.articul,
-- p.p_count,
p.doc_id,
p.img


FROM s_products p


where p.category=2
order by p.title
";

$sql="SELECT
    p.id,
p.title,
p.articul,
-- p.p_count,
p.doc_id,
p.img,
p.description

FROM s_products p

-- join  s_product_sezons ps
-- on ps.product_id=p.id

-- join s_seazons seazons
-- on seazons.id=ps.sezon_id



where (p.category=2)
-- and(seazons.title='".$seazon."')
order by p.articul";

//echo $sql;
$sk=0;

?>

<script>
    //close-modal
    $(document).ready(function(){
      /*  $( ".close-modal" ).click(function() {
            $( ".modal-dialog" ).fadeOut("slow");
        });*/
    });
</script>
 <div class="products-container">
<?php
foreach ($modx->query($sql) as $row) {
  /*  if($sk==0)
    {
        ?>
        <div class="row">
        <?php
    }*/
    $sk++;

            $i=0;
            $sql_mainimg = "select * from s_prices pr
                                            join s_products p
                                            on p.id=pr.product_id

                                            join s_images i
                                            on i.price_id=pr.id


                                            where (p.id=" . $row['id'] . ")and(i.mainimg<>1)
                                            order by i.filename
                                            ;";
            //echo $sql_mainimg;
            foreach ($modx->query($sql_mainimg) as $rowIMain) {
                $images[$i]=$rowIMain['filename'];
                $i++;;
                // echo upload_dir . $rowIMain['filename'];
            }

    ?>
    <!-- Modal -->
    <div class="modal fade modalProduct" id="ProductModal_<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog  modal-lg">
            <div class="modal-content">
                <div class="modal-header">

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h3 class="modal-title modal-head-h3 " id="myModalLabel"><?php echo $row['title']; ?></h3>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <?php
                        $i=0;
                        $sql_mainimg = "select * from s_prices pr
                                            join s_products p
                                            on p.id=pr.product_id

                                            join s_images i
                                            on i.price_id=pr.id


                                            where (p.id=" . $row['id'] . ")and(i.mainimg<>1)
                                            order by i.filename
                                            ;";
                        //echo $sql_mainimg;
                        foreach ($modx->query($sql_mainimg) as $rowIMain) {
                            $images[$i]=$rowIMain['filename'];
                            $i++;;
                            // echo upload_dir . $rowIMain['filename'];
                        }

                        ?>

                        <div class="col-sm-8 col-xs-8"><img src="<?php echo upload_dir . $images[0];?>" class="img-responsive center-block modal-main-img "></div>
                        <div class="col-sm-4 col-xs-4">
                            <?php
                            $nn=1;
                            foreach ($images as $key=>$img) {
                                if($key!=0)
                                {
                                    ?>
                                    <img src="<?php  echo upload_dir . $img; ?>" class="img-responsive center-block modal-small-img<?php echo $nn;$nn++; ?> ">
                                <?php
                                }
                            }
                            ?>
                        </div>


                    </div>
                    <h4 class="modal-h4">Описание букета</h4>
                    <p class="modal-discription"><?php echo $row['description']; ?></p>
                    <h4 class="modal-h4">Состав букета</h4>
                    <p class="modal-discription">
                    <?php
                    $sql_pr="select id from s_prices where product_id=".$row['id']." limit 1 ";

                    $sql="select * from s_buket_flowers  b

join s_flowers f
on f.id=b.flower_id

where b.price_id=($sql_pr);";
                    $tmp='';
                    foreach($modx->query($sql) as $rowI)

                    {
                        $quantity=$rowI['f_count']+0;
                        if($quantity>0)
                        {
                            $tmp.=$rowI['title']." ".$rowI['f_count']." шт, ";
                        }
                        else
                        {
                            $tmp.=$rowI['title'].", ";
                        }

                    }
                    echo substr($tmp, 0, -2);;
                    ?></p>

                    <div class="w-clearfix modal-price">
                        <div class="modal-price-text">Цена: <span class="price-digit"> <?php
                                $sql_mainimg = "select * from s_prices pr
                                            join s_products p
                                            on p.id=pr.product_id
                                            where (p.id=" . $row['id'] . ")and(pr.active=1);";
                                foreach ($modx->query($sql_mainimg) as $rowIMain) {
                                    $priceRUB = $rowIMain['rub'];
                                }
                                echo $priceRUB;
                                ?></span></div>
                        <img class="rub modal-1"
                             src="https://daks2k3a4ib2z.cloudfront.net/55f3e76d11da8d083ed6dac1/55f9c8ee124ed81e107bba91_rub-003.png">
                    </div>

                    <div class="w-clearfix modal-button">
                        <img class="modal-button-img"
                          src="https://daks2k3a4ib2z.cloudfront.net/55f3e76d11da8d083ed6dac1/55f9cb98cf2ceee924b2e5b2_korzina-ico.png">

                        <div onclick="AddToCard(<?php echo $row['id']; ?>,1)">КУПИТЬ</div>
                    </div>


                </div>

            </div>
        </div>
    </div>



    <?php
    $sql_mainimg = "select * from s_prices pr
                                            join s_products p
                                            on p.id=pr.product_id

                                            join s_images i
                                            on i.price_id=pr.id


                                            where (p.id=" . $row['id'] . ")and(pr.active=1)and(i.mainimg=1);";
    foreach ($modx->query($sql_mainimg) as $rowIMain)
    {
        $MainImg= upload_dir . $rowIMain['filename'];
    }

    $sql_mainimg = "select * from s_prices pr
                                            join s_products p
                                            on p.id=pr.product_id
                                            where (p.id=" . $row['id'] . ")and(pr.active=1);";
    foreach ($modx->query($sql_mainimg) as $rowIMain)
    {
        $priceRUB = $rowIMain['rub'];
    }
    ?>
    <div class="w-clearfix product">
        <img    o1nclick="$('#ProductModal_<?php echo $row['id']; ?>').fadeIn('slow');"
                oncl3ick="$('#ProductModal_<?php echo $row['id']; ?>').modal('show')"
                data-toggle="modal" data-target="#ProductModal_<?php echo $row['id']; ?>"
                class="product-img-main" src="<?php echo $MainImg; ?>">

        <div class="product-title">
            <div><?php echo $row['title']; ?></div>
        </div>
        <div class="w-clearfix product-button">
            <div class="by-button-text click"   onclick="AddToCard(<?php echo $row['id']; ?>,1)">КУПИТЬ</div>
            <img src="https://daks2k3a4ib2z.cloudfront.net/55f3e76d11da8d083ed6dac1/55f9cb98cf2ceee924b2e5b2_korzina-ico.png">
        </div>
        <div class="w-clearfix product-price">
            <img class="rub" src="https://daks2k3a4ib2z.cloudfront.net/55f3e76d11da8d083ed6dac1/55f9c8ee124ed81e107bba91_rub-003.png">
            <div><?php echo $priceRUB; ?></div>
        </div>
    </div>


    <!-- -------------------------------------------- -->
    <!-- -------------------------------------------- -->
    <!-- -------------------------------------------- -->



    
    

<?php
  /*  if($sk==4)
    {
    $sk=0;
        ?>
        </div>
        <?php
    }*/
}

 ?>
</div>
