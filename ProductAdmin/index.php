<?php
include "core.php";
include "templates/head.php";
?>

<body>

<div id="wrapper">
    <div id="admin_panel">

<?php
$dd=new Eblazavrik;
$dd->getNavBar();
$dd->Run();
?>

    </div>
</div>

</body>
</html>