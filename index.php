<?require_once 'services/users.php';
//todo не видит сессии на этой странице
var_dump(Users::isAuthorized());

if (Users::isAuthorized()) {
    header("Location: main.php");
}
?><!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Strict//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd'>

<html xmlns='http://www.w3.org/1999/xhtml'>

<head>
    <meta http-equiv='content-type' content='text/html; charset=windows-1251'/>

    <title>Необходима авторизация</title>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel='stylesheet' type='text/css' href='/css/index.css'/>
</head>
<body>
<div class='container text-center'>
    <form class="form-signin ajax" method="post" action="./authorizationAjax.php">
        <div class="main-error alert alert-error hide"></div>

        <h2 class="form-signin-heading">Авторизация</h2>
        <input name="login" type="text" class="input-block-level" placeholder="Логин" autofocus>
        <input name="password" type="password" class="input-block-level" placeholder="Пароль">
        <input type="hidden" name="act" value="login">
        <button class="btn btn-large btn-primary" type="submit">Войти</button>
    </form>
</div>
<script src="./js/jquery-2.0.3.min.js"></script>
<script src="./js/ajax-form.js"></script>
</body>

</html>
