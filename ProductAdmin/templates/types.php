<h1>
    Типы продуктов
</h1>

<div class="container">
    <table class="table">
        <tr>
            <th>id</th>
            <th>Наименование</th>

            <th>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ModalAdd">Добавить
                </button>
            </th>
        </tr>
        <?php
        $sql = "select * from s_types";

        $query = $modx->query($sql);
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            ?>
            <tr>
                <td><?php echo $row['id'];?></td>
                <td><?php echo $row['title'];?></td>
                <td>
                    <button f_id="<?php echo $row['id'];?>" type="button" class="btn btn-success btnEdit">Редактировать</button>

                    <button f_id="<?php echo $row['id'];?>" type="button" class="btn btn-danger btnDeleteModal">Удалить</button>
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
<div class="modal fade" id="ModalAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
                <button type="button" class="btn btn-primary btnsave">Сохранить</button>
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

<script>
    $(document).ready(function () {

        //edit
        $(".btnEdit").click(function () {
            console.info("edit");
            var f_id=$(this).attr("f_id");
            $('#ModalEdit').modal('show');
            $.post(
                    "/ProductAdmin/ajax.php",
                    {
                        //log1:1,
                        action:"TypesGetEditForm"
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
                    "/ProductAdmin/ajax.php",
                    {
                        //log1:1,
                        action:"TypesDelete"
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
            console.info(title);

            $.post(
                    "/ProductAdmin/ajax.php",
                    {
                        //log1:1,
                        action:"TypesSave"
                        ,title:title

                    },
                    function (data) {
                        $('#ModalAdd').modal('hide');
                        location.reload();
                        //console.info(data);

                    },"html"
            ); //$.post  END
        });
        //-------------------------------------------------


    });

</script>
