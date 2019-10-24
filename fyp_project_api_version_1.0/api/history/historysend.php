<?php
// HEADER
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include_once '../config/Database.php';
include_once '../object/History.php';

// instantiate database and product object
$db = new Database();
$database = $db->databaseConnect();

// initialize object
$history = new History($database);

// set ID property of record to read
$history->userid = isset($_GET['userid']) ? $_GET['userid'] : die();

// query products
$statement = $history->historySend();
$num = $statement->rowCount();

// check if more than 0 record found
if ($num > 0) {

    // products array
    $historys_arr = array();
    //!$users_arr["records"] = array();
    //?$users_arr[""] = array();

    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);

        $history_item = array(
            "transactionid" => $transactionid,
            "datetime" => $datetime,
            "amount" => $amount,
        );

        //!array_push($users_arr["records"], $user_item);
        array_push($historys_arr, $history_item);
    }

    // set response code - 200 OK
    http_response_code(200);

    // show products data in json format
    echo json_encode($historys_arr);
}

// no products found will be here
else {

    // set response code - 404 Not found
    http_response_code(404);

    // tell the user no products found
    echo json_encode(
        array("message" => "No products found.")
    );
}