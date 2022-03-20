<?php
class Connection extends \mysqli
{
    const HOST_NAME = 'localhost';
    const USER_NAME = 'polinarv_1';
    const PASSWORD = 'Password1!';
    const DATABASE = 'polinarv_1';

    public function __construct()
    {
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        parent::__construct(self::HOST_NAME, self::USER_NAME, self::PASSWORD, self::DATABASE);
    }
}