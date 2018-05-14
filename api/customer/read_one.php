<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/customer.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare customer object
$customer = new Customer($db);
 
// set ID property of customer to be edited
$customer->id = isset($_GET['id']) ? $_GET['id'] : die();
 
// read the details of customer to be edited
$customer->readOne();
 
// create array
$customer_arr = array(
    "id" =>  $customer->id,
    "companyname" => $customer->companyname,
    "address" => $customer->address,
    "phonenumber" => $customer->phonenumber,
    "email" => $customer->email,
    "createdat" => $customer->createdat,
    "createdby" => $customer->createdby,
    "updatedat" => $customer->updatedat,
    "updatedby" => $customer->updatedby
 
);
 
// make it json format
print_r(json_encode($customer_arr));
?>