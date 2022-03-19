<?php
session_start();
?>
<?php 
unset($_SESSION['user']); /* пррисваиваем нулевое значение */
session_destroy();
Header ("Location: ../index.php"); /*  переотправляем на главную страницу проекта */
?>
<!-- файл прекращения сессии  -->
