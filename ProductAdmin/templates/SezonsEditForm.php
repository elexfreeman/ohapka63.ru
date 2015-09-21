<?php
$sql = "select * from s_seazons where id=".mysql_escape_string($_POST['f_id']);

$query = $modx->query($sql);
while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
    ?>
<div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Редактировать</h4>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <label for="title">Название</label>
            <input type="text" class="form-control" id="title_update" placeholder="Название" value=<?php echo $row['title']; ?>>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Отменить</button>
        <button type="button" class="btn btn-primary btnUpdate" f_id="<?php echo $row['id']; ?>"
                onclick="SezonUpdate(<?php echo $row['id']; ?>);" >Сохранить</button>
    </div>
</div>
<?php
}
?>
