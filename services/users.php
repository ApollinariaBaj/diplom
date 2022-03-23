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
            $search = strtolower($this->connection->real_escape_string($_REQUEST["search"]));
            if ($result = $this->connection->query(
                "SELECT id, login, is_admin FROM user where lower(login) LIKE '%" . $search . "%' order by login")) {
                while ($obj = $result->fetch_object()) {
                    $users[] = $obj;
                }
                unset($obj);
            }
        } elseif ($result = $this->connection->query("SELECT id, login, is_admin FROM user order by login")) {
            while ($obj = $result->fetch_object()) {
                $users[] = $obj;
            }
            unset($obj);
        }
        $result->close();
        return $users ?? [];
    }

    public function checkExist(int $id): bool
    {
        $id = $this->connection->real_escape_string($id);
        if ($result = $this->connection->query(
            "SELECT id FROM user where id='" . $id . "'")) {
            while ($obj = $result->fetch_object()) {
                $res = true;
            }
            unset($obj);
            $result->close();
            return $res ?? false;
        }
        $result->close();
        return false;
    }

    public function checkLoginExist(string $login, ?int $id = null): bool
    {
        $login = $this->connection->real_escape_string($login);
        if ($result = $this->connection->query(
            "SELECT id FROM user where login='" . $login . "'")) {
            while ($obj = $result->fetch_object()) {
                $res = true;
                if ($id && $id == $obj->id) {
                    $res = false;
                } elseif (!$id) {
                    $res = true;
                }
            }
            unset($obj);
            $result->close();
            return $res ?? false;
        }
        $result->close();
        return false;
    }

    public function addUser(string $login, string $password, bool $isAdmin): bool
    {
        $stmt = $this->connection->stmt_init();
        if (($stmt->prepare("INSERT INTO user (login, password, is_admin) VALUES (?, ?, ?)") === FALSE) ||
            ($stmt->bind_param('ssi', $login, $password, $isAdmin) === FALSE)
            || ($stmt->execute() === FALSE) || ($stmt->close() === FALSE)
        ) {
            return false;
        }
        $stmt->close();
        return true;
    }

    public function updateUser(int $id, ?string $login, ?string $password, bool $isAdmin): bool
    {
        $query = "UPDATE user SET %s WHERE user.id =" . $this->connection->real_escape_string($id);
        $set = '';
        $bindParam = '';
        $stmt = $this->connection->stmt_init();
        if ($login) {
            $set = "login=?";
            $bindParam = "s";
        }
        if ($password) {
            if (!empty($set)) {
                $set .= ", ";
            }
            $set .= "password=?";
            $bindParam .= "s";
        }
        if (!empty($set)) {
            $set .= ", ";
        }
        $set .= "is_admin=?";
        $bindParam .= "i";

        if ($stmt->prepare(sprintf($query, $set)) === FALSE) {
            return false;
        }
        if ($login && $password) {
            if (($stmt->bind_param($bindParam, $login, $password, $isAdmin) === FALSE)
                || ($stmt->execute() === FALSE) || ($stmt->close() === FALSE)) {
                return false;
            }
        } elseif ($login) {
            if (($stmt->bind_param($bindParam, $login, $isAdmin) === FALSE)
                || ($stmt->execute() === FALSE) || ($stmt->close() === FALSE)) {
                return false;
            }
        } elseif ($password) {
            if (($stmt->bind_param($bindParam, $password, $isAdmin) === FALSE)
                || ($stmt->execute() === FALSE) || ($stmt->close() === FALSE)) {
                return false;
            }
        } else {
            if (($stmt->bind_param($bindParam, $isAdmin) === FALSE)
                || ($stmt->execute() === FALSE) || ($stmt->close() === FALSE)) {
                return false;
            }
        }

        $stmt->close();
        return true;
    }

    public function deleteUser(int $id): bool
    {
        $stmt = $this->connection->stmt_init();
        if (($stmt->prepare("DELETE FROM user WHERE user.id = ?") === FALSE) ||
            ($stmt->bind_param('i', $id) === FALSE)
            || ($stmt->execute() === FALSE) || ($stmt->close() === FALSE)
        ) {
            return false;
        }
        $stmt->close();
        return true;
    }

    public function authorize(string $login, string $password): bool
    {
        if ($result = $this->connection->query(
            sprintf("SELECT id, is_admin FROM user WHERE login='%s' AND password='%s' limit 1",
                $this->connection->real_escape_string($login),
                $this->connection->real_escape_string($password))
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

    public static function logout(): bool
    {
        unset($_SESSION['user']); /* пррисваиваем нулевое значение */
//        session_destroy();
        return true;
    }

    public static function isAuthorized(): bool
    {
        session_start();
        if (!empty($_SESSION['user'])) {
            return true;
        }
        return false;
    }

    public static function isAdmin(): bool
    {
        session_start();
        if ($_SESSION['user']['admin']) {
            return true;
        }
        return false;
    }
}