<?php

/**
 * @author Ian Pitts
 * @file Database.php
 * @version: 05-Dec-12
 */

/**Class Database instantiates an object representing a connection to the deployment
 *   database. Database objects provide getter and setter functions that allow the
 *   caller to interact with the server database.
 */
class Database
{
    private $dbLink;
    private $host = 'sfsuswe.com';
    private $user = 'f12g06';
    private $password = 'swef2012db';
    private $database = 'student_f12g06';

    /**Class constructor. Creates a new Database object and opens a connection to
     *   the database.
     */
    function Database() {
        $this->dbLink = new mysqli($this->host, $this->user, $this->password, $this->database);
        if (mysqli_connect_errno()) {
            echo "Failed to connect to MySql Database " . $this->dbLink->connect_error;
        }
    }

    /**Task: generates a unique ID number.
     * @return an ID number as a bigint
     */
    function newID() {
        $part1  = time()*1000;
        $part2  = rand(0, 9999);
        return $part1 . $part2;
    }

    /**Task: creates a new row in a database table with caller defined values.
     * @param String $table the name of the table to modify
     * @param String $fields the name(s) of the columns in the table
     * @param String $values the data to be entered into each column
     * @return TRUE if successful
     */
    function insert($table,$fields,$values) {

        $fields = implode(" , ", $fields);
        $values = implode("' , '", $values);
        $values = "'".$values."'";
        $query = 'INSERT INTO '.$table.' ('.$fields.') VALUES ('.$values.');';
        $this->dbLink->query($query);
        if ($this->dbLink->error) {
            echo ("ERROR ".$this->dbLink->error);
            return false;
        }
        else {
            return TRUE;
        }
    }

    /**Task: modifies data in database table rows that match caller defined criteria.
     * @param String $table the name of the table to modify
     * @param String $fields the name(s) of the column to modify
     * @param String $rule the criteria
     * @return TRUE if successful
     */
    function update($table,$fields,$rule='') {

        $query = "UPDATE ".$table." SET ".$fields;
        if (!empty($rule))
            $query .= " WHERE ".$rule;
        $this->dbLink->query($query);
        if ($this->dbLink->error) {
            echo ("ERROR ".$this->dbLink->error);
            return false;
        }else{
           return TRUE;
        }
    }

    /**Task: retrieves rows from a database table that match caller defined criteria.
     *   The rows can be grouped or order using MySQL rules.
     * @param String $table the name of the table to search
     * @param String $fields the name(s) of the columns to retrieve
     * @param String $rule the search criteria
     * @param String $group the column to group the results by
     * @param String $order the rule for ordering the search results
     * @return a mysqli_result table containing the search results
     * @return FALSE if the search encounters an error
     */
    function select($table,$fields,$rule,$group='',$order='') {
        $query = " SELECT ".$fields." FROM ".$table;
        (empty($rule)) ? (" WHERE 1") : $query .= " WHERE ".$rule;

        if (!empty($group))
            $query .= " GROUP BY ".$group;

        if (!empty($order))
            $query .= " ORDER BY ".$order;

        $query .= ';';
        $handle = $this->dbLink->query($query);

        if ($this->dbLink->error) {
            echo ("ERROR ".$this->dbLink->error);
            return false;
        }
        else {
            return $handle;
        }
    }

    /**Task: removes rows from a database table.
     * @param String $table the name of the table to modify
     * @param String $rule the criteria for removing rows
     * @return TRUE if successful
     */
    function delete($table,$rule='') {

        if (!empty($table) && !empty($rule)) {
            $query  = 'DELETE FROM '.$table.' WHERE '.$rule;
            $this->dbLink->query($query);

            if ($this->dbLink->error) {
                echo ("ERROR ".$this->dbLink->error);
          	  	return false;
        	}
        	else {
          	  	return TRUE;
        	}
        }
    }

    /**Task: creates a virtual table (view) in the database containing data
     *   retrieved from existing tables.
     * @param String $name the name of the view to be created
     * @param String $table the name(s) of the tables to search through
     * @param String $fields the name(s) of the columns to retrieve
     * @param String $rule the search criteria
     * @return TRUE if successful
     */
    function createView($name,$table,$fields,$rule) {
        $query = 'CREATE VIEW '.$name.' AS SELECT '.$fields.' FROM '.$table.'WHERE '.$rule;
        $this->dbLink->query($query);

        if ($this->dbLink->error) {
            echo ("ERROR ".$this->dbLink->error);
            return false;
        }
        else {
            return TRUE;
        }
    }

    /**Task: adds an image and accompanying data into the database.
     * @param bigint $ID the ID number of the image
     * @param String $recipeID the ID number of the recipe associated with the image
     * @param String $name the filename of the image
     * @param String $image the image, in hexadecimal format
     * @param String $fileSize the size of the image
     * @return TRUE if successful
     */
    function insertImage($ID,$recipeID,$name,$image,$fileSize) {
        $query = 'INSERT INTO Picture (`ID`,`recipeID`,`name`,`image`,`fileSize`) VALUES ("'
            .$ID.'","'.$recipeID.'","'.(addslashes($name)).'","'.addslashes($image).'","'.$fileSize.'")';
        $this->dbLink->query($query);

        if ($this->dbLink->error) {
            echo ("ERROR ".$this->dbLink->error);
            return false;
        }
        else {
           return TRUE;
        }
    }

    /**Task: retrieves an image and accompanying data from the database.
     * @param bigint $ID the ID number of the recipe associated the image is associated with
     * @return the row containing the desired image as an associative array
     */
    function getImage($ID) {
        return $this->select('Picture','*', 'recipeID="'.$ID.'"')->fetch_assoc();
    }

    /**Task: retrieves the average rating of a particular recipe.
     * @param bigint $ID the ID number of the desired recipe
     * @return floating point number [1, 5]
     * @return FALSE if an error is encountered
     */
    function getRating($ID) {
        $query = 'SELECT AVG(rating) as ratings FROM Ratings WHERE recipeID="'.$ID.'"';
        $result = $this->dbLink->query($query);
        if ($result != null)
            $ratings = mysqli_fetch_assoc($result);
        else
            return null;

        if ($this->dbLink->error) {
            return false;
        }
        else{
            return $ratings['ratings'];
        }
    }

    /**Task: retrieves the average rating of a particular recipe.
     * @param bigint $ID the ID number of the desired recipe
     * @return floating point number [1, 5]
     * @return FALSE if an error is encountered
     */
    function addRating($recipeID,$userID,$rating){
        $fields = array('ID','recipeID','raterID','rating');
        $values = array($this->newID(),$recipeID,$userID,$rating);
        $check = $this->select('Ratings','ID','recipeID='.$recipeID.' AND raterID='.$userID);

        if (mysqli_num_rows($check) == 0) {
            $this->insert('Ratings',$fields,$values);
            return $this->getRating($recipeID);
        }
        else if (mysqli_num_rows($check) == 1) {
            $this->update('Ratings','rating='.$rating,'recipeID='.$recipeID.' AND raterID='.$userID);
            return $this->getRating($recipeID);
        }
        else if ($this->dbLink->error) {
            return false;
        }
    }

}
?>
