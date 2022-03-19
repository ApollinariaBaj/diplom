<?php session_start();
if (!$_SESSION['user']) {
    Header("Location: index.php");
}
if ($_SESSION['user']['admin']) {
    require_once "users.php";
}
