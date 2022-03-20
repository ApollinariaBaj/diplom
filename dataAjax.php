<?php
require_once "services/users.php";
require_once "services/AjaxRequest.php";

if (!empty($_COOKIE['sid'])) {
    // check session id in cookies
    session_id($_COOKIE['sid']);
}
session_start();

class DataAjaxRequest extends AjaxRequest
{
    public $actions = [
        "add" => "add",
        "delete" => "delete",
        "update" => "update",
        "search" => "search",
    ];

    public $type = [
        "user" => Users::class,
        "student" => "student",
        "subject" => "subject",
        "group" => "group",
    ];

    public function add()
    {
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            // Method Not Allowed
            http_response_code(405);
            header("Allow: POST");
            $this->setFieldError("main", "Method Not Allowed");
            return;
        }
        setcookie("sid", "");
        $username = $this->getRequestParam("login");
        $password = $this->getRequestParam("password");

        if (empty($username)) {
            $this->setFieldError("login", "Введите логин");
            return;
        }

        if (empty($password)) {
            $this->setFieldError("password", "Введите пароль");
            return;
        }
        $user = new Users();
        $auth_result = $user->authorize($username, md5($password));
        if (!$auth_result) {
            $this->setFieldError("password", "Неправильный логин или пароль");
            return;
        }
        $this->status = "ok";
        $this->setResponse("redirect", "./main.php");
        $this->message = sprintf("Здравстуйте, %s! Добро пожаловать в систему.", $username);
    }

    public function delete()
    {
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            // Method Not Allowed
            http_response_code(405);
            header("Allow: POST");
            $this->setFieldError("main", "Method Not Allowed");
            return;
        }
        setcookie("sid", "");
        $user = new Users();
        $user->logout();

        $this->setResponse("redirect", ".");
        $this->status = "ok";
    }

    public function update()
    {
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            // Method Not Allowed
            http_response_code(405);
            header("Allow: POST");
            $this->setFieldError("main", "Method Not Allowed");
            return;
        }
        setcookie("sid", "");
        $username = $this->getRequestParam("login");
        $password = $this->getRequestParam("password");

        if (empty($username)) {
            $this->setFieldError("login", "Введите логин");
            return;
        }

        if (empty($password)) {
            $this->setFieldError("password", "Введите пароль");
            return;
        }
        $user = new Users();
        $auth_result = $user->authorize($username, md5($password));
        if (!$auth_result) {
            $this->setFieldError("password", "Неправильный логин или пароль");
            return;
        }
        $this->status = "ok";
        $this->setResponse("redirect", "./main.php");
        $this->message = sprintf("Здравстуйте, %s! Добро пожаловать в систему.", $username);
    }

    public function search()
    {
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            // Method Not Allowed
            http_response_code(405);
            header("Allow: POST");
            $this->setFieldError("main", "Method Not Allowed");
            return;
        }
        if (isset($this->type[$this->getRequestParam("type")])) {
            $class = new $this->type[$this->getRequestParam("type")];
        } else {
            $this->setFieldError("type", "Некорректный запрос");
            return;
        }

        $searchString = $this->getRequestParam("string");
        if (empty($searchString)) {
            $this->setFieldError("string", "Пустая строка поиска");
            return;
        }
        $searchString = addslashes($searchString);
        $this->status = "ok";
        $this->setResponse("redirect", "./" . $class::PAGE . "?search={$searchString}");
    }
}

$ajaxRequest = new DataAjaxRequest($_REQUEST);
$ajaxRequest->showResponse();