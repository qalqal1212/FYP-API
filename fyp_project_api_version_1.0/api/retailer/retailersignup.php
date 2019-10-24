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
include_once '../object/Retailer.php';

// instantiate database and product object
$db = new Database();
$database = $db->databaseConnect();

$retailer = new Retailer($database);

// set retailer property values
$retailer->email = $_GET['email'];
$retailer->password = $_GET['password'];

// create the retailer
if ($retailer->retailerSignup()) {
    $retailer_arr = array(
        "status" => true,
        "message" => "Sign-up Successful",
        "id" => $retailer->id,
        "email" => $retailer->email,
        "password" => $retailer->password,
    );
} else {
    $retailer_arr = array(
        "status" => false,
        "message" => "Retailer already exist!",
    );
}
print_r(json_encode($retailer_arr));