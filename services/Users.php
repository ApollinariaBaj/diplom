<?php

namespace App\Services;

class Users
{
    /**
     * @var Connection
     */
    private $connection;

    public function __construct()
    {
        require_once "Connection.php";
        $this->connection = new Connection();
    }

    public function getUsers()
    {
//        $users = mysqli_query(CONNECTION, "select * from user");
//        while ($user = mysqli_fetch_row($users)) {
//            var_dump($user);
//        }
//
//        return $user;
    }

    public function addUser()
    {

    }

    public function updateUser($id)
    {

    }

    public function authorization(string $login, string $password): bool
    {
        if ($result = $this->connection->query(
            sprintf("SELECT id, is_admin FROM user WHERE login='%s' AND password='%s' limit 1",
                $login,
                $password)
        )) {
            while ($obj = $result->fetch_object()) {
                $_SESSION['user']['id'] = $obj->id;
                $_SESSION['user']['admin'] = (bool)$obj->is_admin;
            }
            unset($obj);
            $result->close();
            return true;
        }
        $result->close();
        return false;
    }
}