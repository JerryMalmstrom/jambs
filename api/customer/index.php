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
            "address" => $_GET["address"],
            "email" => $_GET["email"],
        ));
        break;
        case "POST":
        $result = $customer->insert(array(
            "companyname" => $_POST["companyname"],
            "address" => $_POST["address"],
            "email" => $_POST["email"],
            "phonenumber" => $_POST["phonenumber"],
            "createdby" => intval($_POST["createdby"])
        ));
        break;
        case "PUT":
        parse_str(file_get_contents("php://input"), $_PUT);
        $result = $customer->update(array(
            "id" => intval($_PUT["id"]),
            "companyname" => $_PUT["companyname"],
            "address" => $_PUT["address"],
            "email" => $_PUT["address"],
            "phonenumber" => $_PUT["phonenumber"],
            "updatedby" => intval($_PUT["updatedby"])
        ));
        break;
        case "DELETE":
            parse_str(file_get_contents("php://input"), $_DELETE);
            $result = $customer->remove(intval($_DELETE["id"]));
            break;
    }
    
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    header('Access-Control-Allow-Methods: *');

    echo json_encode($result);

?>