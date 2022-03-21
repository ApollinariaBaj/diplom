<?php
require_once 'services/users.php';
const ADMIN = [
    '/main.php' => 'Пользователи',
    '/students.php' => 'Студенты',
    '/groups.php' => 'Группы',
    '/subjects.php' => 'Предметы',
    '/exit.php' => 'Выход <svg class="bi bi-box-arrow-right" width="20" height="20" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0v2z"/>
  <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/>
</svg>',
];

const USER = [
    '/main.php' => 'Занятия',
    '/grades.php' => 'Оценка знаний',
    '/reports.php' => 'Отчетность',
    '/exit.php' => 'Выход',
];
?>

<nav class="navbar navbar-light mb-5" style="background-color: #e3f2fd;">
    <div class="container">
        <div class="container-fluid">
            <ul class="nav nav-pills nav-justified">
                <? foreach (Users::isAdmin() ? ADMIN : USER as $link => $title) { ?>
                    <li class="nav-item">
                        <a class="nav-link <?= $active == $link ? 'active' : ''; ?>"
                            <?= $active == $link ? 'aria-current="page"' : ''; ?>
                           href="<?= $link; ?>"><?= $title; ?></a>
                    </li>
                <? } ?>
            </ul>
        </div>
    </div>
</nav>


	