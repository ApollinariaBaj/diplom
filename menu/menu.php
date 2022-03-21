<?php
require_once 'services/users.php';
const ADMIN = [
    '/main.php' => 'Пользователи',
    '/students.php' => 'Студенты',
    '/groups.php' => 'Группы',
    '/subjects.php' => 'Предметы',
    '/exit.php' => 'Выход',
];

const USER = [
    '/main.php' => 'Занятия',
    '/grades.php' => 'Оценка знаний',
    '/reports.php' => 'Отчетность',
    '/exit.php' => 'Выход',
];
$active = "/main.php"
?>

<nav class="navbar navbar-light" style="background-color: #e3f2fd;">
    <div class="container-fluid">
        <ul class="nav nav-pills nav-justified">
            <? foreach (Users::isAdmin() ? ADMIN : USER as $link => $title) { ?>
                <li class="nav-item">
                    <a class="nav-link <?= $active == $link ? 'active' : ''; ?>"
                        <?= $active == $link ? 'aria-current="page"' : ''; ?> href="<?=$link;?>"><?=$title;?></a>
                </li>
            <? } ?>
        </ul>
    </div>
</nav>


	