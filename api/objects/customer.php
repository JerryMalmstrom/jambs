<?php
class Customer{
 
    // database connection and table name
    private $conn;
    private $table_name = "customers";
 
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
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read customers
    function read(){
    
        // select all query
        $query = "SELECT
                    id, companyname, address, phonenumber, email, createdat, createdby, updatedat, updatedby
                FROM
                    " . $this->table_name . "
                ORDER BY
                    createdat DESC";
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // execute query
        $stmt->execute();
    
        return $stmt;
    }

    // create customer
    function create(){
    
        // query to insert record
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    companyname=:companyname, address=:address, phonenumber=:phonenumber, email=:email";
    
        // prepare query
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->companyname=htmlspecialchars(strip_tags($this->companyname));
        $this->address=htmlspecialchars(strip_tags($this->address));
        $this->phonenumber=htmlspecialchars(strip_tags($this->phonenumber));
        $this->email=htmlspecialchars(strip_tags($this->email));
    
        // bind values
        $stmt->bindParam(":companyname", $this->companyname);
        $stmt->bindParam(":address", $this->address);
        $stmt->bindParam(":phonenumber", $this->phonenumber);
        $stmt->bindParam(":email", $this->email);

        // execute query
        if($stmt->execute()){
            return true;
        }
    
        return false;
        
    }

    // used when filling up the update customer form
    function readOne(){
    
        // query to read single record
        $query = "SELECT
                    id, companyname, address, phonenumber, email, createdat, createdby, updatedat, updatedby
                FROM
                    " . $this->table_name . " 
                WHERE
                    id = ?
                LIMIT
                    0,1";
    
        // prepare query statement
        $stmt = $this->conn->prepare( $query );
    
        // bind id of customer to be updated
        $stmt->bindParam(1, $this->id);
    
        // execute query
        $stmt->execute();
    
        // get retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
        // set values to object properties
        $this->companyname = $row['companyname'];
        $this->address = $row['address'];
        $this->phonenumber = $row['phonenumber'];
        $this->email = $row['email'];
        $this->createdat = $row['createdat'];
        $this->createdby = $row['createdby'];
        $this->updatedat = $row['updatedat'];
        $this->updatedby = $row['updatedby'];
    }

    // update the customer
    function update(){
    
        // update query
        $query = "UPDATE
                    " . $this->table_name . "
                SET
                    companyname=:companyname, address=:address, phonenumber=:phonenumber, email=:email
                WHERE
                    id = :id";
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->companyname=htmlspecialchars(strip_tags($this->companyname));
        $this->address=htmlspecialchars(strip_tags($this->address));
        $this->phonenumber=htmlspecialchars(strip_tags($this->phonenumber));
        $this->email=htmlspecialchars(strip_tags($this->email));
        $this->id=htmlspecialchars(strip_tags($this->id));
    
        // bind new values
        $stmt->bindParam(':companyname', $this->companyname);
        $stmt->bindParam(':address', $this->address);
        $stmt->bindParam(':phonenumber', $this->phonenumber);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':id', $this->id);
    
        // execute the query
        if($stmt->execute()){
            return true;
        }
    
        return false;
    }

    // delete the customer
    function delete(){
    
        // delete query
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
    
        // prepare query
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->id=htmlspecialchars(strip_tags($this->id));
    
        // bind id of record to delete
        $stmt->bindParam(1, $this->id);
    
        // execute query
        if($stmt->execute()){
            return true;
        }
    
        return false;
        
    }

    // search customers
    function search($keywords){
    
        // select all query
        $query = "SELECT
                   id, companyname, address, phonenumber, email, createdat, createdby, updatedat, updatedby
                FROM
                    " . $this->table_name . "
                WHERE
                    companyname LIKE ? OR address LIKE ? OR email LIKE ?
                ORDER BY
                    createdat DESC";
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $keywords=htmlspecialchars(strip_tags($keywords));
        $keywords = "%{$keywords}%";
    
        // bind
        $stmt->bindParam(1, $keywords);
        $stmt->bindParam(2, $keywords);
        $stmt->bindParam(3, $keywords);
    
        // execute query
        $stmt->execute();
    
        return $stmt;
    }

    // read customers with pagination
    public function readPaging($from_record_num, $records_per_page){
    
        // select query
        $query = "SELECT
                    id, companyname, address, phonenumber, email, createdat, createdby, updatedat, updatedby
                FROM
                    " . $this->table_name . "
                ORDER BY p.created DESC
                LIMIT ?, ?";
    
        // prepare query statement
        $stmt = $this->conn->prepare( $query );
    
        // bind variable values
        $stmt->bindParam(1, $from_record_num, PDO::PARAM_INT);
        $stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);
    
        // execute querys
        $stmt->execute();
    
        // return values from database
        return $stmt;
    }

    // used for paging products
    public function count(){
        $query = "SELECT COUNT(*) as total_rows FROM " . $this->table_name . "";
    
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
        return $row['total_rows'];
    }
}