<?php

/**
 * @Author: Ian Pitts, Dylan Tu
 * @File: Actions.php
 * @Purpose: Performs actions on a recipe (upload/update/delete/rate)
 */
 
require 'Database.php';
$db = new Database();
session_start();

switch (strtoupper($_GET['ops'])){

    case 'UPLOAD':

            $missingFields = array();
			$recipeID = $db->newID();
            $pictureID = $db->newID();
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
                if (empty($values[$i]) || $values[$i] == "Select one") {
                    $missingFields[] = $fields[$i];
                }

                $values[$i] = strip_tags($values[$i]);
            }

            if (count($missingFields) == 0) {
                $db->insert($table, $fields, $values);
            }

            #ingredients
            $fields = array('ID','recipeID','name','quantity','unit');
            for ($i = 1; $i <= $numIng; $i++){

                $ingredient = $_POST['ingredient_'.$i];
                $quantity = $_POST['ingredientQuantity_'.$i];
                $unit = $_POST['ingredientUnit_'.$i];

                if (empty($ingredient))
                    $missingFields[] = 'ingredient_'.$i;
                elseif (empty($quantity))
                    $missingFields[] = 'ingredientQuantity_'.$i;
                elseif (empty($unit) || $unit == "Select one")
                    $missingFields[] = 'ingredientUnit_'.$i;
                else {
                    $values = array($db->newID(),$recipeID,addslashes($ingredient),addslashes($quantity),addslashes($unit));
                    $db->insert('Ingredients',$fields,$values);
                }
            }

            // PIC
            if ($_FILES['picture']['name'] != "") {

                $pictureName = $_FILES['picture']['name'];
                $pictureTemp = $_FILES['picture']['tmp_name'];
                $fileSize = $_FILES['picture']['size'];
				
				//$uploadStatus = TRUE;
			
				$extension = end(explode(".",$pictureName));
				if ($extension != "jpg" && $extension != "png" && $extension != "gif")
					die("Only images of type jpg, png, or gif are accepted.");
				$size = getimagesize($pictureName);
				if ($size[0] > 1024 || $size[1] > 768)
					die("The maximum size of a picture is 1080 x 768 pixels.");
				
                $handle = fopen($pictureTemp, 'rb');
                $contents = fread($handle, $fileSize);
                fclose($handle);
				
				// Create a new file and write the full picture to it
				$filename = $recipeID . $pictureName;
				// Need to chmod o+wx recipe_pictures
				move_uploaded_file($pictureTemp,"../recipe_pictures/".$filename);
				
				if (empty($contents))
                    $thumbnail = '';
				else
				{
					$im = new imagick();
					$im->readimageblob($contents);
					$im->setImageFormat(pathinfo($pictureName, PATHINFO_EXTENSION));
					$im->resizeImage(200,150,1,1,true);
					$thumbnail = $im->getImageBlob();
				}
				//if ($uploadStatus == TRUE)
					$db->insertImage($pictureID,$_POST['recipeId'],$pictureName,$thumbnail,$fileSize);
            }

            if (!headers_sent() && empty($missingFields)) {
                $URL = 'Location:../recipe.php?id='.$recipeID;
                header($URL);
            }
            else {
                $fields = Array(
                    'recipeTitle' => $recipeTitle,
                    'description' => $description,
                    'recipeServes' => $recipeServes,
                    'prepTime' => $prepTime,
                    'instructions' => $instructions
                    );
                $_SESSION['fields'] = $fields;
                header('Location:../upload.php');
            }
    break;
	
	case 'UPDATE':
		$table = 'Recipe';
		$recipeTitle = $_POST['recipeTitle'];
		$category = $_POST['category'];
		$description = $_POST['description'];
		$recipeServes = $_POST['recipeServes'];
		$prepTime = $_POST['prepTime'];
		$numIng = $_POST['counter'];
		$instructions = $_POST['instructions'];
		
		// Check if the selected ingredient is not the default value
		if ($_POST['ingredient_1'] != "" && strcmp($_POST['ingredientUnit_1'],"Select one") != 0)
		{
			// delete the old ingredients
			$db->delete("Ingredients","recipeID='".$_POST['recipeId']."'");
			$fields = array('ID','recipeID','name','quantity','unit');
			for ($i = 1; $i <= $numIng; $i++)
			{
				$ingredient = $_POST['ingredient_'.$i];
				$quantity = $_POST['ingredientQuantity_'.$i];
				$unit = $_POST['ingredientUnit_'.$i];
				$missingFields = array();
				if (empty($ingredient))
					$missingFields[] = 'ingredient_'.$i;
				elseif (empty ($quantity))
					$missingFields[] = 'ingredientQuantity_'.$i;
				elseif (empty($unit) || $unit == "Select one")
					$missingFields[] = 'ingredientUnit_'.$i;
				else
				{
					$values = array($db->newID(),$_POST['recipeId'],addslashes($ingredient),addslashes($quantity),addslashes($unit));
					// update with the new ones
					$db->insert("Ingredients",$fields,$values);
				}
			}
		}
		/*
		Check if a picture is uploaded.
		*/
		if ($_FILES['picture']['name'] != "")
		{
			$pictureName = $_FILES['picture']['name'];
			$pictureTemp = $_FILES['picture']['tmp_name'];
			$fileSize = $_FILES['picture']['size'];
			
			//$uploadStatus = TRUE;
			
			$extension = end(explode(".",$pictureName));
			if ($extension != "jpg" && $extension != "png" && $extension != "gif")
				die("Only images of type jpg, png, or gif are accepted.");
			$size = getimagesize($pictureName);
			if ($size[0] > 1080 || $size[1] > 768)
				die("The maximum size of a picture is 1080 x 768 pixels.");
			
			$handle = fopen($pictureTemp, 'rb');
			$contents = fread($handle, $fileSize);
			fclose($handle);
			
			// Create a new file and write the full picture to it
			$filename = $_POST['recipeId'] . $pictureName;
			// Need to chmod o+wx recipe_pictures
			move_uploaded_file($pictureTemp,"../recipe_pictures/".$filename);

			if (empty($contents))
				$thumbnail = '';
			else
			{
				$im = new imagick();
				$im->readimageblob($contents);
				$im->setImageFormat(pathinfo($pictureName, PATHINFO_EXTENSION));
				$im->resizeImage(200,150,1,1,TRUE);
				$thumbnail = $im->getImageBlob();
			}
			
			// delete the old image
			$db->delete("Picture","recipeID='".$_POST['recipeId']."'");
			// insert the new one
			$pictureID = $db->newID();
			//if ($uploadStatus == TRUE)
				$db->insertImage($pictureID,$_POST['recipeId'],$pictureName,$thumbnail,$fileSize);
		}
		
		// other fields
		$fields = "name='".$recipeTitle."', uploadDate='".date('Y-m-d H-i-s')."', difficulty='3',
					serves='".$recipeServes."', category='".$category."', approxTime='".$prepTime."',
					instructions='".addslashes($instructions)."', description='".$description."'";
		$db->update($table,$fields,"ID='".$_POST['recipeId']."'");
		header("Location: ../recipe.php?id=".$_POST['recipeId']);
		break;
    case 'RATE':

        $recipeID      = $_POST['RID'];
        $userID        = $_POST['UID'];
        $rating        = $_POST['rating'];

        if ($rating > 5 OR $rating < 0){
            echo 'Please Enter a number between 1 and 5';
        }
        elseif (!empty($rating)) {
            $result = $db->addRating($recipeID, $userID, $rating);
            echo number_format($db->getRating($recipeID),2);
        }
        else{
            echo 'Please Enter a Number.';
        }
    break;

    case 'SETSERVING':
        $recipeID = $_POST['RID'];
        $serves = $_POST['serves'];
        $newServe = $_POST['newServe'];

        $output = "<ol id='ingList'>\n";

        $ingredients = $db->select('Ingredients','*','recipeID='.$recipeID);
        for ($i = 0; ($row = mysqli_fetch_assoc($ingredients)); $i++){
            $multiplier = $serves == 0 ? 0 : $row['quantity']/$serves;
            $output .= "                    <li>".number_format($multiplier*$newServe,2)." ".$row['unit']." of ".$row['name']."</li>\n";
        }
        if ($i == 0)
            $output .= "<p>This recipe requires no ingredients.</p>\n";

        $output .= "</ol>\n";
        echo $output;
    break;

    case 'ADDFAV':

        $UID = $_POST['UID'];
        $RID = $_POST['RID'];

        if (!empty($RID) && !empty($UID))
            $result = $db->select("Favorites","*","userID='".$UID."' AND recipeID='".$RID."'");

        if (mysqli_num_rows($result) > 0){
            echo 'You have already added this recipe to your favorites.';
        }
        else {
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

        if (!empty($RID) && !empty($UID))
            if ($db->delete('Favorites','recipeID='.$RID.' AND userID='.$UID) == false)
                echo 'The recipe has not been removed.';

    break;

    default:
        echo 'SECTION NOT FOUND';
    break;
}
?>
