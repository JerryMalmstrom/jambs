<?php 

    // include database and object files
    include_once '../config/database.php';
    include_once '../objects/contact.php';

    // instantiate database and contact object
    $database = new Database();
    $db = $database->getConnection();
    
    // initialize object
    $contact = new contact($db);

    switch($_SERVER["REQUEST_METHOD"]) {
        case "GET":
        $result = $contact->getAll(array(
            "id" => $_GET["id"],
            "firstname" => $_GET["firstname"],
            "lastname" => $_GET["lastname"],
            "email" => $_GET["email"],
        ));
        break;
        case "POST":
        $result = $contact->insert(array(
            "firstname" => $_POST["firstname"],
            "lastname" => $_POST["lastname"],
            "email" => $_POST["email"],
            "phonenumber" => $_POST["phonenumber"],
            "companyid" => intval($_POST["companyid"]),
            "createdby" => intval($_POST["createdby"])
        ));
        break;
        case "PUT":
        parse_str(file_get_contents("php://input"), $_PUT);
        $result = $contact->update(array(
            "id" => intval($_PUT["id"]),
            "firstname" => $_PUT["firstname"],
            "lastname" => $_PUT["lastname"],
            "email" => $_PUT["lastname"],
            "phonenumber" => $_PUT["phonenumber"],
            "companyid" => intval($_PUT["companyid"]),
            "updatedby" => intval($_PUT["updatedby"])
        ));
        break;
        case "DELETE":
            parse_str(file_get_contents("php://input"), $_DELETE);
            $result = $contact->remove(intval($_DELETE["id"]));
            break;
    }
    
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    header('Access-Control-Allow-Methods: *');

    echo json_encode($result);

?>