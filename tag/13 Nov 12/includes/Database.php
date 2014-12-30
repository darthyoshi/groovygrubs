<?php
class Database  
{
    private $dbLink;
    private $host = 'sfsuswe.com';
    private $user = 'f12g06';
    private $password = 'swef2012db'; 
    private $database = 'student_f12g06';
    
    
    function connect(){
        $this->dbLink = new mysqli($this->host, $this->user, $this->password, $this->database);
        if(mysqli_connect_errno()){
            echo "Failed to connect to MySql Database " . $this->dbLink->connect_error;
        }
    }
    
    public function __clone() {
        trigger_error('Clone is not allowed.', E_USER_ERROR);
    }

    public function __wakeup() {
        trigger_error('Deserializing is not allowed.', E_USER_ERROR);
    }
    
    function newID(){
        $part1  = time()*1000;
        $part2  = rand(0, 9999);
        return ((int)($part1.$part2));
    }
    
    
    function insert($table,$fields,$values){
        
        $fields = implode(' , ', $fields);
        $query = 'INSERT INTO'.$table.' ('.$fields.') VALUES ('.$values.')'; 
        
        //$this->dbLink->escape_string($query);
        
        $this->dbLink->query($query);
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
        
        //$query = $this->dbLink->escape_string($query);
        
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
        
        $query = $this->dbLink->escape_string($query);
        
        $handle = $this->dbLink->query($query);
        
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
        
        //$this->dbLink->escape_string($query);
        
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
        
        //$this->dbLink->escape_string($query);
        
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
