<?php

// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// get database connection
include_once '../config/Database.php';

// instantiate product object
include_once '../object/Student.php';

// instantiate database and product object
$db = new Database();
$database = $db->databaseConnect();

$user = new User($database);

// set user property values
$user->email = $_GET['email'];
$user->password = $_GET['password'];

// create the user
if ($user->studentSignup()) {
    $user_arr = array(
        "status" => true,
        "message" => "Sign-up Successful",
        "userid" => $user->userid,
        "email" => $user->email,
        "password" => $user->password,
    );
} else {
    $user_arr = array(
        "status" => false,
        "message" => "User already exist!",
    );
}
print_r(json_encode($user_arr));
