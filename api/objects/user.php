<?php

class UserObject{
    // object properties
    public $id;
    public $username;
    public $firstname;
    public $lastname;
    public $phonenumber;
    public $email;
    public $roles;
    public $createdat;
    public $lastlogin;
}

class User{
 
    // database connection and table name
    private $db;
    private $table_name = "users";
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->db = $db;
    }

    private function read($row){
        $result = new UserObject();
        $result->id = $row["id"];
        $result->username = $row["username"];
        $result->firstname = $row["firstname"];
        $result->lastname = $row["lastname"];
        $result->phonenumber = $row["phonenumber"];
        $result->email = $row["email"];
        $result->roles = $row["roles"];
        $result->createdat = $row["createdat"];
        $result->lastlogin = $row["lastlogin"];
        return $result;
    }

    public function getById($id) {
        $sql = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
        $q = $this->db->prepare($sql);
        $q->bindParam(":id", $id, PDO::PARAM_INT);
        $q->execute();
        $rows = $q->fetchAll();
        return $this->read($rows[0]);
    }

    public function getAll($filter) {
        $firstname = "%" . $filter["firstname"] . "%";
        $lastname = "%" . $filter["lastname"] . "%";
        $email = "%" . $filter["email"] . "%";
        $sql = "SELECT * FROM " . $this->table_name . " WHERE firstname LIKE :firstname AND lastname LIKE :lastname AND email LIKE :email";
        //$sql = "SELECT c.id, c.firstname, c.lastname, c.email, c.phonenumber, c.companyid, u.companyname AS company, c.createdby, c.createdat, c.updatedby, c.updatedat FROM " . $this->table_name . " c JOIN customers u ON u.id = c.companyid WHERE c.firstname LIKE :firstname AND c.lastname LIKE :lastname AND c.email LIKE :email";
        $q = $this->db->prepare($sql);
        $q->bindParam(":firstname", $firstname);
        $q->bindParam(":lastname", $lastname);
        $q->bindParam(":email", $email);
        $q->execute();
        $rows = $q->fetchAll();
        $result = array();
        foreach($rows as $row) {
            array_push($result, $this->read($row));
        }
        return $result;
    }

    public function insert($data) {
        $sql = "INSERT INTO " . $this->table_name . " (username, firstname, lastname, phonenumber, email, roles) VALUES (:username, :firstname, :lastname, :phonenumber, :email, :roles)";
        $q = $this->db->prepare($sql);
        $q->bindParam(":username", $data["username"]);
        $q->bindParam(":firstname", $data["firstname"]);
        $q->bindParam(":lastname", $data["lastname"]);
        $q->bindParam(":phonenumber", $data["phonenumber"]);
        $q->bindParam(":email", $data["email"]);
        $q->bindParam(":roles", $data["roles"]);
        $q->execute();
        return $this->getById($this->db->lastInsertId());
    }

    public function update($data) {
        $sql = "UPDATE " . $this->table_name . " SET username = :username, firstname = :firstname, lastname = :lastname, phonenumber = :phonenumber, email = :email, roles = :roles WHERE id = :id";
        $q = $this->db->prepare($sql);
        $q->bindParam(":username", $data["username"]);
        $q->bindParam(":firstname", $data["firstname"]);
        $q->bindParam(":lastname", $data["lastname"]);
        $q->bindParam(":phonenumber", $data["phonenumber"]);
        $q->bindParam(":email", $data["email"]);
        $q->bindParam(":roles", $data["roles"]);
        $q->bindParam(":id", $data["id"], PDO::PARAM_INT);
        $q->execute();
    }

    public function remove($id) {
        $sql = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $q = $this->db->prepare($sql);
        $q->bindParam(":id", $id, PDO::PARAM_INT);
        $q->execute();
    }

}