<?php
require_once "../services/users.php";
require_once "../services/AjaxRequest.php";

if (!empty($_COOKIE['sid'])) {
    // check session id in cookies
    session_id($_COOKIE['sid']);
}
session_start();

class UserAjaxRequest extends AjaxRequest
{
    public $actions = [
        "add" => "add",
        "delete" => "delete",
        "update" => "update",
        "search" => "search",
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
        $username = $this->getRequestParam("login");
        if (empty($username)) {
            $this->setFieldError("login", "Введите логин");
            return;
        }
        $password = $this->getRequestParam("password");
        if (empty($password)) {
            $this->setFieldError("password", "Введите пароль");
            return;
        }
        $isAdmin = (bool)$this->getRequestParam("admin");

        $user = new Users();
        if ($user->checkLoginExist($username)) {
            $this->setFieldError("exist", "Пользователь с таким логином уже существует!");
            return;
        }
        $res = $user->addUser($username, md5($password), $isAdmin);
        if (!$res) {
            $this->setFieldError("common", "Что-то пошло не так, попробуйте позднее");
            return;
        }
        $searchString = $this->getRequestParam("search");
        $additionalRequest = (!empty($searchString)) ? "?search={$searchString}" : "";
        $this->status = "ok";
        $this->setResponse("redirect", "../" . $user::PAGE . $additionalRequest);
        $this->message = sprintf("Пользователь %s добавлен.", $username);
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
        $id = $this->getRequestParam("id");
        $user = new Users();
        if (!$user->checkExist($id)) {
            $this->setFieldError("exist", "Такого пользователя не существует!");
            return;
        }
        $res = $user->deleteUser($id);
        if (!$res) {
            $this->setFieldError("common", "Что-то пошло не так, попробуйте позднее");
            return;
        }
        $searchString = $this->getRequestParam("search");
        $additionalRequest = (!empty($searchString)) ? "?search={$searchString}" : "";
        $this->status = "ok";
        $this->setResponse("redirect", "../" . $user::PAGE . $additionalRequest);
        $this->message = "Пользователь удалён.";
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
        $id = $this->getRequestParam("id");
        $username = $this->getRequestParam("login") ?? null;
        $password = $this->getRequestParam("password") ?? null;
        $isAdmin = (bool)$this->getRequestParam("admin");
        $user = new Users();
        if (!$user->checkExist($id)) {
            $this->setFieldError("exist", "Такого пользователя не существует!");
            return;
        }
        if ($username && $user->checkLoginExist($username, $id)) {
            $this->setFieldError("exist", "Пользователь с таким логином уже существует!");
            return;
        }
        $res = $user->updateUser($id, $username, md5($password), $isAdmin);
        if (!$res) {
            $this->setFieldError("common", "Что-то пошло не так, попробуйте позднее");
            return;
        }
        $searchString = $this->getRequestParam("search");
        $additionalRequest = (!empty($searchString)) ? "?search={$searchString}" : "";
        $this->status = "ok";
        $this->setResponse("redirect", "../" . $user::PAGE . $additionalRequest);
        $this->message = sprintf("Пользователь %s обновлен.", $username);
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
        $user = new Users();
        $searchString = $this->getRequestParam("string");
        $additionalRequest = (!empty($searchString)) ? "?search={$searchString}" : "";
        $this->status = "ok";
        $this->setResponse("redirect", "../" . $user::PAGE . $additionalRequest);
    }
}

$ajaxRequest = new UserAjaxRequest($_REQUEST);
$ajaxRequest->showResponse();