<?php
require_once "../services/students.php";
require_once "../services/AjaxRequest.php";


class StudentAjaxRequest extends AjaxRequest
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
        $surName = $this->getRequestParam("surName");
        if (empty($surName)) {
            $this->setFieldError("surName", "Введите фамилию");
            return;
        }
        $name = $this->getRequestParam("name");
        if (empty($name)) {
            $this->setFieldError("name", "Введите имя");
            return;
        }
        $fatherName = $this->getRequestParam("fatherName") ?: null;
        $group = $this->getRequestParam("group") ?: null;
        $student = new Students();
        $res = $student->addStudent($surName, $name, $fatherName, $group);

        if (!$res) {
            $this->setFieldError("common", "Что-то пошло не так, попробуйте позднее");
            return;
        }
        $searchString = $this->getRequestParam("search");
        $additionalRequest = (!empty($searchString)) ? "?search={$searchString}" : "";
        $this->status = "ok";
        $this->setResponse("redirect", "../" . $student::PAGE . $additionalRequest);
        $this->message = sprintf("Студент %s добавлен.", "{$surName} {$name} {$fatherName}");
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
        $students = new Students();
        if (!$students->checkExist($id)) {
            $this->setFieldError("exist", "Такого студента не существует!");
            return;
        }
        $res = $students->deleteStudent($id);
        if (!$res) {
            $this->setFieldError("common", "Что-то пошло не так, попробуйте позднее");
            return;
        }
        $searchString = $this->getRequestParam("search");
        $additionalRequest = (!empty($searchString)) ? "?search={$searchString}" : "";
        $this->status = "ok";
        $this->setResponse("redirect", "../" . $students::PAGE . $additionalRequest);
        $this->message = "Студент удалён.";
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
        $surName = $this->getRequestParam("surName") ?: null;
        $name = $this->getRequestParam("name") ?: null;
        $fatherName = $this->getRequestParam("fatherName") ?: null;
        $group = $this->getRequestParam("group") ?: null;
        $student = new Students();
        if (!$student->checkExist($id)) {
            $this->setFieldError("exist", "Такого студента не существует!");
            return;
        }
        $res = $student->updateStudent($id, $surName, $name, $fatherName, $group);
        if (!$res) {
            $this->setFieldError("common", "Что-то пошло не так, попробуйте позднее");
            return;
        }
        $searchString = $this->getRequestParam("search");
        $additionalRequest = (!empty($searchString)) ? "?search={$searchString}" : "";
        $this->status = "ok";
        $this->setResponse("redirect", "../" . $student::PAGE . $additionalRequest);
        $this->message = sprintf("Студент %s обновлен.", "{$surName} {$name} {$fatherName}");
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
        $students = new Students();
        $searchString = $this->getRequestParam("string");
        $additionalRequest = (!empty($searchString)) ? "?search={$searchString}" : "";
        $this->status = "ok";
        $this->setResponse("redirect", "../" . $students::PAGE . $additionalRequest);
    }
}

$ajaxRequest = new StudentAjaxRequest($_REQUEST);
$ajaxRequest->showResponse();