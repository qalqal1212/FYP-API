<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

// include database and object files
include_once '../config/Database.php';
include_once '../object/Profile.php';

// instantiate database and product object
$db = new Database();
$database = $db->databaseConnect();

// initialize object
$profile = new Profile($database);

// set ID property of record to read
$profile->userid = isset($_GET['userid']) ? $_GET['userid'] : die();

// read the details of product to be edited
$profile->profileSingle();

if ($profile->userid != null) {

    // create array
    $profile_arr = array(
        "userid" => $profile->userid,
        "email" => $profile->email,
        "password" => $profile->password,
        "fname" => $profile->fname,
        "lname" => $profile->lname,
        "noIC" => $profile->noIC,
    );

    // set response code - 200 OK
    http_response_code(200);

    // make it json format
    echo json_encode($profile_arr);
} else {
    // set response code - 404 Not found
    http_response_code(404);

    // tell the user product does not exist
    echo json_encode(array("message" => "User does not exist."));
}
