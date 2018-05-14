<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/customer.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare customer object
$customer = new Customer($db);
 
// get id of customer to be edited
$data = json_decode(file_get_contents("php://input"));
 
// set ID property of customer to be edited
$customer->id = $data->id;
 
// set customer property values
$customer->companyname = $data->companyname;
$customer->address = $data->address;
$customer->phonenumber = $data->phonenumber;
$customer->email = $data->email;
$customer->updatedat = date('Y-m-d H:i:s');
 
// update the customer
if($customer->update()){
    echo '{';
        echo '"message": "Customer was updated."';
    echo '}';
}
 
// if unable to update the customer, tell the user
else{
    echo '{';
        echo '"message": "Unable to update customer."';
    echo '}';
}
?>