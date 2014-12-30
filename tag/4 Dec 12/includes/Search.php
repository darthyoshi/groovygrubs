<?php
/**
 * Author: Therese Demers
 * File: Search.php
 */
require_once "includes/Database.php";

class Search {

    private $db;

	function Search(){
			$this->db = new Database();
	}


    /**function recipeFromIngredients($ingredients){

        $result = array();

        for($i = 0; $i < count($ingredients);$i++){

                $targets = '';
                for($j = 0; $j <= $i; $j++ ){
                    $targets .= "name LIKE ".$ingredients[$j].' AND';
                }

                $table = 'Ingredients JOIN Recipe ON (Ingredients.recipeID = Recipe.ID)';
                $fields = '*';
                $rule = $targets;

                $rset = $db->select($table,$fields,$rule);
                $db->fetch_assoc($rset);
       }


    }**/

    function searchByName($name){
	  $results = array();
	  if($name != ''){
			$tbl = 'Recipe';
			$fields = 'ID,'
                .'description,'
                .'approxTime,'
                .'name,'
                .'userID';
			$rule = "name LIKE '%".$name."%'";
			$set = $this->db->select($tbl,$fields,$rule);
            while ($row = mysqli_fetch_assoc($set)){
                $results[] = $row;
			}
		}
		return $results;
	}

	function searchForImage($recID){
	  if($recID != ''){
		$picture = $this->db->select("Picture","Image","recipeID='".$recID."'");
		$row = mysqli_fetch_assoc($picture);
	  }
	  return $row;
        }	
        
        function searchForRating($recID){
	  if($recID != ''){
		$rating = $this->db->select("Ratings","*","recipeID='".$recID."'");
		$row = mysqli_fetch_assoc($rating);
	  }
	  return $row;
        }

	function searchByCategory($name){
	  $results = array();
	  if($name != ''){
			$tbl = 'Recipe';
			$fields = 'ID,'
                .'description,'
                .'approxTime,'
                .'name,'
                .'userID';
			$rule = ($name!='all')?
                "category LIKE '%".$name."%'":
                '1';
			$set = $this->db->select($tbl,$fields,$rule);
            while ($row = mysqli_fetch_assoc($set)){
                $results[] = $row;
			}
		}
		return $results;
	}
}
?>
