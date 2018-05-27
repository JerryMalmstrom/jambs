<?php 

    // include database and object files
    include_once '../config/database.php';
    include_once '../objects/user.php';

    // instantiate database and user object
    $database = new Database();
    $db = $database->getConnection();
    
    // initialize object
    $user = new User($db);

    switch($_SERVER["REQUEST_METHOD"]) {
        case "GET":
        $result = $user->getAll(array(
            "id" => $_GET["id"],
            "firstname" => $_GET["firstname"],
            "lastname" => $_GET["lastname"],
            "email" => $_GET["email"]
        ));
        break;
        case "POST":
        $result = $user->insert(array(
            "username" => $_POST["username"],
            "firstname" => $_POST["firstname"],
            "lastname" => $_POST["lastname"],
            "phonenumber" => $_POST["phonenumber"],
            "email" => $_POST["email"],
            "roles" => $_POST["roles"]
        ));
        break;
        case "PUT":
        parse_str(file_get_contents("php://input"), $_PUT);
        $result = $user->update(array(
            "id" => intval($_PUT["id"]),
            "username" => $_PUT["username"],
            "firstname" => $_PUT["firstname"],
            "lastname" => $_PUT["lastname"],
            "phonenumber" => $_PUT["phonenumber"],
            "email" => $_PUT["lastname"],
            "roles" => $_PUT["roles"]
        ));
        break;
        case "DELETE":
            parse_str(file_get_contents("php://input"), $_DELETE);
            $result = $user->remove(intval($_DELETE["id"]));
            break;
    }
    
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    header('Access-Control-Allow-Methods: *');

    echo json_encode($result);

?>