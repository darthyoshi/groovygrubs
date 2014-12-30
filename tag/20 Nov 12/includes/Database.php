<?php

/**
 * Author: Ian Pitts
 * File: Database.php
 * Purpose: defines the Database class and its methods
 */

class Database
{
    private $dbLink;
    private $host = 'sfsuswe.com';
    private $user = 'f12g06';
    private $password = 'swef2012db';
    private $database = 'student_f12g06';

	function Database(){
		$this->connect();
	}

    function connect(){
        $this->dbLink = new mysqli($this->host, $this->user, $this->password, $this->database);
        if(mysqli_connect_errno()){
            echo "Failed to connect to MySql Database " . $this->dbLink->connect_error;
        }
    }

    function newID(){
        $part1  = time()*1000;
        $part2  = rand(0, 9999);
		
        return $part1 . $part2;
    }

    function insert($table,$fields,$values){

        $fields = implode(" , ", $fields);
        $values = implode("' , '", $values);
		//	echo $values."<br>";
		$values = "'".$values."'";
        $query = 'INSERT INTO '.$table.' ('.$fields.') VALUES ('.$values.')';
        mysqli_query($this->dbLink,$query);
        if($this->dbLink->error){
            printf("ERROR ".$this->dbLink->error);
            return false;
        }else{
           return TRUE;
        }
    }

    function update($table,$fields,$rule=''){

        $query = "UPDATE ".$table." SET ".$fields;
        if(!empty($rule))
            $query .= " WHERE ".$rule;
        $this->dbLink->query($query);

        if($this->dbLink->error){
            printf("ERROR ".$this->dbLink->error);
            return false;
        }else{
           return TRUE;
        }
    }

    function select($table,$fields,$rule,$group='',$order=''){

        $query = " SELECT ".$fields." FROM ".$table;

        (empty($rule)) ? (" WHERE 1") : $query .= " WHERE ".$rule;
        if(!empty($group)) $query .= " GROUP BY".$group;
        if(!empty($order)) $query .= " ORDER BY".$order;

		$handle = mysqli_query($this->dbLink,$query);

        if($this->dbLink->error){
            printf("ERROR ".$this->dbLink->error);
            return false;
        }
        else {
            return $handle;
        }
    }

    function delete($table,$rule=''){

        $query  = 'DELETE FROM '.$table.' WHERE '.$rule;
        $this->dbLink->query($query);

        if($this->dbLink->error){
            printf("ERROR ".$this->dbLink->error);
            return false;
        }
        else {
            return TRUE;
        }
    }

    function createView($name,$table,$fields,$rule){

        $query = 'CREATE VIEW '.$name.' AS SELECT '.$fields.' FROM '.$table.'WHERE '.$rule;
        $this->dbLink->query($query);

        if($this->dbLink->error){
            printf("ERROR ".$this->dbLink->error);
            return false;
        }
        else {
            return TRUE;
        }
    }
}
?>
