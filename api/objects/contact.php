<?php

class ContactObject{
    // object properties
    public $id;
    public $firstname;
    public $lastname;
    public $phonenumber;
    public $email;
    public $companyid;
    public $createdat;
    public $createdby;
    public $updatedat;
    public $updatedby;
}

class Contact{
 
    // database connection and table name
    private $db;
    private $table_name = "contacts";
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->db = $db;
    }

    private function read($row){
        $result = new ContactObject();
        $result->id = $row["id"];
        $result->firstname = $row["firstname"];
        $result->lastname = $row["lastname"];
        $result->phonenumber = $row["phonenumber"];
        $result->email = $row["email"];
        $result->companyid = $row["companyid"];
        $result->createdat = $row["createdat"];
        $result->createdby = $row["createdby"];
        $result->updatedat = $row["updatedat"];
        $result->updatedby = $row["updatedby"];
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
        $sql = "INSERT INTO " . $this->table_name . " (firstname, lastname, email, phonenumber, companyid, createdby) VALUES (:firstname, :lastname, :email, :phonenumber, :createdby)";
        $q = $this->db->prepare($sql);
        $q->bindParam(":firstname", $data["firstname"]);
        $q->bindParam(":lastname", $data["lastname"]);
        $q->bindParam(":email", $data["email"]);
        $q->bindParam(":phonenumber", $data["phonenumber"]);
        $q->bindParam(":companyid", $data["companyid"], PDO::PARAM_INT);
        $q->bindParam(":createdby", $data["createdby"], PDO::PARAM_INT);
        $q->execute();
        return $this->getById($this->db->lastInsertId());
    }

    public function update($data) {
        $sql = "UPDATE " . $this->table_name . " SET firstname = :firstname, lastname = :lastname, email = :email, phonenumber = :phonenumber, companyid = :companyid, updatedby = :updatedby WHERE id = :id";
        $q = $this->db->prepare($sql);
        $q->bindParam(":firstname", $data["firstname"]);
        $q->bindParam(":lastname", $data["lastname"]);
        $q->bindParam(":email", $data["email"]);
        $q->bindParam(":phonenumber", $data["phonenumber"]);
        $q->bindParam(":companyid", $data["companyid"], PDO::PARAM_INT);
        $q->bindParam(":updatedby", $data["updatedby"], PDO::PARAM_INT);
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