<?php session_start();
require_once 'services/users.php';
require_once 'services/groups.php';
if (!Users::isAuthorized()) {
    header("Location: main.php");
} elseif (!Users::isAdmin()) {
    header("Location: main.php");
}
$active = "/groups.php";
$searchString = $_REQUEST["search"] ?? null;
$groups = (new Groups())->getGroups();
?>
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Strict//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd'>

<html xmlns='http://www.w3.org/1999/xhtml'>

<head>
    <meta http-equiv='content-type' content='text/html; charset=utf-8'/>
    <link rel="shortcut icon" href="https://e.muiv.ru/theme/image.php/_s/vitte/theme/1632305883/favicon"/>
    <title>Студенты</title>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel='stylesheet' type='text/css' href='/css/index.css'/>
</head>
<body>
<? require_once "./menu/menu.php"; ?>

<div class='container-fluid'>
    <div id="main-error" class="text-center"></div>
    <div class="container mb-2 mt-2">
        <div class="btn-toolbar justify-content-between" role="toolbar">
            <div class="btn-group mr-2" role="group">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
                    Добавить группу
                </button>
            </div>
            <div class="input-group">
                <form class="form-data search ajax" method="post" action="./ajax/groupAjax.php">
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
                <th scope="col" class="th-sm text-center">Название</th>
                <th scope="col" class="th-sm text-center">Уровень образования</th>
                <th scope="col" class="th-sm text-center">Курс</th>
                <th colspan="2" scope="col" class="th-sm text-center">Действия</th>
            </tr>
            </thead>
            <tbody>
            <? foreach ($groups as $key => $group) { ?>
                <tr>
                    <th scope="row" class="text-center"><?= $key + 1; ?></th>
                    <td class="text-center"><?= $group->name; ?></td>
                    <td class="text-center"><?= $group->type; ?></td>
                    <td class="text-center"><?= $group->course; ?></td>
                    <td class="text-center">
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#updateGroupModal"
                                data-id="<?= $group->id; ?>"
                                data-name="<?= $group->name; ?>"
                                data-type="<?= $group->type; ?>"
                                data-course="<?= $group->course; ?>"
                        >
                            Редактировать
                        </button>
                    </td>
                    <td class="text-center">
                        <button class="btn btn-danger btn-sm" type="submit" data-bs-toggle="modal"
                                data-bs-target="#deleteModal"
                                data-id="<?= $group->id; ?>"
                                data-name="Удаление группы <?= $group->name; ?>"
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
                <h5 class="modal-title">Добавление группы</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="form-data modal-form ajax" method="post" action="./ajax/groupAjax.php">
                <div class="main-error text-center"></div>
                <div class="modal-body text-center">
                    <input class="visually-hidden" type="hidden" name="act" value="add">
                    <input class="visually-hidden" type="hidden"
                           name="search" <?= 'value="' . $searchString . '"' ?? ''; ?>>

                    <div class="container">
                        <div class="row">
                            <div class="col mb-2 text-end">
                                <p>Название: </p>
                            </div>
                            <div class="col mb-2 text-start">
                                <input name="name" type="text" class="input-block-level" placeholder="Название"
                                       autofocus>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-2 text-end">
                                <label class="form-select-label" for="group">Уровень образования: </label>
                            </div>
                            <div class="col mb-2 text-start">
                                <select class="form-select form-select-sm " aria-label="type" name="type">
                                    <option value="" selected>Выберите уровень</option>
                                    <option value="Среднее специальное">Среднее специальное</option>
                                    <option value="Бакалавриат">Бакалавриат</option>
                                    <option value="Магистратура">Магистратура</option>
                                    <option value="Аспирантура">Аспирантура</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-2 text-end">
                                <p>Курс: </p>
                            </div>
                            <div class="col mb-2 text-start">
                                <input name="course" type="number" class="input-block-level" id="replyNumber" min="1"
                                       max="6" step="1" data-bind="value:replyNumber" placeholder="Курс">
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
<div class="modal" id="updateGroupModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Редактирование группы</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="form-data modal-form ajax" method="post" action="./ajax/groupAjax.php">
                <div class="main-error text-center"></div>
                <div class="modal-body">
                    <input class="visually-hidden" type="hidden" name="act" value="update">
                    <input class="visually-hidden" type="hidden"
                           name="search" <?= 'value="' . $searchString . '"' ?? ''; ?>>
                    <input class="visually-hidden" type="hidden" name="id">
                    <div class="container">
                        <div class="row">
                            <div class="col mb-2 text-end">
                                <p>Название: </p>
                            </div>
                            <div class="col mb-2 text-start">
                                <input name="name" type="text" class="input-block-level" placeholder="Название"
                                       autofocus>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-2 text-end">
                                <label class="form-select-label" for="group">Уровень образования: </label>
                            </div>
                            <div class="col mb-2 text-start">
                                <select class="form-select form-select-sm " aria-label="type" name="type">
                                    <option value="" selected>Выберите уровень</option>
                                    <option value="Среднее специальное">Среднее специальное</option>
                                    <option value="Бакалавриат">Бакалавриат</option>
                                    <option value="Магистратура">Магистратура</option>
                                    <option value="Аспирантура">Аспирантура</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-2 text-end">
                                <p>Курс: </p>
                            </div>
                            <div class="col mb-2 text-start">
                                <input name="course" type="number" class="input-block-level" id="replyNumber" min="1"
                                       max="6" step="1" data-bind="value:replyNumber" placeholder="Курс">
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
                <h5 class="modal-title">Удаление группы</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="form-data modal-form ajax" method="post" action="./ajax/groupAjax.php">
                <div class="main-error text-center"></div>
                <div class="modal-body">
                    <input class="visually-hidden" type="hidden" name="act" value="delete">
                    <input class="visually-hidden" type="hidden"
                           name="search" <?= 'value="' . $searchString . '"' ?? ''; ?>>
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
                            Вы уверены, что хотите удалить группу?
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