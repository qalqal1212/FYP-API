<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// include database and object files
include_once '../config/Database.php';
include_once '../object/Profile.php';

// instantiate database and product object
$db = new Database();
$database = $db->databaseConnect();

// initialize object
$profile = new Profile($database);

// get id of product to be edited
//! $data = json_decode(file_get_contents("php://input"));

// set ID property of product to be edited
//! $profile->userid = $data->userid;

//! set product property values
//! $profile->email = $data->email;
//! $profile->password = $data->password;
//! $profile->fname = $data->fname;
//! $profile->mname = $data->mname;
//! $profile->lname = $data->lname;
//! $profile->phone = $data->phone;

$profile->userid = $_GET['userid'];
$profile->email = $_GET['email'];
$profile->password = $_GET['password'];
$profile->fname = $_GET['fname'];
$profile->lname = $_GET['lname'];
$profile->noIC = $_GET['noIC'];

// update the product
if ($profile->profileUpdate()) {

    // set response code - 200 ok
    http_response_code(200);

    // tell the user
    echo json_encode(array("message" => "Profile was updated."));
}

// if unable to update the product, tell the profile
else {

    // set response code - 503 service unavailable
    http_response_code(503);

    // tell the rofile
    echo json_encode(array("message" => "Unable to update rofile."));
}
