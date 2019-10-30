<?php

class History
{
    private $connection;

    public $retailerid;
    public $receiver;

    public $transactionid;
    public $created_at;
    public $amount;

    public function __construct($connecting)
    {
        $this->connection = $connecting;
    }

    public function historyRetailer()
    {
        $statement = "SELECT B.retailerid, A.transactionid, A.amount, A.created_at as datetime FROM transaction_purchase A INNER JOIN account_retailer B ON A.receiver = B.accountid WHERE B.retailerid=? ORDER BY receiver";

        $query = $this->connection->prepare($statement);

        $query->bindParam(1, $this->retailerid);

        $query->execute();

        return $query;
    }

    public function historyPurchase()
    {
        $statement = "SELECT B.userid, A.transactionid, A.amount, A.created_at as datetime FROM transaction_purchase A INNER JOIN account_user B ON A.sender = B.accuserID WHERE B.userid=? ORDER BY sender";

        $query = $this->connection->prepare($statement);

        $query->bindParam(1, $this->userid);

        $query->execute();

        return $query;
    }

    public function historySend()
    {
        $statement = "SELECT B.userid, A.transactionid, A.amount, A.created_at as datetime FROM transaction_transfer A INNER JOIN account_user B ON A.sender = B.accuserID WHERE B.userid=? ORDER BY sender";

        $query = $this->connection->prepare($statement);

        $query->bindParam(1, $this->userid);

        $query->execute();

        return $query;
    }

    public function historyReceive()
    {
        $statement = "SELECT B.userid, A.transactionid, A.amount, A.created_at as datetime FROM transaction_transfer A INNER JOIN account_user B ON A.receiver = B.accuserID WHERE B.userid=? ORDER BY receiver";

        $query = $this->connection->prepare($statement);

        $query->bindParam(1, $this->userid);

        $query->execute();

        return $query;
    }
}