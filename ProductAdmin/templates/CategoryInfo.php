
<h1>Категория: <?php echo $this->GetCategoryTitle($_GET['category_id']); ?></h1>

    <h2>Список товаров:</h2>
<?php
$this->ProductsShow();
?>