<h2>Заполнение букетов магазина</h2>
<?php
$this->ProductsShow();
?>

<?php

//родитель категории
$parent=modx_id_category;
if(isset($_GET['category_id'])) $parent=(mysql_escape_string($_GET['category_id']));

/*
?>


<div class="container-fluid">
    <h1>Категория: <?php echo $this->GetCategoryTitle($_GET['category_id']); ?></h1>
    <div class="row">
        <div class="col-md-6">
    <h2>
        Категории:
    </h2>
    <table class="table">
        <tr>
            <th>id</th>
            <th>Наименование</th>

            <th>
                <button type="button" parent="<?php echo $parent;?>" class="btn btn-primary btnAdd">Добавить (Shift+1)</button>
            </th>
        </tr>
        <?php



        $sql = "select * from s_category where parent=".$parent." order by title";
        //echo $sql;

        $query = $modx->query($sql);
            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            ?>
            <tr style="border-top: 5px solid #4B5296;">
                <td><?php echo $row['doc_id'];?></td>
                <td><a style="color: #6A4B74;font-weight: bold;font-size: 17px;" href="/ProductAdmin/?action=CategoryShow&category_id=<?php echo $row['doc_id'];?>"><?php echo $row['title'];?></a></td>
                <td>
                    <a href="/ProductAdmin/?action=CategoryEdit&category_id=<?php echo $row['doc_id'];?>">
                        <button f_id="<?php echo $row['doc_id'];?>" type="button" class="btn btn-success">Редактировать</button>
                    </a>
                    <button f_id="<?php echo $row['doc_id'];?>" type="button" class="btn btn-danger btnDeleteModal">Удалить</button>
                </td>
            </tr>
            <tr style="background-color: rgb(223, 223, 223);">
                <td></td>
                <td>Подкатегория</td>
                <td><button parent="<?php echo $row['doc_id'];?>" type="button" class="btn btn-info btnAdd">Добавить подкатегорию</button></td>
            </tr>
            <?php
                //Перечесляем потомков
                $sql_parent="select * from s_category where parent=".$row['doc_id'];
                $query_parent = $modx->query($sql_parent);
                while ($row_parent = $query_parent->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                    <tr style="background-color: rgb(223, 223, 223);">
                        <td><?php echo $row_parent['doc_id'];?></td>
                        <td><a href="/ProductAdmin/?action=CategoryShow&category_id=<?php echo $row_parent['doc_id'];?>"><?php echo $row_parent['title'];?></a></td>
                        <td>
                            <a href="/ProductAdmin/?action=CategoryEdit&category_id=<?php echo $row_parent['doc_id'];?>">
                                <button f_id="<?php echo $row_parent['doc_id'];?>" type="button" class="btn btn-warning">Редактировать подкатегорию</button>
                            </a>
                            <button f_id="<?php echo $row_parent['doc_id'];?>" type="button" class="btn btn-danger btnDeleteModal">Удалить</button>
                        </td>
                    </tr>
                    <?php

                }
        ?>

    </table>

</div>

<!-- Modal -->
<div class="modal fade" id="ModalDelete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Точно удалить???</h4>
            </div>
            <div class="modal-body">
                <button f_id="0" type="button" class="btn btn-danger btn_delete">Удалить</button>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Отменить</button>

            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade ModalAdd" id="ModalAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Добавить</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="title">Название</label>
                    <input type="text" class="form-control" id="title" placeholder="Название">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Отменить</button>
                <button parent="0" type="button" class="btn btn-primary btnsave">Сохранить</button>
            </div>
        </div>
    </div>
</div>



<!-- Modal -->
<div class="modal fade ModalEdit" id="ModalEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content edit_content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Редактировать</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="title">Название</label>
                    <input type="text" class="form-control" id="title" placeholder="Название">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Отменить</button>
                <button type="button" class="btn btn-primary btnsave">Сохранить</button>
            </div>
        </div>
    </div>
</div>

<div class="col-md-6">


    <h2>Список товаров:</h2>
    <div class="table-responsive"

    </div>
</div>

</div>
</div>
<script>


    $(document).ready(function () {
       //*---------------------------------------------------------
        //горячие клавиши
        $("body").keypress(function( event ) {
          //  console.info( event );
            xTriggered++;
          //  console.info("Handler for .keypress() called " + xTriggered + " time(s).");

           // console.info( event );

            ///Добавить категорию
            if( (event.keyCode==33)&(event.shiftKey==true) )
            {
                //console.info("Shift + 1");
                $(".btnsave").attr("parent",$(".btnAdd").attr("parent"));
                $('.ModalAdd').modal('show');

                setTimeout(function() {$("#title").focus(); }, 1000);
            }

            if( (event.keyCode==64)&(event.shiftKey==true) )
            {
               console.info("Shift + 2");
                window.location.replace('/ProductAdmin/index.php?action=ProductAddFormShow&category_id=<?php echo $_GET['category_id'];  ?>');

            }


        });

        //сохранить категорию
        $("#title").keypress(function( event ) {
            if( (event.keyCode==13))
            {
                console.info("addCategory");
                $(".btnsave").click();
            }
        });


        //*---------------------------------------------------------
        $(".btnAdd").click(function () {
            $(".btnsave").attr("parent",$(this).attr("parent"));
            $('.ModalAdd').modal('show');

        });
        //edit
        $(".btnEdit").click(function () {
            console.info("edit");
            var f_id=$(this).attr("f_id");
            $('#ModalEdit').modal('show');
            $.post(
                    "ajax.php",
                    {
                        //log1:1,
                        action:"CategoryGetEditForm"
                        ,f_id:f_id

                    },
                    function (data) {

                        $('.edit_content').html(data);
                        // console.info(data);

                    },"html"
            ); //$.post  END
        });

        //Удаление
        $(".btnDeleteModal").click(function () {
            $('#ModalDelete').modal('show');

            var f_id=$(this).attr("f_id");
            $(".btn_delete").attr("f_id",$(this).attr("f_id"));


        });

        $(".btn_delete").click(function () {
            var f_id=$(this).attr("f_id");
            $.post(
                    "ajax.php",
                    {
                        //log1:1,
                        action:"CategoryDelete"
                        ,f_id:f_id

                    },
                    function (data) {
                        $('#ModalDelete').modal('hide');
                        location.reload();
                        console.info(data);

                    },"html"
            ); //$.post  END
        });
        //-------------------------------------------------



        //Сохранение
        $(".btnsave").click(function () {

            var title=$("#title").val();
            var parent=$(".btnsave").attr("parent");
            console.info(title);

            $.post(
                    "ajax.php",
                    {
                        //log1:1,
                        action:"CategorySave"
                        ,title:title,
                        parent:parent

                    },
                    function (data) {
                        $('#ModalAdd').modal('hide');
                        var tt = JSON.parse(data);
                        window.location.replace('http://<?php echo $_SERVER['HTTP_HOST']."/ProductAdmin/index.php?action=CategoryEdit&category_id="; ?>'+tt.category_id);
                        //location.reload();
                        //console.info(data);

                    },"html"
            ); //$.post  END
        });
        //-------------------------------------------------


    });

</script>


            <?php
            */

?>