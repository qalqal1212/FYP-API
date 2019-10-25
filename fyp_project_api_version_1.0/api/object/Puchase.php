<?php

class Purchase 
{
    private $connection;

    public $userid;
    public $retailerid;
    public $amount;

    public $usercurrent;
    public $retailertotal;

    public $accountuser;
    public $accountretailer;

    public $newcurrent;
    public $newtotal;

    public $transactionid;

    public function __construct($connecting)
    {
        $this->connection = $connecting;        
    }

    //DONE
    public function getCurrent()
    {
        $statement = "SELECT wallet FROM account_user WHERE userid=? ORDER BY userid LIMIT 0,1";
        $query = $this->connection->prepare($statement);
        $query->bindParam(1, $this->userid);
        $query->execute();
        $row = $query->fetch(PDO::FETCH_ASSOC);
        $this->usercurrent = $row['wallet'];
    }

    //DONE
    public function getTotal()
    {
        
    }
}