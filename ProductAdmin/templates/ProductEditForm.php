






<style>
    .flowers
    {
        display: none;
    }
</style>

    <?php
    $sql = "SELECT
*
FROM s_products p

where p.id=".mysql_escape_string($_GET['product_id'])."

";
//echo $sql;
    $query = $modx->query($sql);
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            ?>
        <script>
            $(document).ready(function(){
                UploadFile("ClubEditphoto");
                //заполняем нужные сезоны на форме
                GetProductSezonList(<?php echo $row['id'];?>);
                //так же стили
                GetProductStylesList(<?php echo $row['id'];?>);
                GetProductGammasList(<?php echo $row['id'];?>);
                GetProductSizesList(<?php echo $row['id'];?>);

            });
        </script>


        <form method="post" enctype="multipart/form-data">
        <input type="hidden" name='uniq' value="<?php echo PassGen();?>">
        <input type="hidden" name='action' value="ProductUpdate">
        <input type="hidden" name='category_id' value="<?php echo $row['category'];?>">
        <input type="hidden" name='product_id' value="<?php echo $row['id'];?>">

        <div class="admin_product">
            <div class="left">

                <div class="admin_product_images">

                    <div class="MyImages" pricen='0' style="display: none;">


                        <!-- The container for the uploaded files -->

                        <div id="files" class="files">
                            <?php
                            //Выводим картинки привязанные к ценам
                            $sql_img="select
                            p.id product_id, price.id price_id,
                             i.filename,
                             i.mainimg
                            from s_products p
                                join s_prices price
                                    on price.product_id=p.id
                                join s_images i
                                    on i.price_id=price.id where
                                    p.id=".mysql_escape_string($_GET['product_id'])." group by i.id  order by price.id;";

                            //echo $sql_img."<br>";
                            //$query = $modx->query($sql_img);
                            $ii=1;
                            foreach($modx->query($sql_img) as $rowI)
                            {
                                ?>
                                <div>
                                    <div  class="img_dop MyImg MyImg_<?php echo $rowI['price_id']; ?>">
                                    <div>

                                        <img  width="100" height="100" src="<?php echo upload_dir.$rowI['filename']; ?>">
                                            <br><br>
                                        <div class="product_delete" onclick="MyImgDelete(<?php echo $ii; ?>)"></div>


                                        <!-- *-------------------- -->
                                        <div <?php
                                            if($rowI['mainimg']=='1')
                                            {
                                                echo " style='background-position: 0 -22px' ";
                                            }
                                            ?>  class="product_choose_main mainimg_row_<?php echo $rowI['price_id']; ?>"
                                             id="c_main_<?php echo $rowI['price_id']."_".$ii; ?>"
                                             onclick="SetMainImg(<?php echo $rowI['price_id'].",".$ii; ?>)"></div>

                                        <input type="hidden" name="mainimg_<?php echo $rowI['price_id']; ?>_<?php echo $ii; ?>"
                                               class="mainimg_<?php echo $rowI['price_id']; ?>_<?php echo $ii; ?>
                                                 mainimg_row_<?php echo $rowI['price_id']; ?>"
                                               value="<?php echo  $rowI['mainimg']; ?>">
                                        <!-- *-------------------- -->


                                        <input type="hidden"
                                               name="img_<?php echo $rowI['price_id']; ?>_<?php echo $ii; ?>"
                                               class="img_<?php echo $ii; ?>"
                                               value="<?php echo $rowI['filename']; ?>"><?php echo $rowI['filename']; ?>



                                    </div>
                                    </div>
                                </div>
                                <?php
                                $ii++;
                            }

                            ?>

                        </div>

                        <input type="hidden" class="form-control" name="ClubEditphoto" id="ClubEditphoto" placeholder="">
            <span class="btn btn-success fileinput-button">
				<i class="glyphicon glyphicon-plus"></i>
				<span>Add files...</span>
				<!-- The file input field used as target for the file upload widget -->
				<input id="fileuploadClubEditphoto" type="file" name="files[]">
			</span>
                        <br>
                        <br>
                        <!-- The global progress bar -->
                        <div id="progress" class="progress">
                            <div class="progress-bar progress-bar-success"></div>
                        </div>
                    </div>

                    <!--
                    <div class="img_dop">
                            <div class="product_choose_main">
                            </div>
                            <div class="product_delete">
                            </div>
                            <img src="/site/tpl/img/product_img.jpg">
                        </div>

                        <div class="img_dop">
                            <div class="product_choose_main">
                            </div>
                            <div class="product_delete">
                            </div>
                            <img src="/site/tpl/img/product_img.jpg">
                        </div>

                        <div class="img_dop">
                            <div class="product_choose_main">
                            </div>
                            <div class="product_delete">
                            </div>
                            <img src="/site/tpl/img/product_img.jpg">
                        </div>

                        <div class="img_dop">
                            <div class="product_choose_main">
                            </div>
                            <div class="product_delete">
                            </div>
                            <img src="/site/tpl/img/product_img.jpg">
                        </div>
                        <div class="img_dop">
                            <div class="product_choose_main">
                            </div>
                            <div class="product_delete">
                            </div>
                            <img src="/site/tpl/img/product_img.jpg">
                        </div>
                        <div class="img_dop">
                            <div class="product_choose_main">
                            </div>
                            <div class="product_delete">
                            </div>
                            <img src="/site/tpl/img/product_img.jpg">
                        </div>
                    <div class="img_add">
                        <img src="/site/tpl/img/add_prod.png">
                    </div>

                    -->
                </div>
                <div class="admin_product_sostav" style="display: none;">
                    <p class="spec_zag">Состав данного варианта букета</p>


                    <div class="flower1grid">
  <?php
            //Выводим картинки привязанные к ценам
            $sql_img="
select
  b.f_count,
        f.id flower_id,
        f.title flower_title,
        f.articul articul,
        price.id price_id,
        b.f_count

  from s_buket_flowers b

  join s_prices price
  on price.id=b.price_id

  join s_flowers f
  on f.id=b.flower_id

  join s_products p
  on p.id=price.product_id


where p.id=".mysql_escape_string($_GET['product_id'])." order by price.id
;";

            //echo $sql_img."<br>";
            //$query = $modx->query($sql_img);
            $ii=1;
            foreach($modx->query($sql_img) as $rowI)
            {
                ?>
                <div class="sostav_row sostav_<?php echo $rowI['price_id']; ?>" id="TableRow_<?php echo $ii; ?>">
                    <select class="spec_form" name="FFlower_<?php echo $rowI['price_id']; ?>_<?php echo $ii; ?>">
                        <?php
                        $sqlflower="select * from s_flowers order by title";

                        foreach($modx->query($sqlflower) as $rowflower)
                        {
                            ?>
                           <option <?php
                                    if($rowI['flower_id']==$rowflower['id'])
                                    {
                                        echo ' selected ';
                                    }
                                    ?> value="<?php echo $rowflower['id']; ?>"><?php echo $rowflower['articul']." ". $rowflower['title']; ?></option>
                            <?php
                        }
                        ?>
                    </select>
                    <input class="spec_form" type="text" placeholder="52"
                           name="flower_<?php echo $rowI['price_id']; ?>_count_<?php echo $ii; ?>" value="<?php echo $rowI['f_count']; ?>">
                    <img deleted="<?php echo $ii; ?>" class="close " src="/site/tpl/img/cross_red.png"
                         onclick="$('#TableRow_'+$(this).attr('deleted')).remove();">
                </div>
                <?php
                $ii++;
            }
                                ?>
                    </div>
                    <div class="sostav_add flower1add"><img src="/site/tpl/img/add_prod.png"></div>

                </div>

                <script>
                    $(document).ready(function(){
                        var count1T=<?php echo $ii+1; ?>;

                        $(".flower1add").click(function(){
                            var pricen=$("#MyImages").val();
                            var AppStr="";
                            AppStr=AppStr+'<div class="sostav_row sostav_'+pricen+'" id="TableRow_'+count1T+'">';
                            AppStr=AppStr+'<select class="spec_form"  name="FFlower_'+pricen+"_"+count1T+'">';

                            <?php
                            $sql_img="select * from s_flowers order by title";
                            foreach($modx->query($sql_img) as $row_f)
                            {
                                ?>
                                AppStr=AppStr+'<option value="<?php echo $row_f['id']; ?>"><?php echo $row_f['articul']." ". $row_f['title']; ?></option>';
                                <?php
                            }
                            ?>
                            AppStr=AppStr+'</select>';
                            AppStr=AppStr+'<input class="spec_form" type="text" placeholder="52" name="flower_'+pricen+'_count_'+count1T+'">';
                            AppStr=AppStr+'<img deleted="' + count1T + '" class="close " src="/site/tpl/img/cross_red.png" ';
                            AppStr=AppStr+"onclick='";
                            AppStr=AppStr+'$("#TableRow_"+$(this).attr("deleted")).remove();';
                            AppStr=AppStr+"'"	 ;
                            AppStr=AppStr+'>';
                            AppStr=AppStr+'</div>';

                            $('.flower1grid').append(AppStr);
                            count1T=count1T+1;

                        });
                    });
                </script>


                <div class="admin_product_descr_short">
                    <p class="spec_zag">Описание краткое</p>
                    <div>
                        <textarea class="spec_form"
                                  id="description"
                                  name="description"><?php echo $row['description'];?></textarea>
                    </div>
                </div>
                <div class="admin_product_descr_all">
                    <p class="spec_zag">Описание полное</p>
                    <div>
                        <textarea class="spec_form"
                                  id="description2"
                                  name="description2"><?php echo $row['description2'];?></textarea>
                    </div>
                </div>
            </div>
            <div class="right">
                <div>
                    <input id="title" name="title"
                           placeholder="Кусочек счастья"
                           class="spec_form prod_name"
                           value="<?php echo $row['title'];?>"
                           type="text">
                </div>
                <div class="prod_cat">
                    <input placeholder="Артикул" class="spec_form"
                           type="text"
                           value="<?php echo $row['articul'];?>"
                           id="art1" name="art1">
                    <!--
                    <select class="spec_form">
                        <option><?php echo $this->GetCategoryTitle($_GET['category_id']); ?></option>
                        <option>Категория 2</option>
                        <option>Категория 3</option>
                    </select>
                    -->
                </div>
                <div class="prod_sklad">
                    <span>Количество<br>на складе</span>
                    <input placeholder="52" class="spec_form" type="text" name="p_count" value="0">
                    <label><input type="checkbox" name="flag" <?php if($row['flag']==1) echo " checked "; ?>> Всегда в наличии</label>
                </div>

                <div class='sezon' style="margin-top:20px;">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox"> Check me out
                        </label>
                    </div>
                </div>
<!--
                <div class='b_styles'>
                    <label>Стили</label>

                </div>


                <div class='b_gammas'>
                    <label>Стили</label>

                </div>

                <div class='b_sizes'>
                    <label>Размеры</label>

                </div>
-->
                <div class="admin_prices">
                    <p>Цена</p>

                        <?php
                        //Выводим картинки привязанные к ценам
                        $sql_img="select
                                    p.id product_id,
                                    price.id price_id,
                                    price.caption price_caption,
                                    price.rub rub,
                                    price.active

                                    from s_products p
                                join s_prices price
                                    on price.product_id=p.id
                                 where
                                    p.id=".mysql_escape_string($_GET['product_id'])." order by price.id ;";

                        //echo $sql_img."<br>";
                        //$query = $modx->query($sql_img);
                        $ii=1;
                        $kk=0;
                        foreach($modx->query($sql_img) as $rowI)
                        {
                            $kk=$rowI['price_id'];
                            ?>
                        <div id="TableRowPrice_<?php echo  $rowI['price_id']; ?>">

                        <input onclick="Images(<?php echo $rowI['price_id']; ?>)" type="radio" class="Price"
                        name="admin_prices_variant">

                        <input type="hidden" name="MainImg_<?php echo $rowI['price_id']; ?>"
                               value="0" class="MainImg_<?php echo $rowI['price_id']; ?>">

                        <span class="count">
                        <input type="text" value="<?php echo $rowI['price_caption']; ?>"
                               class="spec_form" name="Aadmin_prices_caption_<?php echo $rowI['price_id']; ?>"
                        placeholder="Название">
                        </span>

                        <input class="spec_form" type="text"
                        placeholder="800 руб"
                        name="admin_prices_price_<?php echo $rowI['price_id']; ?>"
                        value="<?php echo $rowI['rub']; ?>">

                        <input type="radio" name="admin_price_main_active" <?php
                            if($rowI['active']=='1')
                            {
                                echo " checked ";
                            }
                            ?> value="<?php echo $rowI['price_id']; ?>">

                        <img deleted="<?php echo $rowI['price_id']; ?>"
                        class="close"
                        src="/site/tpl/img/cross.png"
                        onclick="$('#TableRowPrice_'+$(this).attr('deleted')).remove();$('.MyImages').hide();">

                        </div>

                            <?php

                            $ii++;
                        }
                    $kk++;

                    $sql_max="select max(price.id) m
                    from s_products p
                    join s_prices price on price.product_id=p.id
                    where p.id=".mysql_escape_string($_GET['product_id'])." order by price.id ";
                    //echo $sql_max;
                    $MyImages=0;
                    foreach($modx->query($sql_max) as $rowMaix)
                    {
                        $MyImages=$MyImages+$rowMaix['m']+1;
                    }


                ?>


                    <input type="hidden" name='MyImages' value="<?php echo $MyImages; ?>" id="MyImages">
<script>
    $(document).ready(function () {
        //setTimeout(function() {$("#title").focus(); }, 1000);


        var countPriceT = <?php echo $MyImages; ?>;
        $(".priceadd").click(function () {
            var AppStr = "";
            AppStr = AppStr + '<div id="TableRowPrice_' + countPriceT + '">';
            AppStr = AppStr + '<input onclick="Images('+countPriceT+')" type="radio" class="Price" name="admin_prices_variant">';
            AppStr = AppStr + '<input type="hidden" name="MainImg_' + countPriceT + '" value="0" class="MainImg_' + countPriceT + '">';
            AppStr = AppStr + '<span class="count"><input type="text"  class="spec_form" name="Aadmin_prices_caption_' + countPriceT + '" placeholder="Название"></span>';
            AppStr = AppStr + '<input class="spec_form" type="text" placeholder="800 руб" name="admin_prices_price_' + countPriceT + '">';
            AppStr = AppStr + '<input type="radio" name="admin_price_main_active" value="' + countPriceT + '">';
            AppStr = AppStr + '<img deleted="' + countPriceT + '" class="close" src="/site/tpl/img/cross_red.png" ';

            AppStr = AppStr + "onclick='";
            AppStr = AppStr + '$("#TableRowPrice_"+$(this).attr("deleted")).remove();$(".MyImages").hide();';
            AppStr = AppStr + "'";
            AppStr = AppStr + ' >';

            AppStr = AppStr + '</div>';
            $('.admin_prices').append(AppStr);
            countPriceT = countPriceT + 1;

        });

    });
</script>


                </div>
                <div class="admin_prices_add priceadd">
                    Добавить еще вариант букета
                </div>
                <div class="admin_prices_delete"  onclick="ProductDelete(<?php echo $row['id'];?>);">
                    Удалить букет со всеми вариантами
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-default">Сохранить</button>
        </form>






<?php
        }?>



<!-- Modal -->
<div class="modal fade" id="ModalDeleteProduct" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Точно удалить???</h4>
            </div>
            <div class="modal-body">
                <button f_id="0" type="button"
                        class="btn btn-danger ProductDeleteCommit"
                        onclick="ProductDeleteCommitEdit($('.ProductDeleteCommit').attr('f_id'));">Удалить</button>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Отменить</button>

            </div>
        </div>
    </div>
</div>

