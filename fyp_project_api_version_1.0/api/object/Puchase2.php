<?php

class Purchase2
{
    private $connection;

    public $userid;
    public $retailerid;
    public $amount;

    public $usercurrent;
    public $retailertotal;

    public $accountuser;
    public $accountretailer;

    public $totaldeduction;
    public $totaloverall;

    public $newcurrent;
    public $newtotal;

    public $transactionid;

    public function __construct($connecting)
    {
        $this->connection = $connecting;
    }

    public function getCurrent()
    {
        $statement = "SELECT wallet FROM account_user WHERE userid=? ORDER BY userid LIMIT 0,1";
        $query = $this->connection->prepare($statement);
        $query->bindParam(1, $this->userid);
        $query->execute();
        $row = $query->fetch(PDO::FETCH_ASSOC);
        $this->usercurrent = $row['wallet'];
    }

    public function getTotal()
    {
        $statement = "SELECT amount FROM account_retailer WHERE retailerid=? ORDER BY retailerid LIMIT 0,1";
        $query = $this->connection->prepare($statement);
        $query->bindParam(1, $this->retailerid);
        $query->execute();
        $row = $query->fetch(PDO::FETCH_ASSOC);
        $this->retailertotal = $row['amount'];
    }

    public function getAccountUser()
    {
        $statement = "SELECT accuserID FROM account_user WHERE userid=? ORDER BY userid LIMIT 0,1";
        $query = $this->connection->prepare($statement);
        $query->bindParam(1, $this->userid);
        $query->execute();
        $row = $query->fetch(PDO::FETCH_ASSOC);
        $this->accountuser = $row['accuserID'];
    }

    public function getAccountRetailer()
    {
        $statement = "SELECT accountid FROM account_retailer WHERE retailerid=? ORDER BY retailerid LIMIT 0,1";
        $query = $this->connection->prepare($statement);
        $query->bindParam(1, $this->retailerid);
        $query->execute();
        $row = $query->fetch(PDO::FETCH_ASSOC);
        $this->accountretailer = $row['accountid'];

    }

    public function calculateDeduction()
    {
        $this->totaldeduction = number_format($this->amount, 2);
        return $this->totaldeduction; 
    }

    public function purchaseCreate()
    {
        $this->totaloverall = $this->totaldeduction;

        $statement = "INSERT INTO transaction_purchase SET sender=:sender, receiver=:receiver, amount=:amount, created_at=NOW()";

        $query = $this->connection->prepare($statement);

        $this->userid = htmlspecialchars(strip_tags($this->userid));
        $this->retailerid = htmlspecialchars(strip_tags($this->retailerid));
        $this->totaloverall = htmlspecialchars(strip_tags($this->totaloverall));

        $query->bindParam(":sender", $this->userid);
        $query->bindParam("receiver", $this->retailerid);
        $query->bindParam(":amount", $this->totaldeduction);
        

        if($query->execute()) {
            $this->transactionid = $this->connection->lastInsertId();
            return true;
        }
    }

    public function updateAccountUser()
    {
       $this->newcurrent = $this->usercurrent - $this->totaldeduction;
       
       //update query 
       $statement = "UPDATE account_user SET wallet=:wallet WHERE userid=:userid";

       //prepare query statement
       $query = $this->connection->prepare($statement);

       //san
       $this->userid = htmlspecialchars(strip_tags($this->userid));
       $this->newcurrent = htmlspecialchars(strip_tags($this->newcurrent));
       
       //bind new values
       $query->bindParam(':userid', $this->userid);
       $query->bindParam(":wallet", $this->newcurrent);
       
       if ($query->execute()) {
           return true;
       }

       return false;
    }

    public function updateAccountRetailer()
    {
        $this->newtotal = $this->retailertotal + $this->amount;

        //update query 
        $statement = "UPDATE account_retailer SET amount=:amount WHERE retailerid=:retailerid";

        //prepare query statement 
        $query = $this->connection->prepare($statement);

        //san
        $this->retailerid = htmlspecialchars(strip_tags($this->retailerid));
        $this->newtotal = htmlspecialchars(strip_tags($this->newtotal));

        //bind new values 
        $query->bindParam(':retailerid', $this->retailerid);
        $query->bindParam(":amount", $this->newtotal);

        //execute query 
        if ($query->execute()) {
            return true;
        }

        return false;
    }
}