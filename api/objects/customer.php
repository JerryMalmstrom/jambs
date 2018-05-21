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
}