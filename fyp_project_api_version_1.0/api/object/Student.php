<?php

class User
{
    private $connection;
    
    public $userid;
    public $email;
    public $password;

    public function __construct($connecting)
    {
        $this->connection = $connecting;
    }

    public function studentCheck()
    {
        $statement = "SELECT email FROM student WHERE email='$this->email'";

        $query = $this->connection->prepare($statement);

        $query->execute();

        if ($query->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function studentSignup()
    {
        if ($this->studentCheck() == false) {
            $statement = "INSERT INTO student SET email=:email, password=:password";

            $query = $this->connection->prepare($statement);

            $this->email = htmlspecialchars(strip_tags($this->email));
            $this->password = htmlspecialchars(strip_tags($this->password));

            $query->bindparam(":email", $this->email);
            $query->bindparam(":password", $this->password);

            if ($query->execute()) {
                $this->userid = $this->connection->lastInsertId();
                return true;
            }
        } else {

            return false;
        }
    }

    public function studentSignin()
    {
        $statement = "SELECT userid, email, password FROM student WHERE email='$this->email' AND password='$this->password'";

        $query = $this->connection->prepare($statement);

        $query->execute();

        return $query; 
    }

    public function studentList()
    {
        $statement = "SELECT userid, email, password FROM student";

        $query = $this->connection->prepare($statement);

        $query->execute();

        return $query;
    }

    public function studentSingle()
    {
        $statement = "SELECT userid, email, password FROM student WHERE userid=? ORDER BY userid LIMIT 0,1";

        $query = $this->connection->prepare($statement);

        $query->bindParam(1, $this->userid);

        $query->execute();

        $row = $query->fetch(PDO::FETCH_ASSOC);

        $this->userid = $row['userid'];
        $this->email = $row['email'];
        $this->password = $row['password'];  
    }

    public function studentResetPassword()
    {
        $statement = "UPDATE student SET password=:password WHERE email=:email";

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

    //User Create
    public function create()
    {
        // query to insert record
        //$query = "INSERT INTO student SET userid=:0, email=:email, password=:password, phone=:phone";
        $query = "INSERT INTO student SET email=:email, password=:password";

        // prepare query
        $statement = $this->connectionInstance->prepare($query);

        // sanitize
        //$this->userid = htmlspecialchars(strip_tags($this->userid));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->password = htmlspecialchars(strip_tags($this->password));

        // bind values
        //$statement->bindParam(":userid", $this->userid);
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
         $query = "UPDATE student SET
                 email = :email,
                 password = :password
             WHERE
                 userid = :userid";
 
         // prepare query statement
         $statement = $this->connectionInstance->prepare($query);
 
         // sanitize
         $this->email = htmlspecialchars(strip_tags($this->email));
         $this->password = htmlspecialchars(strip_tags($this->password));
 
         // bind new values
         $statement->bindParam(":email", $this->email);
         $statement->bindParam(":password", $this->password);
         $statement->bindParam(':userid', $this->userid);
 
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
        $query = "DELETE FROM student WHERE userid='$this->userid'";

        // prepare query
        $statement = $this->connectionInstance->prepare($query);

        // sanitize
        $this->userid = htmlspecialchars(strip_tags($this->userid));

        // bind id of record to delete
        $statement->bindParam(1, $this->userid);

        // execute query
        if ($statement->execute()) {
            return true;
        }

        return false;

    }

    
}
