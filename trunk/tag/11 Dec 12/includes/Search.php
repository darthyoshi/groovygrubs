<?php
/**
 * @author Therese Demers
 * @file Search.php
 * @version 05-Dec-12
 */
require_once "includes/Database.php";

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


    function recipeFromIngredients($ingredients) {

        $results = array();

        for($i = 0; $i < count($ingredients);$i++) {
                if($i == count($ingredients)-1)
                    $targets .= "name LIKE ".$ingredients[$i];
                else
                    $targets .= "name LIKE ".$ingredients[$i]." AND";
        }

        $table = 'Ingredients JOIN Recipe ON (Ingredients.recipeID = Recipe.ID)';
        $fields = '*';
        $rule = $targets;

        $row = $this->db->select($table,$fields,$rule)->fetch_assoc();
        $results[] = $row;

        return $results;

    }

    /**Task: searches the database and retrieves all recipes that containing the
     *   search criteria as part of its name.
     * @param String $name the recipe name to search for
     * @return the rows containing the search results as an indexed array
     */
    function searchByName($name) {
        $results = array();

        if($name != '') {
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
     * @param int $page the page number to retrieve
     * @return the rows containing the search results as an indexed array
     */
    function searchByCategory($name,$page='') {
        $results = array();

        if($name != '') {
            $tbl = 'Recipe';
            $fields = 'ID,description,approxTime,name,userID';
            $rule = ($name == 'all') ? '1' : "category LIKE '%".$name."%'";
            if ($page != '')
                $limit = 'LIMIT '. 5*($page-1). ',5';
            $set = $this->db->select($tbl,$fields,$rule.$limit);
            while ($row = mysqli_fetch_assoc($set)) {
                $results[] = $row;
            }
        }

        return $results;
    }
}
?>
