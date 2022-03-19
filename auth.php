<?php
session_start();
require_once "services/Users.php";
use App\Services\Users;
if (isset($_POST['login']) && isset($_POST['password'])) {
    if ((new Users())->authorization($_POST['login'], md5($_POST['password']))) {
        header('Location: ' .$_SERVER['REQUEST_URI']);
    } else {    //такого пользователя нет
        echo "<center><br><br>Введены неверные логин или пароль<br><br> <span><a href='index.php'>Попробуйте еще раз</a></span>
 <br> или обратитесь к администратору системы<br>";
    }
} else {
    echo "<center><br><br>Заполните логин и пароль<br><br> <span><a href='index.php'>Попробуйте еще раз</a></span>
<br> или обратитесь к администратору системы<br>";
}
