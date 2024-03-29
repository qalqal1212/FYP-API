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
$databaseInstance = new Database();
$database = $databaseInstance->databaseConnect();

// initialize object
$user = new User($database);

$user->userid = isset($_REQUEST['userid']) ? $_REQUEST['userid'] : die();

// get product id
//$data = json_decode(file_get_contents("php://input"));

// set product id to be deleted
$user->userid = $data->userid;

// delete the product
if ($user->delete()) {

    // set response code - 200 ok
    http_response_code(200);

    // tell the user
    echo json_encode(array("message" => "User was deleted."));
}

// if unable to delete the product
else {

    // set response code - 503 service unavailable
    http_response_code(503);

    // tell the user
    echo json_encode(array("message" => "Unable to delete User."));
}
