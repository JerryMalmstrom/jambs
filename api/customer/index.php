<?php 

    // include database and object files
    include_once '../config/database.php';
    include_once '../objects/customer.php';

    // instantiate database and customer object
    $database = new Database();
    $db = $database->getConnection();
    
    // initialize object
    $customer = new Customer($db);

    switch($_SERVER["REQUEST_METHOD"]) {
        case "GET":
        $result = $customer->getAll(array(
            "id" => $_GET["id"],
            "companyname" => $_GET["companyname"],
            "address" => $_GET["address"]
        ));
        break;
    }
    
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

    echo json_encode($result);

?>