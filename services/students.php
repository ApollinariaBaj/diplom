<?php
require_once "Connection.php";
session_start();

class Students
{
    const PAGE = 'students.php';
    /**
     * @var Connection
     */
    private $connection;

    public function __construct()
    {
        $this->connection = new Connection();
    }

    public function getStudents(): array
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
                    $like .= "(lower(student.name) LIKE '%{$string}%' 
                    XOR lower(father_name) LIKE '%{$string}%' 
                    XOR lower(sur_name) LIKE '%{$string}%' 
                    XOR lower(`group`.name) LIKE '%{$string}%')";

                }
            }
            if ($result = $this->connection->query(
                "SELECT student.*, `group`.name as `group` FROM student
                    LEFT JOIN `group`
                    ON  student.group_id = `group`.id 
                    where " . $like)) {
                while ($obj = $result->fetch_object()) {
                    $students[] = $obj;
                }
                unset($obj);
            }
        } elseif ($result = $this->connection->query("SELECT student.*, `group`.name as `group` FROM student
                    LEFT JOIN `group`
                    ON  student.group_id = `group`.id")) {
            while ($obj = $result->fetch_object()) {
                $students[] = $obj;
            }
            unset($obj);
        }
        $result->close();
        return $students ?? [];
    }

    public function checkExist(int $id): bool
    {
        $id = $this->connection->real_escape_string($id);
        if ($result = $this->connection->query(
            "SELECT id FROM student where id='" . $id . "'")) {
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

    public function addStudent(string $surName, string $name, ?string $fatherName, ?int $group): bool
    {
        $stmt = $this->connection->stmt_init();
        if (($stmt->prepare("INSERT INTO student (sur_name, name, father_name, group_id) VALUES (?, ?, ?, ?)") === FALSE) ||
            ($stmt->bind_param('sssi', $surName, $name, $fatherName, $group) === FALSE)
            || ($stmt->execute() === FALSE) || ($stmt->close() === FALSE)
        ) {
            return false;
        }
        $stmt->close();
        return true;
    }

    public function updateStudent(int $id, ?string $surName, ?string $name, ?string $fatherName, ?int $group): bool
    {
        $query = "UPDATE student SET %s WHERE student.id =" . $this->connection->real_escape_string($id);
        $set = '';
        $bindParam = '';
        $stmt = $this->connection->stmt_init();
        if ($surName) {
            $set = "sur_name=?";
            $bindParam = "s";
        }
        if ($name) {
            if (!empty($set)) {
                $set .= ", ";
            }
            $set .= "name=?";
            $bindParam .= "s";
        }
        if (!empty($set)) {
            $set .= ", ";
        }
        $set .= "father_name=?, group_id=?";
        $bindParam .= "si";

        if ($stmt->prepare(sprintf($query, $set)) === FALSE) {
            return false;
        }
        if ($surName && $name) {
            if (($stmt->bind_param($bindParam, $surName, $name, $fatherName, $group) === FALSE)
                || ($stmt->execute() === FALSE) || ($stmt->close() === FALSE)) {
                return false;
            }
        } elseif ($surName) {
            if (($stmt->bind_param($bindParam, $surName, $fatherName, $group) === FALSE)
                || ($stmt->execute() === FALSE) || ($stmt->close() === FALSE)) {
                return false;
            }
        } elseif ($name) {
            if (($stmt->bind_param($bindParam, $name, $fatherName, $group) === FALSE)
                || ($stmt->execute() === FALSE) || ($stmt->close() === FALSE)) {
                return false;
            }
        } else {
            if (($stmt->bind_param($bindParam, $fatherName, $group) === FALSE)
                || ($stmt->execute() === FALSE) || ($stmt->close() === FALSE)) {
                return false;
            }
        }

        $stmt->close();
        return true;
    }

    public function deleteStudent(int $id): bool
    {
        $stmt = $this->connection->stmt_init();
        if (($stmt->prepare("DELETE FROM student WHERE student.id = ?") === FALSE) ||
            ($stmt->bind_param('i', $id) === FALSE)
            || ($stmt->execute() === FALSE) || ($stmt->close() === FALSE)
        ) {
            return false;
        }
        $stmt->close();
        return true;
    }
}