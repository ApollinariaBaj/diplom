<?php
session_start();
require "../conf/dbconnect.php";
if (isset($_POST['parol'])) {
    $res = mysqli_query(CONNECTION, "SELECT id, is_admin FROM user WHERE login='{$_POST['login']}' AND password='{$_POST['password']}'");
    if (mysqli_num_rows($res)) {
        while ($prise_mas = mysqli_fetch_row($res)) {
            $_SESSION['user']['id'] = "$prise_mas[0]";
            $_SESSION['user']['admin'] = (bool)$prise_mas[1];
            Header("Location: main.php");
        }
    } else {    //такого пользователя нет
        echo "<center><br><br>Введены неверные логин или пароль<br><br> <span><a href='index.php'>Попробуйте еще раз</a></span> <br> или обратитесь к администратору системы<br>
";
    }
}
?>
