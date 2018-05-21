<?php

class CustomerObject{
    // object properties
    public $id;
    public $companyname;
    public $address;
    public $phonenumber;
    public $email;
    public $createdat;
    public $createdby;
    public $updatedat;
    public $updatedby;
}

class Customer{
 
    // database connection and table name
    private $db;
    private $table_name = "customers";
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->db = $db;
    }

    private function read($row){
        $result = new CustomerObject();
        $result->id = $row["id"];
        $result->companyname = $row["companyname"];
        $result->address = $row["address"];
        $result->phonenumber = $row["phonenumber"];
        $result->email = $row["email"];
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
        $companyname = "%" . $filter["companyname"] . "%";
        $address = "%" . $filter["address"] . "%";
        $email = "%" . $filter["email"] . "%";
        $sql = "SELECT * FROM " . $this->table_name . " WHERE companyname LIKE :companyname AND address LIKE :address AND email LIKE :email";
        $q = $this->db->prepare($sql);
        $q->bindParam(":companyname", $companyname);
        $q->bindParam(":address", $address);
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
        $sql = "INSERT INTO " . $this->table_name . " (companyname, address, email, phonenumber, createdby) VALUES (:companyname, :address, :email, :phonenumber, :createdby)";
        $q = $this->db->prepare($sql);
        $q->bindParam(":companyname", $data["companyname"]);
        $q->bindParam(":address", $data["address"]);
        $q->bindParam(":email", $data["email"]);
        $q->bindParam(":phonenumber", $data["phonenumber"]);
        $q->bindParam(":createdby", $data["createdby"], PDO::PARAM_INT);
        $q->execute();
        return $this->getById($this->db->lastInsertId());
    }

    public function update($data) {
        $sql = "UPDATE " . $this->table_name . " SET companyname = :companyname, address = :address, email = :email, phonenumber = :phonenumber, updatedby = :updatedby WHERE id = :id";
        $q = $this->db->prepare($sql);
        $q->bindParam(":companyname", $data["companyname"]);
        $q->bindParam(":address", $data["address"]);
        $q->bindParam(":email", $data["email"]);
        $q->bindParam(":phonenumber", $data["phonenumber"]);
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