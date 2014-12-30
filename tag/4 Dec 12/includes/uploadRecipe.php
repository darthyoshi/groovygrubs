<?php
/*Author :Ian Pitts
 * 
 * 
 * 
 */

require 'Database.php';
#for images //echo '<img src="data:image/jpeg;base64,'.  base64_encode($pic['image']).'"/>';
$db = new Database();

if($_GET['ops'] == 'upload'){
    
    #NOTES
    #ADD VALIDATION AND CONTENT CHECKING 
    #AJAX
    #WORK OUT SCHEME FOR ADDING INGREDIENTS
    
    $pictureID = $db->newID();
    $recipeID = $db->newID();
    
    $recipeTitle = $_POST['recipeTitle'];
    $category = $_POST['category'];
    $description = $_POST['description'];
    $recipeServes = $_POST['recipeServes'];
    $prepTime = $_POST['prepTime'];
    
    $ingredients = $_POST['ingredients'];
    $ingredientsQuantity = $_POST['ingredientsQuantity'];
    $ingredientsQuantityUnit = $_POST['ingredientsQuantityUnit'];
    
    $instructions = $_POST['instructions'];
    
    $pictureName = $_FILES['picture']['name'];
    $pictureTemp = $_FILES['picture']['tmp_name'];
    $fileType = $_FILES['picture']['type'];
    $fileSize = $_FILES['picture']['size'];
    
    
    $handle = fopen($pictureTemp, 'r');
    $contents = fread($handle, $fileSize);
    fclose($handle);
    
    $db->insertImage($pictureID,$recipeID,$pictureName,$contents,$fileSize);

    //echo '<img src="data:image/jpeg;base64,'.  base64_encode($pic['image']).'"/>';
    
    $table = 'Recipe';
    $fields = array('ID','userID','name','uploadDate','difficulty','serves','category','approxTime','pictureID','instructions','description');
    $values = array($recipeID,'231231231',$recipeTitle, date('Y-m-d H-i-s'),'3',$recipeServes,$category,$prepTime,$pictureID,addslashes($instructions),$description);
    
    $db->insert($table, $fields, $values);
   
}
?>
