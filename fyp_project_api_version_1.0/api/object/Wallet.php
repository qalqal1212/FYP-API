<?php

class Wallet
{
    private $connection;

    public $accuserID;
    public $userid;
    public $wallet;

    public function __construct($connecting)
    {
        $this->connection = $connecting;
    }

    public function walletShow()
    {
        $statement = "SELECT accuserID, userid, wallet FROM account_user WHERE userid=? ORDER BY userid LIMIT 0,1";

        $query = $this->connection->prepare($statement);

        $query->bindParam(1, $this->userid);

        $query->execute();

        $row = $query->fetch(PDO::FETCH_ASSOC);

        $this->accuserID = $row['accuserID'];
        $this->userid = $row['userid'];
        $this->wallet = $row['wallet'];
    }
}
