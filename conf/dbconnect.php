<?php
$id_con = mysqli_connect("localhost", "polinarv_1", "Password1!")
or die("Невозможно соединиться с сервером");
mysqli_select_db($id_con,"polinarv_1") or die("Невозможно выбрать БД");
mysqli_query($id_con,"set names cp1251");
mysqli_query($id_con,"set character_set_server=cp1251");

define('CONNECTION', $id_con)
?>
