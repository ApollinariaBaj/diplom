<?php
require_once "../services/groups.php";
require_once "../services/AjaxRequest.php";


class GroupAjaxRequest extends AjaxRequest
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
        $name = $this->getRequestParam("name");
        if (empty($name)) {
            $this->setFieldError("name", "Введите название группы");
            return;
        }
        $type = $this->getRequestParam("type");
        if (empty($type)) {
            $this->setFieldError("type", "Выберите уровень образования");
            return;
        }
        $course = $this->getRequestParam("course");
        if (empty($course)) {
            $this->setFieldError("course", "Введите номер курса");
            return;
        }

        $groups = new Groups();
        $res = $groups->addGroup($name, $type, $course);
        if (!$res) {
            $this->setFieldError("common", "Что-то пошло не так, попробуйте позднее");
            return;
        }
        $searchString = $this->getRequestParam("search");
        $additionalRequest = (!empty($searchString)) ? "?search={$searchString}" : "";
        $this->status = "ok";
        $this->setResponse("redirect", "../" . $groups::PAGE . $additionalRequest);
        $this->message = sprintf("Группа %s добавлена.", $name);
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
        $groups = new Groups();
        if (!$groups->checkExist($id)) {
            $this->setFieldError("exist", "Такой группы не существует!");
            return;
        }
        $res = $groups->deleteGroup($id);
        if (!$res) {
            $this->setFieldError("common", "Что-то пошло не так, попробуйте позднее");
            return;
        }
        $searchString = $this->getRequestParam("search");
        $additionalRequest = (!empty($searchString)) ? "?search={$searchString}" : "";
        $this->status = "ok";
        $this->setResponse("redirect", "../" . $groups::PAGE . $additionalRequest);
        $this->message = "Группа удалена.";
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
        $name = $this->getRequestParam("name") ?: null;
        $type = $this->getRequestParam("type") ?: null;
        $course = $this->getRequestParam("course") ?: null;

        $groups = new Groups();
        if (!$groups->checkExist($id)) {
            $this->setFieldError("exist", "Такой группы не существует!");
            return;
        }
        $res = $groups->updateGroup($id, $name, $type, $course);
        if (!$res) {
            $this->setFieldError("common", "Что-то пошло не так, попробуйте позднее");
            return;
        }
        $searchString = $this->getRequestParam("search");
        $additionalRequest = (!empty($searchString)) ? "?search={$searchString}" : "";
        $this->status = "ok";
        $this->setResponse("redirect", "../" . $groups::PAGE . $additionalRequest);
        $this->message = sprintf("Группы %s обновлена.", $name);
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
        $groups = new Groups();
        $searchString = $this->getRequestParam("string");
        $additionalRequest = (!empty($searchString)) ? "?search={$searchString}" : "";
        $this->status = "ok";
        $this->setResponse("redirect", "../" . $groups::PAGE . $additionalRequest);
    }
}

$ajaxRequest = new GroupAjaxRequest($_REQUEST);
$ajaxRequest->showResponse();