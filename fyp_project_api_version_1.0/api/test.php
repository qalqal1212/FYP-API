
<?php
$servername = "localhost";
$username = "root";
$password = "";

try {
    $conn = new PDO("mysql:host=$servername;dbname=wallet", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Connected successfully";

    $statement = "SELECT * FROM user WHERE userid='1'";

    $query = $this->connection->prepare($statement);

    $query->execute();

    $row = mysqli_fetch_row($query);

    echo '$row["userid"]';

} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

$connection = null;
?>

<!DOCTYPE html>
<html>
<head>
<title>Page Title</title>
</head>
<body>


<h1><?php echo $asdasdasd; ?> asddd</h1>
<p>This is a paragraph.</p>

</body>
</html>