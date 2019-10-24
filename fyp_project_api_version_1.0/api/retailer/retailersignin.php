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
include_once '../object/Retailer.php';

// instantiate database and product object
$db = new Database();
$database = $db->databaseConnect();

// initialize object
$retailer = new Retailer($database);

// set ID property of retailer to be edited
$retailer->email = isset($_GET['email']) ? $_GET['email'] : die();
$retailer->password = isset($_GET['password']) ? $_GET['password'] : die();

// read the details of retailer to be edited
$statement = $retailer->retailerSignin();

if ($statement->rowCount() > 0) {

    // get retrieved row
    $row = $statement->fetch(PDO::FETCH_ASSOC);

    // create array
    $retailer_arr = array(
        "status" => true,
        "message" => "Sign-in Successful",
        "retailerid" => $row['retailerid'],
        "email" => $row['email'],
    );
} else {
    $retailer_arr = array(
        "status" => false,
        "message" => "Sign-in Failed",
    );
}

// OUTPUT TO JSON FORMAT
print_r(json_encode($retailer_arr));