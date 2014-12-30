<?php
/**
 * @author Therese Demers
 * @file Search.php
 * @version 05-Dec-12
 */
 
require_once "includes/Database.php";
require_once "includes/categories.php";

/**Class Search instantiates an object that interacts with the database to perform
 *   searches.
 */
class Search {

    private $db;

    /**Class constructor. Instantiates a new Database object for searching.
     */
    function Search() {
        $this->db = new Database();
    }

	 /**Task: searches the database and retrieves all recipes that containing the
     *  ingredients as the search criteria.
     * @param String $ingredients the list of ingredients to search recipes for
     * @return the rows containing the search results as an indexed array
     */
    function searchByIngredients($ingredients) {

        $results = array();
		$recipeIds = array();
		
		if($ingredients != ''){
			//The following is to get rid of any commas or spaces in string
			$ingredString1 = explode(',', $ingredients);
			$ingredString2 = explode(" ", $ingredients);
			
			//If the user entered a comma seperated list
			for ($i = 0; $i < count($ingredString1);$i++) {
				$tbl = 'Ingredients';
				$fields = 'recipeID';
				$rule = "name LIKE '%".$ingredString1[$i]."%'";
				$set = $this->db->select($tbl,$fields,$rule);
				while ($row = mysqli_fetch_assoc($set)) {
					$recipeIds[] = $row;
				}				
			}
		
			//If the user entered a space seperated list
			for ($i = 0; $i < count($ingredString2);$i++) {
				$tbl = 'Ingredients';
				$fields = 'recipeID';
				$rule = "name LIKE '%".$ingredString2[$i]."%'";
				$set = $this->db->select($tbl,$fields,$rule);
				while ($row = mysqli_fetch_assoc($set)) {
					if(in_array($row,$recipeIds)){	
						continue;
					}
					else{
						$recipeIds[] = $row;
					}
				}	
			}
		
			//Because I don't know how to do joins
			for($i = 0; $i < count($recipeIds); $i++){
				$recId = $recipeIds[$i];
				$tbl = 'Recipe';
				$fields = 'ID,description,approxTime,name,userID';
				$rule = "ID = ".$recId['recipeID'];
				$set = $this->db->select($tbl,$fields,$rule);
				while ($row = mysqli_fetch_assoc($set)) {
					$results[] = $row;
				}
			}
        }
        return $results;
    }

    /**Task: searches the database and retrieves all recipes that containing the
     *   search criteria as part of its name.
     * @param String $name the recipe name to search for
     * @return the rows containing the search results as an indexed array
     */
    function searchByName($name) {
        $results = array();

        if ($name != '') {
            $tbl = 'Recipe';
            $fields = 'ID,description,approxTime,name,userID';
            $rule = "name LIKE '%".$name."%'";
            $set = $this->db->select($tbl,$fields,$rule);

            while ($row = mysqli_fetch_assoc($set)) {
                $results[] = $row;
            }
        }

        return $results;
    }
   

    /**Task: searches the database and retrieves recipes belonging the caller
     *   defined recipe category. The results are divided into 5-recipe pages.
     * @param String $name the recipe category to search for
     * @return the rows containing the search results as an indexed array
     */
    function searchByCategory($name) {
        $results = array();
		if($name == 'course' || $name == 'cuisine' || $name == 'lifestyle' || $name == 'season'){
			$categories = getSubCat();
			$catLabels = getCatLabels();
			$subcats = $categories[$name];
			$numCats = count($subcats);
			for($i = 0; $i < $numCats; $i++){
				$searchCatName = $catLabels[$subcats[$i]]; #to capitalize the categories
				$tbl = 'Recipe';
				$fields = 'ID,description,approxTime,name,userID';
				$rule = ($searchCatName == 'all') ? '1' : "category LIKE '%".$searchCatName."%'";
				$set = $this->db->select($tbl,$fields,$rule);
				while ($row = mysqli_fetch_assoc($set)) {
					$results[] = $row;
				}
			}
		}
		
        else if ($name != '') {
            $tbl = 'Recipe';
            $fields = 'ID,description,approxTime,name,userID';
            $rule = ($name == 'all') ? '1' : "category LIKE '%".$name."%'";
            $set = $this->db->select($tbl,$fields,$rule);
            while ($row = mysqli_fetch_assoc($set)) {
                $results[] = $row;
            }
        }

        return $results;
    }
}
?>
