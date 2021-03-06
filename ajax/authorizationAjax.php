<?php
require_once "../services/users.php";
require_once "../services/AjaxRequest.php";

if (!empty($_COOKIE['sid'])) {
    // check session id in cookies
    session_id($_COOKIE['sid']);
}
session_start();

class AuthorizationAjaxRequest extends AjaxRequest
{
    public $actions = array(
        "login" => "login",
        "logout" => "logout",
    );

    public function login()
    {
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            // Method Not Allowed
            http_response_code(405);
            header("Allow: POST");
            $this->setFieldError("main", "Method Not Allowed");
            return;
        }
        session_start();
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
            $this->setFieldError("notFound", "Неправильный логин или пароль");
            return;
        }
        $this->status = "ok";
        $this->setResponse("redirect", "../main.php");
    }

    public function logout()
    {
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            // Method Not Allowed
            http_response_code(405);
            header("Allow: POST");
            $this->setFieldError("main", "Method Not Allowed");
            return;
        }
        Users::logout();
        $this->status = "ok";
        $this->setResponse("redirect", "../index.php");
    }
}

$ajaxRequest = new AuthorizationAjaxRequest($_REQUEST);
$ajaxRequest->showResponse();