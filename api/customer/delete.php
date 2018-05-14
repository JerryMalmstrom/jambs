<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
 
// include database and object file
include_once '../config/database.php';
include_once '../objects/customer.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare customer object
$customer = new Customer($db);
 
// get customer id
$data = json_decode(file_get_contents("php://input"));
 
// set customer id to be deleted
$customer->id = $data->id;
 
// delete the customer
if($customer->delete()){
    echo '{';
        echo '"message": "Customer was deleted."';
    echo '}';
}
 
// if unable to delete the customer
else{
    echo '{';
        echo '"message": "Unable to delete object."';
    echo '}';
}
?>