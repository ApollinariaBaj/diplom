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
                <form class="form-data search ajax" method="post" action="./userAjax.php">
                    <input class="visually-hidden" type="hidden" name="act" value="search">
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
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#updateModal"
                                data-id="<?= $user->id; ?>"
                                data-name="<?= $user->login; ?>"
                                data-isadmin="<?= $user->is_admin; ?>"
                        >
                            Редактировать
                        </button>
                    </td>
                    <td class="text-center">
                        <button class="btn btn-danger btn-sm" type="submit" data-bs-toggle="modal"
                                data-bs-target="#deleteModal"
                                data-id="<?= $user->id; ?>"
                                data-name="<?= $user->login; ?>"
                        >
                            Удалить
                        </button>
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
            <form class="form-data modal-form ajax" method="post" action="./userAjax.php">
                <div class="main-error text-center"></div>
                <div class="modal-body text-center">
                    <input class="visually-hidden" type="hidden" name="act" value="add">
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
<div class="modal" id="updateModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Редактирование пользователя</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="form-data modal-form ajax" method="post" action="./userAjax.php">
                <div class="main-error text-center"></div>
                <div class="modal-body">
                    <input class="visually-hidden" type="hidden" name="act" value="update">
                    <input class="visually-hidden" type="hidden" name="id">
                    <div class="container">
                        <div class="row">
                            <div class="col mb-2 text-end">
                                <p>Логин: </p>
                            </div>
                            <div class="col mb-2 text-start">
                                <input name="login" type="text" class="input-block-level" placeholder="Логин" autofocus>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-2 text-end">
                                <p>Новый пароль: </p>
                            </div>
                            <div class="col mb-2 text-start">
                                <input name="password" type="password" class="input-block-level" placeholder="Пароль">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-2 text-center">
                                <label class="form-check-label" for="isAdmin2">Администратор: </label>
                                <input class="form-check-input" type="checkbox" name="admin" value="admin"
                                       id="isAdmin2"/>
                            </div>
                        </div>
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
<div class="modal" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Удаление пользователя</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="form-data modal-form ajax" method="post" action="./userAjax.php">
                <div class="main-error text-center"></div>
                <div class="modal-body">
                    <input class="visually-hidden" type="hidden" name="act" value="delete">
                    <input class="visually-hidden" type="hidden" name="id">
                    <div class="alert alert-warning d-flex align-items-center" role="alert">
                        <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                            <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                            </symbol>
                        </svg>
                        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Warning:">
                            <use xlink:href="#exclamation-triangle-fill"/>
                        </svg>
                        <div>
                            Вы уверены, что хотите удалить пользователя?
                        </div>
                    </div>
                </div>
                <div class="modal-footer text-right">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                    <button type="submit" class="btn btn-danger">Удалить</button>
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
<script src="./js/modal.js"></script>
</body>
</html>