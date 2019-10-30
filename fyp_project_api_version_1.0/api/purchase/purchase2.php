<?php
//required
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


//get database connection 
include_once '../config/Database.php';

//instantiate product object 
include_once '../object/Puchase2.php';

//instantiate database and product object
$db = new Database();
$database = $db->databaseConnect();

$purchase = new Purchase2($database);

//set user property values 
$purchase->userid = isset($_GET['userid']) ? $_GET['userid'] : die();
$purchase->retailerid = isset($_GET['retailerid']) ? $_GET['retailerid'] : die();
$purchase->amount = isset($_GET['amount']) ? $_GET['amount'] : die();

$purchase->getCurrent();
$purchase->getTotal();

$purchase->getAccountUser();
$purchase->getAccountRetailer();

$purchase->calculateDeduction();

//create the user 
if ($purchase->purchaseCreate()) {

    $purchase->updateAccountUser();
    $purchase->updateAccountUser();

    $purchase_arr = array(
        "status" => true,
        "message" => "Transaction Successful",
        "sender" => $purchase->userid,
        "receiver" => $purchase->retailerid,
        "amount" => $purchase->totaldeduction,
    );
} else {
    $purchase_arr = array(
        "status" => false,
        "message" => "Transaction fail",
    );
}
print_r(json_encode($purchase_arr));