<?php session_start();
require_once 'services/users.php';
if (!Users::isAuthorized()) {
    header("Location: index.php");
} elseif (Users::isAdmin()) {
    require_once "users.php";
} else {
    require_once "lessons.php";
}
