<?php session_start();
if (!$_SESSION['user']) {
    header("Location: index.php");
}
if ($_SESSION['user']['admin']) {
    require_once "users.php";
}

if (!$_SESSION['user']['admin']) {
    require_once "lessons.php";
}
