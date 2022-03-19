<?php
session_start();
?>
<?php 
unset($_SESSION['user']); /* пррисваиваем нулевое значение */
session_destroy();
header("Location: ../index.php"); /*  переотправляем на главную страницу проекта */
?>
<!-- файл прекращения сессии  -->
