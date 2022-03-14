<?php
$id_con = mysql_connect("localhost", "polinarv_1", "Password1!")
or die("Невозможно соединиться с сервером");
mysql_select_db("polinarv_1") or die("Невозможно выбрать БД");
mysql_query("set names cp1251");
mysql_query("set character_set_server=cp1251");
?>
