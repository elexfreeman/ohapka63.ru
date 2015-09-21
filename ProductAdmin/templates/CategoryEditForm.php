<script>
    $(document).ready(function () {

        //edit
        $(".btnUpdate").click(function () {
            console.info("update");
            var f_id=$(this).attr("f_id");
            var title=$("#title_update").val();
            $('#ModalEdit').modal('hide');
            $.post(
                    "ajax.php",
                    {
                        //log1:1,
                        action:"CategoryUpdate"
                        ,f_id:f_id
                        ,title:title

                    },
                    function (data) {

                        //   $('.edit_content').html(data);
                        console.info(data);
                        location.reload();

                    },"html"
            ); //$.post  END
        });
    });

</script>

<?php
$sql = "select * from s_category where doc_id=".mysql_escape_string($_GET['category_id']);

$query = $modx->query($sql);
while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
    ?>

<div class="container">
<form method="post" enctype="multipart/form-data">


    <input type="hidden" name='action' value="CategoryUpdate">
    <input type="hidden" name='category_id' value="<?php echo $row['doc_id'];?>">


    <div class="form-group">
        <label for="title">Название</label>
        <input type="text" class="form-control" id="title"
               name="title" placeholder="Название" value="<?php echo $row['title'];?>">
    </div>


    <script>
        $(document).ready(function(){
            var count1features=1000;
            $(".features1add").click(function(){
                var  AppStr='<tr id="TableRow_'+count1features+'">';


                AppStr=AppStr+'<td></td>';
                AppStr=AppStr+'<td><input value="" type="text" name="features_name_'+count1features+'"  class="form-control"></td>';
                AppStr=AppStr+'<td><button deleted="'+count1features+'"  type="button" class="btn btn-danger"';
                AppStr=AppStr+"onclick='";
                AppStr=AppStr+'$("#TableRow_"+$(this).attr("deleted")).remove();';
                AppStr=AppStr+"'"	 ;
                AppStr=AppStr+'>Удалить</button></td>';

                AppStr=AppStr+'</tr>';
                $('.features1grid').append(AppStr);
                count1features=count1features+1;

            });
        });
    </script>

    <div class="panel panel-success">
        <div class="panel-heading">Поля товаров</div>
        <div class="panel-body">
            <table class="table features1grid table-striped">
                <tr>
                    <th style="width: 10%;">id</th>
                    <th style="width: 70%;">Название</th>
                    <th>
                        <button type="button" class="btn btn-primary features1add">Добавить</button>
                    </th>
                </tr>
                <?php
                $sql2="SELECT * FROM s_categories_features cf
                join s_features f
                on f.id=cf.feature_id
                WHERE (category_id=".$row['doc_id'].")AND(cf.deleted=0)";
                //echo $sql2;
                $query = $modx->query($sql2);
                $ii=0;
                while ($rowfr = $query->fetch(PDO::FETCH_ASSOC))
                {
                    $ii++;
                    ?>

                    <tr id="TableRow_<?php echo $ii; ?>">
                        <td><?php echo $rowfr['id']; ?>
                            <input value="<?php echo $rowfr['id']; ?>" type="hidden"
                                   name="Ufeatures_id_<?php echo $ii; ?>"
                                   class="form-control">
                        </td>
                        </td>
                        <td>
                            <input value="<?php echo $rowfr['name']; ?>" type="text"
                                   name="ufeatures_name_<?php echo $ii; ?>"
                                   class="form-control">
                        </td>
                        <td>
                            <button deleted="<?php echo $ii; ?>" type="button" class="btn btn-danger"
                                    onclick="$('#TableRow_'+$(this).attr('deleted')).remove();">
                                Удалить
                            </button>
                        </td>
                    </tr>
                    <?php
                }
                ?>

            </table>
        </div>
    </div>



    <!-- ---------------------------------------------------------------------->
    <h4>Сопутствующие товары</h4>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label>
                    <input id="sp1" name="sp1" type="checkbox"> Сопутствующий товар 1
                </label>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label>
                    <input id="sp2" name="sp1" type="checkbox"> Сопутствующий товар 2
                </label>
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label>
                    <input id="sp3" name="sp3" type="checkbox"> Сопутствующий товар 3
                </label>
            </div>
        </div>

    </div>


    <button type="submit" class="btn btn-default">Сохранить</button>
</form>
<?php
}
?>
