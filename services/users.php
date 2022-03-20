<?php
require_once "Connection.php";
session_start();

class Users
{
    const PAGE = 'main.php';
    /**
     * @var Connection
     */
    private $connection;

    public function __construct()
    {
        $this->connection = new Connection();
    }

    public function getUsers(): array
    {
        if (isset($_REQUEST["search"])) {
            $search = $this->connection->real_escape_string($_REQUEST["search"]);
            if ($result = $this->connection->query(
                "SELECT id, login, is_admin FROM user where login LIKE '%" . $search . "%'",)) {
                while ($obj = $result->fetch_object()) {
                    $users[] = $obj;
                }
                unset($obj);
            }
        } elseif ($result = $this->connection->query("SELECT id, login, is_admin FROM user")) {
            while ($obj = $result->fetch_object()) {
                $users[] = $obj;
            }
            unset($obj);
        }
        $result->close();
        return $users ?? [];
    }

    public function addUser()
    {

    }

    public function updateUser($id)
    {

    }

    public function authorize(string $login, string $password): bool
    {
        if ($result = $this->connection->query(
            sprintf("SELECT id, is_admin FROM user WHERE login='%s' AND password='%s' limit 1",
                $login,
                $password)
        )) {
            while ($obj = $result->fetch_object()) {
                $_SESSION['user']['id'] = $obj->id;
                $_SESSION['user']['admin'] = (bool)$obj->is_admin;
                $res = true;
            }
            unset($obj);
            $result->close();
            return $res ?? false;
        }
        $result->close();
        return false;
    }

    public function logout()
    {
        unset($_SESSION['user']); /* пррисваиваем нулевое значение */
//        session_destroy();
    }

    public static function isAuthorized(): bool
    {
        if (!empty($_SESSION['user'])) {
            return true;
        }
        return false;
    }
}