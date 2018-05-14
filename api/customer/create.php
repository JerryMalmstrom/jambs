<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// get database connection
include_once '../config/database.php';
 
// instantiate customer object
include_once '../objects/customer.php';
 
$database = new Database();
$db = $database->getConnection();
 
$customer = new Customer($db);
 
// get posted data
$data = json_decode(file_get_contents("php://input"));
 
// set customer property values
$customer->companyname = $data->companyname;
$customer->address = $data->address;
$customer->phonenumber = $data->phonenumber;
$customer->email = $data->email;
$customer->createdat = date('Y-m-d H:i:s');
 
// create the customer
if($customer->create()){
    echo '{';
        echo '"message": "Customer was created."';
    echo '}';
}
 
// if unable to create the customer, tell the user
else{
    echo '{';
        echo '"message": "Unable to create customer."';
    echo '}';
}
?>