<?php

class Profile
{
    private $connection;

    public $userid;
    public $email;
    public $password;
    public $fname;
    public $lname;
    public $noIC;

    public function __construct($connecting)
    {
        $this->connection = $connecting;
    }

    public function profileSingle()
    {
        $statement = "SELECT student.userid, student.email, student.password, student_detail.fname, student_detail.lname, student_detail.noIC FROM student INNER JOIN student_detail ON student.userid = student_detail.userid WHERE student.userid=? ORDER BY userid LIMIT 0,1";
        
        $query = $this->connection->prepare($statement);

        $query->bindParam(1, $this->userid);

        $query->execute();

        $row = $query->fetch(PDO::FETCH_ASSOC);

        $this->userid = $row['userid'];
        $this->email = $row['email'];
        $this->password = $row['password'];
        $this->fname = $row['fname'];
        $this->lname = $row['lname'];
        $this->noIC = $row['noIC'];
    }

    public function profileUpdate()
    {
        //update query 
        $statement = "UPDATE student INNER JOIN student_detail ON student.userid = student_detail.userid
        SET
            student.email = :email,
            student.password = :password,
            student_detail.fname = :fname,
            student_detail.lname = :lname,
            student_detail.noIC = :noIC
            
            WHERE student.userid =:userid";

        //prepare query statement 
        $query = $this->connection->prepare($statement);

        //sanitize 
        $this->userid = htmlspecialchars(strip_tags($this->userid));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->password = htmlspecialchars(strip_tags($this->password));
        $this->fname = htmlspecialchars(strip_tags($this->fname));
        $this->lname = htmlspecialchars(strip_tags($this->lname));
        $this->noIC = htmlspecialchars(strip_tags($this->noIC));

        //bind new values
        $query->bindParam(':userid', $this->userid);
        $query->bindParam(":email", $this->email);
        $query->bindParam(":password", $this->password);
        $query->bindParam(':fname', $this->fname);
        $query->bindParam(':lname', $this->lname);
        $query->bindParam(':noIC', $this->noIC);

         // execute the query
         if ($query->execute()) {
            return true;
        }

        return false;

    }

}