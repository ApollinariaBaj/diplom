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
}