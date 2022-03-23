<?php
require_once "../services/subjects.php";
require_once "../services/AjaxRequest.php";


class SubjectAjaxRequest extends AjaxRequest
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
            $this->setFieldError("name", "Введите название предмета");
            return;
        }
        $teachers = $this->getRequestParam("teachers");

        $subjects = new Subjects;
        if ($name && $subjects->checkNameExist($name)) {
            $this->setFieldError("name", "Предмет с таким названием уже существует!");
            return;
        }
        $res = $subjects->addSubject($name);

        if (!$res) {
            $this->setFieldError("common", "Что-то пошло не так, попробуйте позднее");
            return;
        }

        if ($teachers) {
            $id = $subjects->getByName($name);
            $res = $subjects->updateSubjectTeacher($id, $teachers);

            if (!$res) {
                $this->setFieldError("common", "Что-то пошло не так, попробуйте позднее");
                return;
            }
        }

        $searchString = $this->getRequestParam("search");
        $additionalRequest = (!empty($searchString)) ? "?search={$searchString}" : "";
        $this->status = "ok";
        $this->setResponse("redirect", "../" . $subjects::PAGE . $additionalRequest);
        $this->message = sprintf("Предмет %s добавлен.", $name);
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
        $subjects = new Subjects;
        if (!$subjects->checkExist($id)) {
            $this->setFieldError("exist", "Такого предмета не существует!");
            return;
        }
        $res = $subjects->deleteSubject($id);
        if (!$res) {
            $this->setFieldError("common", "Что-то пошло не так, попробуйте позднее");
            return;
        }
        $searchString = $this->getRequestParam("search");
        $additionalRequest = (!empty($searchString)) ? "?search={$searchString}" : "";
        $this->status = "ok";
        $this->setResponse("redirect", "../" . $subjects::PAGE . $additionalRequest);
        $this->message = "Предмет удален.";
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
        $teachers = $this->getRequestParam("teachers") ?: null;

        $subjects = new Subjects;
        if (!$subjects->checkExist($id)) {
            $this->setFieldError("exist", "Такого предмета не существует!");
            return;
        }
        if ($name && $subjects->checkNameExist($name, $id)) {
            $this->setFieldError("name", "Предмет с таким названием уже существует!");
            return;
        }
        $res = $subjects->updateSubject($id, $name);
        if (!$res) {
            $this->setFieldError("common", "Что-то пошло не так, попробуйте позднее");
            return;
        }
        $res = $subjects->updateSubjectTeacher($id, $teachers);
        if (!$res) {
            $this->setFieldError("common", "Что-то пошло не так, попробуйте позднее");
            return;
        }
        $searchString = $this->getRequestParam("search");
        $additionalRequest = (!empty($searchString)) ? "?search={$searchString}" : "";
        $this->status = "ok";
        $this->setResponse("redirect", "../" . $subjects::PAGE . $additionalRequest);
        $this->message = sprintf("Предмет %s обновлён.", $name);
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
        $subjects = new Subjects;
        $searchString = $this->getRequestParam("string");
        $additionalRequest = (!empty($searchString)) ? "?search={$searchString}" : "";
        $this->status = "ok";
        $this->setResponse("redirect", "../" . $subjects::PAGE . $additionalRequest);
    }
}

$ajaxRequest = new SubjectAjaxRequest($_REQUEST);
$ajaxRequest->showResponse();