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
include_once '../object/Purchase.php';

// instantiate database and product object
$db = new Database();
$database = $db->databaseConnect();

$purchase = new Purchase($database);

// set user property values
$purchase->accountid = $_GET['email'];
$purchase->retailerid = $_GET['password'];
$purchase->amount = $_GET['password'];

// create the user
if ($purchase->purchase()) {
    $purchase_arr = array(
        "status" => true,
        "message" => "Transaction Successful",
        "id" => $user->id,
        "email" => $user->email,
        "password" => $user->password,
    );
} else {
    $purchase_arr = array(
        "status" => false,
        "message" => "Transaction Unsuccessful",
    );
}
print_r(json_encode($purchase_arr));
