<?php
session_start();
?>
<?php 
$_SESSION['sotr']=0; /* пррисваиваем нулевое значение */
session_destroy();
Header ("Location: ../index.php"); /*  переотправляем на главную страницу проекта */
?>
<!-- файл прекращения сессии  -->
