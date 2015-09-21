<script>
    $(document).ready(function(){
        UploadFile("ClubEditphoto");
    });
</script>

        <form method="post" enctype="multipart/form-data">
    <input type="hidden" name='uniq' value="<?php echo PassGen();?>">
    <input type="hidden" name='action' value="ProductSave">
    <input type="hidden" name='category_id' value="<?php echo $_GET['category_id'];?>">
    <input type="hidden" name='MyImages' value="0" id="MyImages">
    <input type="hidden" name="MainImg" value="0">
    <input type="hidden" name="MainRow" value="0">
    <div class="admin_product">
    <div class="left">

        <div class="admin_product_images">

        <div class="MyImages" pricen='0' style="display: none;">


            <!-- The container for the uploaded files -->
            <div id="files" class="files"></div>

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
            <script>
                $(document).ready(function(){
                    var count1T=1;

                    $(".flower1add").click(function(){
                        var pricen=$("#MyImages").val();
                        var AppStr="";
                        AppStr=AppStr+'<div class="sostav_row sostav_'+pricen+'" id="TableRow_'+count1T+'">';
                        AppStr=AppStr+'<select class="spec_form"  name="FFlower_'+pricen+"_"+count1T+'">';

                    <?php
                    $sql="select * from s_flowers order by title";
                    $query = $modx->query($sql);
                    while ($row = $query->fetch(PDO::FETCH_ASSOC))
                    {
                        ?>
                        AppStr=AppStr+'<option value="<?php echo $row['id']; ?>"><?php echo $row['articul']." ". $row['title']; ?></option>';
                        <?php
                    }
                    ?>
                        AppStr=AppStr+'</select>';
                        AppStr=AppStr+'<input class="spec_form" type="text" placeholder="52" name="flower_'+pricen+'_count_'+count1T+'">';
                        AppStr=AppStr+'<img deleted="' + count1T + '" class="close " src="/site/tpl/img/cross.png" ';
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

            <div class="flower1grid">

            </div>
            <div class="sostav_add flower1add"><img src="/site/tpl/img/add_prod.png"></div>

        </div>
        <div class="admin_product_descr_short">
            <p class="spec_zag">Описание краткое</p>
            <div>
                <textarea class="spec_form"id="description" name="description"></textarea>
            </div>
        </div>
        <div class="admin_product_descr_all">
            <p class="spec_zag">Описание полное</p>
            <div>
                <textarea class="spec_form" id="description2" name="description2"></textarea>
            </div>
        </div>
    </div>
    <div class="right">
        <div>
            <input id="title" name="title"  placeholder="Кусочек счастья" class="spec_form prod_name" type="text">
        </div>

        <div class="prod_cat">
            <input placeholder="Артикул" class="spec_form" type="text"  id="art1" name="art1">
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
            <input placeholder="52" class="spec_form" type="text" name="p_count" value="0" disabled>
            <label><input type="checkbox" name="flag"> Всегда в наличии</label>
        </div>
<!--
        <div class='sezon'>
            <label>Сезоны</label>
            <div class="checkbox">
                <label>
                    <input type="checkbox"> Check me out
                </label>
            </div>
        </div>

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
        <script>
            $(document).ready(function () {
                //setTimeout(function() {$("#title").focus(); }, 1000);

                GetProductSezonList(1);
                GetProductStylesList(1);
                GetProductGammasList(1);
                GetProductSizesList(1);

                var countPriceT = 1;
                $(".priceadd").click(function () {

                    var MainRow=$("input[name=MainRow]").val();
                    var chk="";
                    if(MainRow=='0')
                    {
                        chk=" checked ";
                        $("input[name=MainRow]").val(1);
                    }

                    var AppStr = "";
                    AppStr = AppStr + '<div id="TableRowPrice_' + countPriceT + '">';
                    AppStr = AppStr + '<input onclick="Images('+countPriceT+')" type="radio" class="Price" name="admin_prices_variant">';
                    AppStr = AppStr + '<input type="hidden" name="MainImg_' + countPriceT + '" value="0" class="MainImg_' + countPriceT + '">';
                    AppStr = AppStr + '<span class="count"><input type="text"  class="spec_form" name="Aadmin_prices_caption_' + countPriceT + '" placeholder="Название"></span>';
                    AppStr = AppStr + '<input class="spec_form" type="text" placeholder="800 руб" name="admin_prices_price_' + countPriceT + '">';
                    AppStr = AppStr + '<img deleted="' + countPriceT + '" class="close" src="/site/tpl/img/cross.png" ';


                    AppStr = AppStr + "onclick='";
                    AppStr = AppStr + '$("#TableRowPrice_"+$(this).attr("deleted")).remove();$(".MyImages").hide();';
                    AppStr = AppStr + "'";
                    AppStr = AppStr + ' >';
                    AppStr = AppStr + '<input type="radio" name="admin_price_main_active" '+chk+' value="' + countPriceT + '"> ';
                    AppStr = AppStr + '</div>';
                    $('.admin_prices').append(AppStr);
                    countPriceT = countPriceT + 1;

                });

            });
        </script>

        <div class="admin_prices">
            <p>Цена</p>

            
        </div>
        <div class="admin_prices_add priceadd">
            Добавить еще вариант букета
        </div>
        <div class="admin_prices_delete">
            Удалить букет со всеми вариантами
        </div>
    </div>
</div>

    <button type="submit" class="btn btn-default">Сохранить</button>
</form>


<style>
    .flowers {
        display: none;
    }
</style>
