<?php

// HEADER
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// get database connection
include_once '../config/Database.php';

// instantiate product object
include_once '../object/Student.php';

// instantiate database and product object
$db = new Database();
$database = $db->databaseConnect();

// initialize object
$user = new User($database);

// set ID property of user to be edited
$user->email = isset($_GET['email']) ? $_GET['email'] : die();
$user->password = isset($_GET['password']) ? $_GET['password'] : die();

// read the details of user to be edited
$statement = $user->studentSignin();

if ($statement->rowCount() > 0) {

    // get retrieved row
    $row = $statement->fetch(PDO::FETCH_ASSOC);

    // create array
    $user_arr = array(
        "status" => true,
        "message" => "Sign-in Successful",
        "userid" => $row['userid'],
        "email" => $row['email'],
    );
} else {
    $user_arr = array(
        "status" => false,
        "message" => "Sign-in Failed",
    );
}

// OUTPUT TO JSON FORMAT
print_r(json_encode($user_arr));
