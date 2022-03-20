<?php session_start();
if (!$_SESSION['user']) {
    header("Location: index.php");
}
if (!$_SESSION['user']['admin']) {
    header("Location: main.php");
}
require_once "services/users.php";

$users = (new Users())->getUsers();
?>
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Strict//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd'>

<html xmlns='http://www.w3.org/1999/xhtml'>

<head>
    <meta http-equiv='content-type' content='text/html; charset=windows-1251'/>

    <title>Пользователи</title>

    <link rel="stylesheet" type="text/css" href="/css/style.css">
    <link rel='stylesheet' type='text/css' href='/css/index.css'/>
    <link rel="stylesheet" href="./css/bootstrap.min.css">
</head>
<body>
<div class='container-fluid'>
    <div class="table-responsive text-nowrap">
        <!--Table-->
        <table class="table table-striped text-center">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Логин</th>
                <th scope="col">Администратор</th>
                <th colspan="2" scope="col">Действия</th>
            </tr>
            </thead>
            <tbody>
            <? foreach ($users as $key => $user) { ?>
                <tr>
                    <th scope="row"><?= $key; ?></th>
                    <td><?= $user->login ?></td>
                    <td><?= $user->is_admin ?></td>
                    <td>
                        <button class="btn btn-primary" type="submit">Редактировать</button>
                    </td>
                    <td>
                        <button class="btn btn-danger" type="submit">Удалить</button>
                    </td>
                </tr>
            <? } ?>
            </tbody>
        </table>
    </div>
</div>
<script src="./js/jquery-2.0.3.min.js"></script>
</body>
</html>