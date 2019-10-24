<?php

class Database
{
    //Database Parameters
    private $dbhost = "localhost";
    private $dbuser = "root";
    private $dbpass = "";
    private $dbname = "wallet";
    private $connection;

    //! Connect Database
    public function databaseConnect()
    {
        $this->connection = null;

        try {
            $this->connection = new PDO("mysql:host=" . $this->dbhost . ";dbname=" . $this->dbname, $this->dbuser, $this->dbpass);
            $this->connection->exec("set names utf8");
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->connection;
    }

    //! Disconnect Database
    public function databaseDisconnect()
    {
        $this->connection = null;
    }
}