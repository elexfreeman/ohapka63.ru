<script>
    $(document).ready(function () {
    //горячие клавиши
    $("html").keypress(function( event ) {
        console.info( event );


        if( (event.keyCode==37)&(event.shiftKey==true) )
        {
            console.info("Shift +5");
            window.location.replace('/ProductAdmin/index.php');

        }


    });
    });
</script>

<div class="admin_Navs" style="padding-left: 133px; box-sizing: border-box; margin-top: 20px;">
    <div class="admin_Navs_zag activeNav">
        <a href="/ProductAdmin/?action=CategoryShow">ПРОДУКТЫ</a>
    </div>
    <div class="admin_Navs_symbol">
        /
    </div>
    <div class="admin_Navs_zag">
        <a href="/ProductAdmin/?action=FlowersShow">ЦВЕТЫ</a>
    </div>
    <div class="admin_Navs_symbol">
        /
    </div>
    <div class="admin_Navs_zag">
        <a href="/ProductAdmin/?action=OrdersShow">ЗАКАЗЫ</a>
    </div>
    <div class="admin_Navs_symbol">
        /
    </div>
    <div class="admin_Navs_zag">
        <a href="/ProductAdmin/?action=ShowUsers">КЛИЕНТЫ</a>

    </div>
</div>


    <nav class="navbar navbar-default">
        <div class="container-fluid">

            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">Админка</a>
            </div>


            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">


            <ul class="nav navbar-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle"
                       data-toggle="dropdown" role="button"
                       aria-expanded="false">Категории <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="/ProductAdmin/?action=CategoryShow">Верхний уровень (shift+5) </a></li>
                        <?php
                        $sql = "select * from s_category where parent=".modx_id_category;
                        //echo $sql;

                        $query = $modx->query($sql);
                        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                            ?>
                            <li><a href="/ProductAdmin/?action=CategoryShow&category_id=<?php echo $row['doc_id']; ?>"><?php echo $row['title']; ?></a></li>
                            <?php
                        }
                            ?>

                    </ul>
                </li>

                <li><a href="?action=OrdersShow">Заказы</a></li>
                <li><a href="?action=ClientsShow">Клиенты</a></li>
                <li class="divider"></li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle"
                       data-toggle="dropdown" role="button"
                       aria-expanded="false">Справочники <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="/ProductAdmin/?action=SezonsShow">Сезоны</a></li>
                        <li><a href="/ProductAdmin/?action=StylesShow">Стили</a></li>
                        <li><a href="/ProductAdmin/?action=GammasShow">Гаммы</a></li>
                        <li><a href="/ProductAdmin/?action=SizesShow">Размеры</a></li>
                        <li><a href="/ProductAdmin/?action=TypesShow">Типы продуктов</a></li>
                    </ul>
                </li>
            </ul>
</div>
</div>
</nav>
