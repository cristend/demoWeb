<?php

class Model
{
    private $connection;

    public function __construct()
    {
        $this->connection = new MySQLi("localhost", "root", "Root_001", "flechazo");
        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        };
        // mysqli_report(MYSQLI_REPORT_ALL);
        $this->connection->autocommit(false);
    }

    public function get_conn()
    {
        return $this->connection;
    }
}
