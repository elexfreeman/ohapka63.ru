<script>
    $(document).ready(function () {

    });

</script>

<?php
$sql = "select * from s_flowers where id=".mysql_escape_string($_GET['f_id']);
echo $sql;

foreach($modx->query($sql) as $rowI)
{
    ?>

<div class="container">
<form method="post" enctype="multipart/form-data">


    <input type="hidden" name='action' value="FlowersUpdate">
    <input type="hidden" name='flowers_id' value="<?php echo mysql_escape_string($_GET['f_id']);?>">

    <div class="form-group">
        <label for="title">Артикул</label>
        <input type="text" class="form-control" id="articul"
               name="articul" placeholder="12354" value="<?php echo $rowI['articul'];?>">
    </div>


    <div class="form-group">
        <label for="title">Название</label>
        <input type="text" class="form-control" id="title"
               name="title" placeholder="Название" value="<?php echo $rowI['title'];?>">
    </div>

    <div class="form-group">
        <label for="price">Цена</label>
        <input type="text" class="form-control" id="price"
               name="price" placeholder="45" value="<?php echo $rowI['price'];?>">
    </div>

    <div class="form-group">
        <label for="quantity1">Кол-во 1 точка</label>
        <input type="text" class="form-control" id="quantity1"
               name="quantity1" placeholder="45" value="<?php echo $rowI['quantity1'];?>">
    </div>

    <div class="form-group">
        <label for="quantity1">Кол-во 2 точка</label>
        <input type="text" class="form-control" id="quantity2"
               name="quantity2" placeholder="45" value="<?php echo $rowI['quantity2'];?>">
    </div>

    <div class="form-group">
        <label for="description_short">Краткое описание</label>
        <textarea class="form-control"  name="description_short" ><?php echo $rowI['description_short'];?></textarea>
    </div>

    <div class="form-group">
        <label for="description_full">Полное описание</label>
        <textarea class="form-control"  name="description_full" ><?php echo $rowI['description_full'];?></textarea>
    </div>


    <div class="form-group">
        <label for="title">Фото</label>
        <input type="file" class="form-control" id="MyImage" name="MyImage">
    </div>

    <img class="img-responsive" src="<?php echo upload_dir.$row['image'];?>">



    <button type="submit" class="btn btn-default">Сохранить</button>
</form>
</div>
<?php
}
?>
