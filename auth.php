<?php
session_start();
require "../conf/dbconnect.php";
if (isset($_POST['parol'])) {
    $res = mysqli_query(CONNECTION, "SELECT id FROM user WHERE login='{$_POST['login']}' AND password='{$_POST['password']}'");
    if (mysql_num_rows($res)) {
        while ($prise_mas = mysql_fetch_row($res)) {
            $_SESSION['var'] = "$prise_mas[0]";
            Header("Location: man.php");
        }
    } else {    //такого пользователя нет
        echo "<center><br><br>Введены неверные логин или пароль<br><br> <span><a href='index.php'>Попробуйте еще раз</a></span> <br> или обратитесь к администратору системы<br>
";
    }
}
?>
