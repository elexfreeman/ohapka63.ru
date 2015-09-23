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


foreach ($modx->query($sql) as $row) {
  /*  if($sk==0)
    {
        ?>
        <div class="row">
        <?php
    }*/
    $sk++;
    ?>
    <!-- Modal -->
<div class="modal fade modalProduct" id="ProductModal_<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog  modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        
      </div>
      <div class="modal-body">
        <h3 class="modal-title" id="myModalLabel"><?php echo $row['title']; ?></h3>
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
        <h4 class="modal-description">Описание букета</h4>
        <p><?php echo $row['description']; ?></p>
        <h4 class="modal-sostav">Состав букета</h4>
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
        ?>
          <div class="modal-price">Цена: <?php
              $sql_mainimg = "select * from s_prices pr
                                            join s_products p
                                            on p.id=pr.product_id
                                            where (p.id=" . $row['id'] . ")and(pr.active=1);";
              foreach ($modx->query($sql_mainimg) as $rowIMain) {
                  $priceRUB = $rowIMain['rub'];
              }
              echo $priceRUB;
?><img class="img-rub" src='/img/rub-004.png'></div>
        <div class="row footer-product"  >
        <button  type="button" class="btn  btn-success  btn-lg "   onclick="AddToCard(<?php echo $row['id']; ?>,1)">
                                <img src="img/korzina-ico.png "> КУПИТЬ</button>
        </div>
        
      </div>
      
    </div>
  </div>
</div>
    
        <div class="col-md-4 col-lg-3 col-sm-4 col-xs-6 product">
        
            <div class="panel panel-default buket ">
                <!--<a href="/<?php echo $modx->makeUrl(intval($row['doc_id']));?>"> -->
                <?php
                            $sql_mainimg = "select * from s_prices pr
                                            join s_products p
                                            on p.id=pr.product_id

                                            join s_images i
                                            on i.price_id=pr.id


                                            where (p.id=" . $row['id'] . ")and(pr.active=1)and(i.mainimg=1);";
                            foreach ($modx->query($sql_mainimg) as $rowIMain) {
                                $MainImg= upload_dir . $rowIMain['filename'];
                            }


                            ?>
                <div class="panel-body click product-img"
                     onclick="$('#ProductModal_<?php echo $row['id']; ?>').modal('show')" style="
                background: url('<?php echo $MainImg; ?>');
">
                <!--
                    <span class="click"  onclick="$('#ProductModal_<?php echo $row['id']; ?>').modal('show')">
                        <img src="<?php echo $MainImg; ?>" class="img-responsive center-block ">
                    </span>
                    -->
                </div>

                <div class="panel-footer ">
                <div class="footer-title">
                <?php echo $row['title']; ?>
                </div>
                
                <?php 
                         $sql_mainimg = "select * from s_prices pr
                                            join s_products p
                                            on p.id=pr.product_id
                                            where (p.id=" . $row['id'] . ")and(pr.active=1);";
        foreach ($modx->query($sql_mainimg) as $rowIMain) {
            $priceRUB = $rowIMain['rub'];
        }
                     ?>

                    <div class="row ">
                        <div class="col-xs-5   price "><?php echo $priceRUB; ?> <img class="img-rub"  src='/img/rub-003.png'></div>
                        <div class="col-xs-7  by  ">
                            <button type="button" class="btn btn-block btn-success"   onclick="AddToCard(<?php echo $row['id']; ?>,1)">
                                <img src="img/korzina-ico.png ">КУПИТЬ</button>
                        </div>
                        
                       
                    </div>
                </div>
            </div>
        </div>
    
    


<script>
    $(document).ready(function(){
     /*   $.get(
                "/components/com_jshopping/templates/default/list_products/cursconv_ajax.php",
                {
                    //log1:1,
                    v:"EUR"

                },
                function (data) {
                    $("#CURS_EUR").html(data);
                    setTimeout(function() {
                        $('.prod_cat_price').each(function (i, elem) {
                            var tt='<span>';

                            var gg=Math.round(parseFloat(  Math.round( parseFloat($(elem).attr('price')) * parseFloat($("#CURS_EUR").html()) ) /100  ) )*100;
                            tt=tt+String(Math.round(gg));
                            tt=tt+' <span class="currencycode">руб</span></span>';
                            $(elem).html(tt);
                        });
                    }, 100);
                },"html"
        ); */
    });

</script>

<?php
  /*  if($sk==4)
    {
    $sk=0;
        ?>
        </div>
        <?php
    }*/
}