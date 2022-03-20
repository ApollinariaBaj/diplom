<?php session_start();
if (!$_SESSION['user']) {
    header("Location: index.php");
}
if (!$_SESSION['user']['admin']) {
    header("Location: main.php");
}
require_once "services/users.php";
$searchString = $_REQUEST["search"] ?? null;
$users = (new Users())->getUsers();
?>
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Strict//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd'>

<html xmlns='http://www.w3.org/1999/xhtml'>

<head>
    <meta http-equiv='content-type' content='text/html; charset=windows-1251'/>
    <link rel="shortcut icon" href="https://e.muiv.ru/theme/image.php/_s/vitte/theme/1632305883/favicon"/>
    <title>Пользователи</title>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel='stylesheet' type='text/css' href='/css/index.css'/>
</head>
<body>
<div class='container-fluid'>
    <div id="main-error" class="text-center"></div>
    <div class="container mb-2 mt-2">
        <div class="btn-toolbar justify-content-between" role="toolbar">
            <div class="btn-group mr-2" role="group">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
                    Добавить пользователя
                </button>
            </div>
            <div class="input-group">
                <form class="form-data search ajax" method="post" action="./dataAjax.php">
                    <input class="visually-hidden" type="hidden" name="act" value="search">
                    <input class="visually-hidden" type="hidden" name="type" value="user">
                    <input type="search" name="string" class="form-control rounded"
                           placeholder="Поиск" <?= 'value="' . $searchString . '"' ?? ''; ?>
                           aria-label="Поиск"
                           aria-describedby="search-addon"/>
                    <button type="submit" class="btn btn-primary" id="search-addon">Поиск</button>
                </form>
            </div>
        </div>
    </div>
    <!--Table-->
    <div class="pre-scrollable">
        <table class="table table-hover table-bordered custom-table"
               cellspacing="0">
            <thead>
            <tr>
                <th scope="col" class="th-sm text-center">#</th>
                <th scope="col" class="th-sm text-center">Логин</th>
                <th scope="col" class="th-sm text-center">Администратор</th>
                <th colspan="2" scope="col" class="th-sm text-center">Действия</th>
            </tr>
            </thead>
            <tbody>
            <? foreach ($users as $key => $user) { ?>
                <tr>
                    <th scope="row" class="text-center"><?= $key + 1; ?></th>
                    <td class="text-center"><?= $user->login ?></td>
                    <td class="text-center"><?= $user->is_admin ?
                            '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2" viewBox="0 0 16 16">
  <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z"/>
</svg>'
                            : '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M13.854 2.146a.5.5 0 0 1 0 .708l-11 11a.5.5 0 0 1-.708-.708l11-11a.5.5 0 0 1 .708 0Z"/>
  <path fill-rule="evenodd" d="M2.146 2.146a.5.5 0 0 0 0 .708l11 11a.5.5 0 0 0 .708-.708l-11-11a.5.5 0 0 0-.708 0Z"/>
</svg>' ?></td>
                    <td class="text-center">
                        <button class="btn btn-primary btn-sm" type="submit">Редактировать</button>
                    </td>
                    <td class="text-center">
                        <button class="btn btn-danger btn-sm" type="submit">Удалить</button>
                    </td>
                </tr>
            <? } ?>
            </tbody>
        </table>
    </div>
</div>
<div class="modal" id="addModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Добавление пользователя</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="form-data modal-form ajax" method="post" action="./dataAjax.php">
                <div class="main-error text-center"></div>
                <div class="modal-body text-center">
                    <input class="visually-hidden" type="hidden" name="act" value="add">
                    <input class="visually-hidden" type="hidden" name="type" value="user">
                    <div class="mb-2">
                        <p>Логин: </p>
                        <input name="login" type="text" class="input-block-level" placeholder="Логин" autofocus>
                    </div>
                    <div class="mb-2">
                        <p>Пароль: </p>
                        <input name="password" type="password" class="input-block-level" placeholder="Пароль">
                    </div>
                    <div class="mb-2">
                        <label class="form-check-label" for="isAdmin">Администратор: </label>
                        <input class="form-check-input" type="checkbox" name="admin" value="admin" id="isAdmin"/>
                    </div>
                </div>
                <div class="modal-footer text-right">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                    <button type="submit" class="btn btn-primary">Сохранить</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>
<script src="./js/jquery-2.0.3.min.js"></script>
<script src="./js/ajax-data.js"></script>
</body>
</html>