<?php

class Search {

    private $db;
    
    function recipeFromIngredients($ingredients){
        
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
    
       
    }

    
    
    function searchForRecipe($name){
       
        
        
    }
    
    
    
}
?>
