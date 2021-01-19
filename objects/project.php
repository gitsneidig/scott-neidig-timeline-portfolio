<?php
class Project{
 
    // database connection and table name
    private $conn;
    private $table_name = "projects";
 
    // object properties/model
    public $project_id;
    public $headline;
    public $text;
    public $tag;
    public $asset;
    public $start_date;
    public $end_date;
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

// read products
function read(){
 
    // select all query
    $query = "SELECT
                p.headline, p.text, p.tag, p.asset, p.start_date, p.end_date
            FROM
                " . $this->table_name . " p 
            ORDER BY
                p.start_date DESC";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // execute query
    $stmt->execute();
 
    return $stmt;
}

// create project
function create(){
 
    // query to insert record
    $query = "INSERT INTO
                " . $this->table_name . "
            SET
               headline=:headline, text=:text, tag=:tag, asset=:asset, start_date=:start_date, end_date=:end_date";
 
    // prepare query
    $stmt = $this->conn->prepare($query);
 

    // bind values
    $stmt->bindParam(":headline", $this->headline);
    $stmt->bindParam(":text", $this->text);
    $stmt->bindParam(":tag", $this->tag);
    $stmt->bindParam(":asset", $this->asset);
    $stmt->bindParam(":start_date", $this->start_date);
    $stmt->bindParam(":end_date", $this->end_date);
 
    // execute query
    if($stmt->execute()){
        return true;
    }else{
        return false;
    }
}


}
