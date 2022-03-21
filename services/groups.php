<?php
require_once "Connection.php";
session_start();

class Groups
{
    const PAGE = 'groups.php';
    /**
     * @var Connection
     */
    private $connection;

    public function __construct()
    {
        $this->connection = new Connection();
    }

    public function getGroupsNames(): array
    {
        if ($result = $this->connection->query("SELECT id, name FROM `group`")) {
            while ($obj = $result->fetch_object()) {
                $groups[] = $obj;
            }
            unset($obj);
        }
        $result->close();
        return $groups ?? [];
    }

    public function getGroups(): array
    {
        if (isset($_REQUEST["search"])) {
            $search = $this->connection->real_escape_string($_REQUEST["search"]);
            $like = '';
            $arSearch = explode(' ', $search);
            foreach ($arSearch as $string) {
                if (!empty($string)) {
                    $string = strtolower($string);
                    if (!empty($like)) {
                        $like .= " AND ";
                    }
                    $like .= "(lower(name) LIKE '%{$string}%' 
                    XOR lower(type) LIKE '%{$string}%' ";
                    if ((int)$string) {
                        $like .= "XOR course={$string}";
                    }
                    $like .= ")";
                }
            }
            if ($result = $this->connection->query(
                "SELECT * FROM `group` where " . $like)) {
                while ($obj = $result->fetch_object()) {
                    $groups[] = $obj;
                }
                unset($obj);
            }
        } elseif ($result = $this->connection->query("SELECT * FROM `group`")) {
            while ($obj = $result->fetch_object()) {
                $groups[] = $obj;
            }
            unset($obj);
        }
        $result->close();
        return $groups ?? [];
    }

    public function checkExist(int $id): bool
    {
        $id = $this->connection->real_escape_string($id);
        if ($result = $this->connection->query(
            "SELECT id FROM `group` where id='" . $id . "'")) {
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

    public function addGroup(string $name, string $type, int $course): bool
    {
        $stmt = $this->connection->stmt_init();
        if (($stmt->prepare("INSERT INTO `group` (name, type, course) VALUES (?, ?, ?)") === FALSE) ||
            ($stmt->bind_param('ssi', $name, $type, $course) === FALSE)
            || ($stmt->execute() === FALSE) || ($stmt->close() === FALSE)
        ) {
            return false;
        }
        $stmt->close();
        return true;
    }

    public function updateGroup(int $id, ?string $name, ?string $type, ?int $course): bool
    {
        $query = "UPDATE `group` SET %s WHERE `group`.id =" . $this->connection->real_escape_string($id);
        $set = '';
        $bindParam = '';
        $stmt = $this->connection->stmt_init();
        if ($name) {
            $set = "name=?";
            $bindParam = "s";
        }
        if ($type) {
            if (!empty($set)) {
                $set .= ", ";
            }
            $set .= "type=?";
            $bindParam .= "s";
        }
        if ($course) {
            if (!empty($set)) {
                $set .= ", ";
            }
            $set .= "course=?";
            $bindParam .= "i";
        }

        if ($stmt->prepare(sprintf($query, $set)) === FALSE) {
            return false;
        }
        if ($name && $type && $course) {
            if (($stmt->bind_param($bindParam, $name, $type, $course) === FALSE)
                || ($stmt->execute() === FALSE) || ($stmt->close() === FALSE)) {
                return false;
            }
        } elseif ($name && $type) {
            if (($stmt->bind_param($bindParam, $name, $type) === FALSE)
                || ($stmt->execute() === FALSE) || ($stmt->close() === FALSE)) {
                return false;
            }
        } elseif ($name && $course) {
            if (($stmt->bind_param($bindParam, $name, $course) === FALSE)
                || ($stmt->execute() === FALSE) || ($stmt->close() === FALSE)) {
                return false;
            }
        } elseif ($course && $type) {
            if (($stmt->bind_param($bindParam, $type, $course) === FALSE)
                || ($stmt->execute() === FALSE) || ($stmt->close() === FALSE)) {
                return false;
            }
        } elseif ($name) {
            if (($stmt->bind_param($bindParam, $name) === FALSE)
                || ($stmt->execute() === FALSE) || ($stmt->close() === FALSE)) {
                return false;
            }
        } elseif ($type) {
            if (($stmt->bind_param($bindParam, $type) === FALSE)
                || ($stmt->execute() === FALSE) || ($stmt->close() === FALSE)) {
                return false;
            }
        } elseif ($course) {
            if (($stmt->bind_param($course) === FALSE)
                || ($stmt->execute() === FALSE) || ($stmt->close() === FALSE)) {
                return false;
            }
        }

        $stmt->close();
        return true;
    }

    public function deleteGroup(int $id): bool
    {
        $stmt = $this->connection->stmt_init();
        if (($stmt->prepare("DELETE FROM `group` WHERE `group`.id = ?") === FALSE) ||
            ($stmt->bind_param('i', $id) === FALSE)
            || ($stmt->execute() === FALSE) || ($stmt->close() === FALSE)
        ) {
            return false;
        }
        $stmt->close();
        return true;
    }
}