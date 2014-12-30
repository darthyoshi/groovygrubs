<?php
/*  @Author :Ian Pitts
 *
 *
 *
 */
require 'Database.php';
$db = new Database();

switch (strtoupper($_GET['ops'])){

    case 'UPLOAD':

            $missingFields = array();

            $pictureID = $db->newID();
            $recipeID = $db->newID();
            $userID = $_POST['UID'];

            #RECIPE INFO
            $recipeTitle = $_POST['recipeTitle'];
            $category = $_POST['category'];
            $description = $_POST['description'];
            $recipeServes = $_POST['recipeServes'];
            $prepTime = $_POST['prepTime'];
            $numIng = $_POST['counter'];
            $instructions = $_POST['instructions'];

            $table = 'Recipe';
            $fields = array('ID','userID','name','uploadDate','difficulty','serves','category','approxTime','pictureID','instructions','description');
            $values = array($recipeID,$userID,$recipeTitle, date('Y-m-d H-i-s'),'3',$recipeServes,$category,$prepTime,$pictureID,addslashes($instructions),$description);

            #checking for missing Fields
            for ($i = 0; $i < count($values); $i++) {
                if (empty($values[$i])) {
                    $missingFields[] = $fields[$i];
                }
            }

            if (count($missingFields) == 0) {
                $db->insert($table, $fields, $values);
            }

            #ingredients
            $fields = array('ID','recipeID','name','quantity','unit');
            for($i = 1; $i <= $numIng; $i++){

                $ingredient = $_POST['ingredient_'.$i];
                $quantity = $_POST['ingredientQuantity_'.$i];
                $unit = $_POST['ingredientUnit_'.$i];

                if (empty($ingredient))
                    $missingFields = 'ingredient_'.$i;
                elseif (empty ($quantity))
                    $missingFields[] = 'ingredientQuantity_'.$i;
                elseif (empty($unit))
                    $missingFields[] = 'ingredientUnit_'.$i;
                else {
                    $values = array($db->newID(),$recipeID,addslashes($ingredient),addslashes($quantity),addslashes($unit));
                    $db->insert('Ingredients',$fields,$values);
                }
            }

            #PIC
            if (isset($_FILES) && empty($missingFields)) {

                $pictureName = $_FILES['picture']['name'];
                $pictureTemp = $_FILES['picture']['tmp_name'];
                $fileSize = $_FILES['picture']['size'];

                $handle = fopen($pictureTemp, 'r');
                $contents = fread($handle, $fileSize);
                fclose($handle);

                $db->insertImage($pictureID,$recipeID,$pictureName,$contents,$fileSize);
            }

            if (!headers_sent() && empty($missingFields)) {
                $URL = 'Location:http://sfsuswe.com/~ipitts/recipe.php?id='.$recipeID;
                header($URL);
            }
    break;

    case 'RATE':

        $recipeID      = $_POST['RID'];
        $userID        = $_POST['UID'];
        $rating        = $_POST['rating'];
        
        if($rating > 5 OR $rating < 0){
            echo 'Please Enter a number between 1 and 5';
        }elseif (!empty($rating)) {
            $result = $db->addRating($recipeID, $userID, $rating);
            echo $rating;
        }else{
            echo 'Please Enter a Number.';
        }
    break;

    case 'ADDFAV':
        
        $UID = $_POST['UID'];
        $RID = $_POST['RID'];
        
        if(!empty($RID) && !empty($UID))
            $result = $db->select("Favorites","*","userID='".$UID."' AND recipeID='".$RID."'");
        
        if (mysqli_num_rows($result) > 0){
            echo 'You have already added this recipe to your favorites.';
        }else {
            $fields = array('userID','recipeID','addDate');
            $values = array($UID,$RID,date("Y-m-d H:i:s"));
            if ($db->insert("Favorites",$fields,$values) === TRUE){
                echo 'Successfully added to your favorites.';
            }
            else{
                echo 'Was not added to your favorites.';
            }
        }
    break;

    case 'DELETEFAV':
        $RID = $_POST['RID'];
        $UID = $_POST['UID'];

        if(!empty($RID) && !empty($UID))
            $db->delete('Favorites','recipeID='.$RID.' AND userID='.$UID);
        
    break;

    default:
        echo 'SECTION NOT FOUND';
    break;
}
?>
