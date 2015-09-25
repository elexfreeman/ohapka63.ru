<div class="w-clearfix menu" tt="<?php print_r($_GET); ?>">
    <div class="menu-item <?php if((!isset($_GET['q']))and($_GET['q']=='')) echo " active " ?>">
        <a class="menu-item-text <?php if((!isset($_GET['q']))and($_GET['q']=='')) echo " active " ?>" href="/">Главная</a>
    </div>
    <div class="menu-item menu-oplata <?php if((isset($_GET['q']))and($_GET['q']=='oplata.html')) echo " active " ?>">
        <a class="menu-item-text <?php if((isset($_GET['q']))and($_GET['q']=='oplata.html')) echo " active " ?>" href="oplata.html">Оплата</a>
    </div>
    <div class="menu-item menu-dostavka<?php if((isset($_GET['q']))and($_GET['q']=='dostavka.html')) echo " active " ?>">
        <a class="menu-item-text<?php if((isset($_GET['q']))and($_GET['q']=='dostavka.html')) echo " active " ?>" href="dostavka.html">Доставка</a>
    </div>
    <div class="menu-item<?php if((isset($_GET['q']))and($_GET['q']=='contakts.html')) echo " active " ?>">
        <a class="menu-item-text<?php if((isset($_GET['q']))and($_GET['q']=='contakts.html')) echo " active " ?>" href="#">контакты</a>
    </div>
    <div class="menu-item menu-ort"><a class="menu-item-text" href="#">обратная связь</a></div>
</div>