<?php
require_once "Connection.php";
session_start();

class Subjects
{
    const PAGE = 'subjects.php';
    /**
     * @var Connection
     */
    private $connection;

    public function __construct()
    {
        $this->connection = new Connection();
    }

    public function checkNameExist(string $name, ?int $id = null): bool
    {
        $name = $this->connection->real_escape_string($name);
        if ($result = $this->connection->query(
            "SELECT id FROM subject where name='" . $name . "'")) {
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

    public function getByName(string $name): ?int
    {
        $name = $this->connection->real_escape_string($name);
        if ($result = $this->connection->query(
            "SELECT id FROM subject where name='" . $name . "'")) {
            while ($obj = $result->fetch_object()) {
                $res = $obj->id;
            }
            unset($obj);
            $result->close();
            return $res ?? null;
        }
        $result->close();
        return null;
    }

    public function getSubjects(): array
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
                    $like .= "(lower(subject.name) LIKE '%{$string}%' 
                    XOR lower(teacher.sur_name) LIKE '%{$string}%'
                    XOR lower(teacher.name) LIKE '%{$string}%'
                    XOR lower(teacher.father_name) LIKE '%{$string}%'
                    )";

                }
            }
            if ($result = $this->connection->query(
                "SELECT subject.*, teacher.id as teachers_id,
                    CONCAT_WS(' ', teacher.sur_name, teacher.name, teacher.father_name) as teachers
                    FROM subject
                    LEFT JOIN subject_teacher
                    ON  subject.id = subject_teacher.subject_id 
                    LEFT JOIN teacher
                    ON  subject_teacher.teacher_id = teacher.id
                    where " . $like ." order by subject.name")) {
                while ($obj = $result->fetch_object()) {
                    $subjects[] = $obj;
                }
                unset($obj);
            }
        } elseif ($result = $this->connection->query("SELECT subject.*, teacher.id as teachers_id,
                    CONCAT_WS(' ', teacher.sur_name, teacher.name, teacher.father_name) as teachers
                    FROM subject
                    LEFT JOIN subject_teacher
                    ON  subject.id = subject_teacher.subject_id 
                    LEFT JOIN teacher
                    ON  subject_teacher.teacher_id = teacher.id order by subject.name")) {
            while ($obj = $result->fetch_object()) {
                $subjects[] = $obj;
            }
            unset($obj);
        }
        $result->close();
        return $subjects ?? [];
    }

    public function checkExist(int $id): bool
    {
        $id = $this->connection->real_escape_string($id);
        if ($result = $this->connection->query(
            "SELECT id FROM subject where id='" . $id . "'")) {
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

    public function addSubject(string $name): bool
    {
        $stmt = $this->connection->stmt_init();
        if (($stmt->prepare("INSERT INTO subject (name) VALUES (?)") === FALSE) ||
            ($stmt->bind_param('s', $name) === FALSE)
            || ($stmt->execute() === FALSE) || ($stmt->close() === FALSE)
        ) {
            return false;
        }

        $stmt->close();
        return true;
    }

    public function updateSubject(int $id, ?string $name): bool
    {
        $query = "UPDATE subject SET %s WHERE subject.id =" . $this->connection->real_escape_string($id);

        $stmt = $this->connection->stmt_init();
        if ($name) {
            $set = "name=?";
            $bindParam = "s";
            if ($stmt->prepare(sprintf($query, $set)) === FALSE) {
                return false;
            }
            if (($stmt->bind_param($bindParam, $name) === FALSE)
                || ($stmt->execute() === FALSE) || ($stmt->close() === FALSE)) {
                return false;
            }
        }

        $stmt->close();
        return true;
    }

    public function updateSubjectTeacher(int $id, ?array $teachers): bool
    {
        $id = $this->connection->real_escape_string($id);
        $current = [];
        if ($result = $this->connection->query(
            "SELECT id, teacher_id FROM subject_teacher where subject_id=" . $id)) {
            while ($obj = $result->fetch_object()) {
                $current[$obj->id] = $obj->teacher->id;
            }
            unset($obj);
            $result->close();
        }

        foreach ($teachers as $teacher) {
            if (in_array($teacher, $current)) {
                unset($current[array_search($teacher, $current)]);
                continue;
            }
            $stmt = $this->connection->stmt_init();
            if (($stmt->prepare("INSERT INTO subject_teacher (subject_id, teacher_id) VALUES (?, ?)") === FALSE)
                || ($stmt->bind_param('ii', $id, $teacher) === FALSE)
                || ($stmt->execute() === FALSE) || ($stmt->close() === FALSE)
            ) {
                return false;
            }
        }
        foreach ($current as $remove => $teacher) {
            $stmt = $this->connection->stmt_init();
            if (($stmt->prepare("DELETE FROM subject_teacher WHERE id = ?") === FALSE) ||
                ($stmt->bind_param('i', $remove) === FALSE)
                || ($stmt->execute() === FALSE) || ($stmt->close() === FALSE)
            ) {
                return false;
            }
        }
        $result->close();
        return true;
    }

    public function deleteSubject(int $id): bool
    {
        $stmt = $this->connection->stmt_init();
        if (($stmt->prepare("DELETE FROM subject WHERE subject.id = ?") === FALSE) ||
            ($stmt->bind_param('i', $id) === FALSE)
            || ($stmt->execute() === FALSE) || ($stmt->close() === FALSE)
        ) {
            return false;
        }
        $stmt->close();
        return true;
    }
}