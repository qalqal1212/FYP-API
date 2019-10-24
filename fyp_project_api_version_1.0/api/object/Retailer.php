<?php

class Retailer 
{
    private $connection;

    public $retailerid;
    public $email;
    public $password;

    public function __construct($connecting)
    {
        $this->connection = $connecting;
    }

    public function retailerCheck()
    {
        $statement = "SELECT email FROM retailer WHERE email='$this->email'";

        $query = $this->connection->prepare($statement);

        $query->execute();

        if ($query->rowCount() > 0) {
            return true;

        } else {
            return false;
        }
    }

    public function retailerSignup()
    {
        if ($this->retailerCheck() == false) {
            $statement = "INSERT INTO retailer SET email=:email, password=:password";

            $query = $this->connection->prepare($statement);

            $this->email = htmlspecialchars(strip_tags($this->email));
            $this->password = htmlspecialchars(strip_tags($this->password));

            $query->bindParam(":email", $this->email);
            $query->bindParam(":password", $this->password);

            if ($query->execute()) {
                $this->retailerid = $this->connection->lastInsertId();
                return true;
            }
        } else {
            return false;
        }

    }

    public function retailerSignin()
    {
        $statement = "SELECT retailerid, email, password FROM retailer WHERE email='$this->email' AND password='$this->password'";

        $query = $this->connection->prepare($statement);

        $query->execute();

        return $query;
    }

    public function retailerList()
    {
        $statement = "SELECT retailerid, email, password FROM retailer";

        $query = $this->connection->prepare($statement);

        $query->execute();

        return $query;
    }

    public function retailerSingle()
    {
        $statement = "SELECT retailerid, email, password FROM retailer WHERE retailerid=? ORDER BY retailerid LIMIT 0,1";

        $query = $this->connection->prepare($statement);

        $query->bindParam(1, $this->retailerid);

        $query->execute();

        $row = $query->fetch(PDO::FETCH_ASSOC);

        $this->retailerid = $row['retailerid'];
        $this->email = $row['email'];
        $this->password = $row['password'];
    }

    public function retailerResetPassword()
    {
        $statement = "UPDATE retailer SET password=:password WHERE email=:email";

        $query = $this->connection->prepare($statement);

        $this->password = htmlspecialchars(strip_tags($this->password));

        $query->bindParam(":password", $this->password);
        $query->bindParam(":email", $this->email);

        if ($query->execute()) {
            return true;
        } else {
            return false;
        }
    }

     //! USER > CREATE
     public function create()
     {
 
         // query to insert record
         //$query = "INSERT INTO retailer SET retailerid=:0, email=:email, password=:password, phone=:phone";
         $query = "INSERT INTO retailer SET email=:email, password=:password";
 
         // prepare query
         $statement = $this->connectionInstance->prepare($query);
 
         // sanitize
         //$this->retailerid = htmlspecialchars(strip_tags($this->retailerid));
         $this->email = htmlspecialchars(strip_tags($this->email));
         $this->password = htmlspecialchars(strip_tags($this->password));
 
         // bind values
         //$statement->bindParam(":retailerid", $this->retailerid);
         $statement->bindParam(":email", $this->email);
         $statement->bindParam(":password", $this->password);
 
         // execute query
         if ($statement->execute()) {
             return true;
         }
 
         return false;
 
     }

      //! USER > UPDATE
    public function update()
    {

        // update query
        $query = "UPDATE retailer SET
                email = :email,
                password = :password
            WHERE
                retailerid = :retailerid";

        // prepare query statement
        $statement = $this->connectionInstance->prepare($query);

        // sanitize
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->password = htmlspecialchars(strip_tags($this->password));

        // bind new values
        $statement->bindParam(":email", $this->email);
        $statement->bindParam(":password", $this->password);
        $statement->bindParam(':retailerid', $this->retailerid);

        // execute the query
        if ($statement->execute()) {
            return true;
        }

        return false;
    }

     //! USER > DELETE
     public function delete()
     {
         // delete query
         $query = "DELETE FROM retailer WHERE retailerid='$this->retailerid'";
 
         // prepare query
         $statement = $this->connectionInstance->prepare($query);
 
         // sanitize
         $this->retailerid = htmlspecialchars(strip_tags($this->retailerid));
 
         // bind id of record to delete
         $statement->bindParam(1, $this->retailerid);
 
         // execute query
         if ($statement->execute()) {
             return true;
         }
 
         return false;
 
     }
}