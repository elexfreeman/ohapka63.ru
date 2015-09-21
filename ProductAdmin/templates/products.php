<?php
if(!isset($_GET['category_id']))
{
    $doc_id=modx_id_category;
}
else
{
    $doc_id =mysql_escape_string($_GET['category_id']);
}
?>

<div class="admin_products">
    <div class="top">
        <a href="/ProductAdmin/?action=ProductAddFormShow&category_id=<?php echo $doc_id;  ?>">
            <span class="add_prod">+</span>
        </a>
        <!--
        <span>По алфавиту</span>
        <select class="spec_input">
            <?php
            $sql='select * from s_types';
             foreach($modx->query($sql) as $rowTypes)
                        {
                            ?>
                            <option value="<?php echo $rowTypes['id']; ?>"><?php echo $rowTypes["title"]; ?></option>
                            <?php
                        }

            ?>

        </select>
        -->
    </div>
    <table class="mid">
   <?php


    $sql = "SELECT
    p.id,
p.title,
p.articul,
-- p.p_count,
p.doc_id,
p.img


FROM s_products p


where p.category=".$doc_id."
order by p.articul
";
//echo $sql;
    $query = $modx->query($sql);
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            ?>
        <tr id="product_row_<?php echo $row['id'];?>">
            <td>
                <img src="<?php
                    $sql_mainimg="select * from s_prices pr
                                            join s_products p
                                            on p.id=pr.product_id

                                            join s_images i
                                            on i.price_id=pr.id


                                            where (p.id=".$row['id'].")and(pr.active=1)and(i.mainimg=1);";
                                            
                    foreach($modx->query($sql_mainimg) as $rowIMain)
                    {
                        echo upload_dir.$rowIMain['filename'];
                    }


                    ?>">
            </td>

            <td>
                <a target="_blank" href="/<?php echo $modx->makeUrl(intval($row['doc_id']));?>">
                    <?php echo $row['title'];  ?>
                </a>
            </td>
            <td> <?php echo $row['articul'];  ?></td>
            <td><?php 
                         $sql_mainimg = "select * from s_prices pr
                                            join s_products p
                                            on p.id=pr.product_id
                                            where (p.id=" . $row['id'] . ")and(pr.active=1);";
        foreach ($modx->query($sql_mainimg) as $rowIMain) {
            $priceRUB = $rowIMain['rub'];
        }
                        echo $priceRUB;  ?> руб.</td>
            <td><!-- <input style="width:70px;" type="number" value="" id="price_<?php echo $row['id'];?>"> --></td>
            <td>
                <div class="edit_but">
                    <a href="/ProductAdmin/?action=ProductEditFormShow&product_id=<?php echo $row['id'];?>">
                        <img src="/site/tpl/img/edit_icon.png"></a>
                    <!-- <a href=""><img src="/site/tpl/img/active_icon.png"></a> -->
                </div>
                <span  onclick="ProductDelete(<?php echo $row['id'];?>);"><img src="/site/tpl/img/cross.png"></span>
            </td>
        </tr>
        <tr id="product_row_add_<?php echo $row['id'];?>">
            <td colspan="2"></td>
            <td colspan="3">
                <?php
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
                                    p.id=".$row['id']." order by price.id ;";

            //echo $sql_img."<br>";
            //$query = $modx->query($sql_img);
            $ii=1;
            $kk=0;
            foreach($modx->query($sql_img) as $rowI)
            {
                ?>
                <input type="radio" <?php
                    if($rowI['active']=='1') echo " checked ";
                ?> name="price_variant_<?php echo $row['id'];?>" onclick="ChangeBuketList(<?php echo $rowI['id'];  ?>)" value="<?php echo $rowI['id'];  ?>"> <?php echo $rowI['price_caption'];  ?>
                <?php
            }
?>

            </td>
        </tr>

<?php
        }
?>




    </table>

</div>

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
                        onclick="ProductDeleteCommit($('.ProductDeleteCommit').attr('f_id'));">Удалить</button>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Отменить</button>

            </div>
        </div>
    </div>
</div>

    <script>

        $(document).ready(function(){
/*
            $(".flag_main").click(function(){
                $.post(
                        "ajax.php",
                        {
                            //log1:1,
                            action:"SetMainFlag",
                            product_id:$("input[type='radio']:checked").val(),
                            category_id:<?php echo $row['id'];?>
                        },
                        function (data) {
                             console.info(data);

                        },"html"
                ); //$.post  END
            });

*/
            //Удаление
            $(".btnDeleteModalp").click(function () {
                $('.ModalDeletep').modal('show');

                var f_id=$(this).attr("f_id");
                $(".btn_deletep").attr("f_id",$(this).attr("f_id"));


            });

            $(".btn_deletep").click(function () {
                var f_id=$(this).attr("f_id");
                $.post(
                        "ajax.php",
                        {
                            //log1:1,
                            action:"ProductsDelete"
                            ,product_id:f_id

                        },
                        function (data) {
                            $('.ModalDeletep').modal('hide');
                           // location.reload();
                            console.info(data);

                        },"html"
                ); //$.post  END
            });
            //-------------------------------------------------




        });
    </script>
