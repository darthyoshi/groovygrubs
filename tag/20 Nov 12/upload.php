<?php

/**
 * Author: Victor Tobar
 * File: upload.php
 * Purpose: recipe upload page
 */

    require_once("includes/categories.php");
    session_start();

    $loggedIn = false;

    /*flag variables*/
    $titleIsEmpty = false;
    $categoryIsEmpty = false;
    $equipmentIsEmpty = false;
    $equipmentAmountIsEmpty = false;
    $ingredientsIsEmpty = false;
    $ingredientsAmountIsEmpty = false;
    $pictureIsEmpty = false;
    $videoIsEmpty = false;
    $instructionsIsEmpty = false;
    $servesIsEmpty = false;
    $ingredientsAmountUnitIsEmpty = false;
    $prepTimeIsEmpty = false;
    $agreementIsEmpty = false;
    $tagsIsEmpty = false;
    $uploadSuccess = false;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $uploadSuccess = true;

        if ($_POST["recipeTitle"]=="") {
        $titleIsEmpty = true;
            $uploadSuccess = false;
        }
        if ($_POST["category"]=="" || $_POST["category"] == "Select one") {
            $categoryIsEmpty = true;
            $uploadSuccess = false;
        }
        if ($_POST["recipeServes"]== "") {
            $servesIsEmpty = true;
          $uploadSuccess = false;
        }
        if ($_POST["hours"] == "") {
            $prepTimeIsEmpty = true;
             $uploadSuccess = false;
        }
        if ($_POST["minutes"] == "") {
            $prepTimeIsEmpty = true;
        }
        if ($_POST["equipment"]== "") {
            $equipmentIsEmpty = true;
            $uploadSuccess = false;
        }
        if ($_POST["equipmentAmount"]== "") {
            $equipmentAmountIsEmpty = true;
            $uploadSuccess = false;
        }
        if ($_POST["ingredients"]== "") {
            $ingredientsIsEmpty = true;
            $uploadSuccess = false;
        }
        if ($_POST["ingredientsAmount"]== "") {
            $ingredientsAmountIsEmpty = true;
            $uploadSuccess = false;
        }
        if ($_POST["ingredientsAmountUnit"]== "" || $_POST["ingredientsAmountUnit"] == "Select one") {
            $ingredientsAmountUnitIsEmpty = true;
            $uploadSuccess = false;
        }
        if ($_POST["instructions"]== "") {
            $instructionsIsEmpty = true;
             $uploadSuccess = false;
        }
        if ($_POST["picture"] == "") {
            $pictureIsEmpty = true;
            $uploadSuccess = false;
        }
        if ($_POST["video"] == "") {
            $videoIsEmpty = true;
            $uploadSuccess = false;
        }
        if ($_POST["tags"] == "") {
            $tagsIsEmpty = true;
            $uploadSuccess = false;
        }
        if (isset($_POST["agree"])) {
        } else {
            $agreementIsEmpty = true;
            $uploadSuccess = false;
        }
    }

    /*Refill data after failed attempt*/
    if ($_SERVER["REQUEST_METHOD"] == "POST" && $uploadSuccess == false){
        $formValues = array("RErecipeTitle" => $_POST["recipeTitle"], "RErecipeServes" => $_POST["recipeServes"],
             "REhours" => $_POST["hours"], "REminutes" => $_POST["minutes"], "REequipment" => $_POST["equipment"], "REequipmentAmount" => $_POST["equipmentAmount"],
             "REingredients" => $_POST["ingredients"], "REingredientsAmount" => $_POST["ingredientsAmount"],
            "REinstructions" => $_POST["instructions"], "REtags" => $_POST["tags"], "REpicture" => $_POST["picture"], "REvideo" => $_POST["video"]);
    } else {
        $formValues = array("RErecipeTitle" => "", "RErecipeServes" => "",
             "REhours" => "", "REminutes" => "", "REequipment" => "", "REequipmentAmount" => "",
             "REingredients" => "", "REingredientsAmount" => "",
            "REinstructions" => "", "REtags" => "", "REpicture" => "", "REvideo" => "");
    }

?>
<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
    <title>Upload Recipes - GroovyGrubs.com</title>
</head>

<body id="body">
<?php
    include 'includes/header.php';

    echo "\n<hr>\n";

    echo "<div id='content'>\n";

    include 'includes/leftsidebar.php';

    echo "<div class='column-2'>";
?>

<div id="mainPanel" class="column-2-1">
   <div id="uploadColumn">
	<div id="uploadHeader">
        <?php
            if($uploadSuccess){
                echo "<p>Your recipe has been uploaded succesfully!</p>";
                echo "<p>Upload another?";
            }
            if ($_SERVER["REQUEST_METHOD"] == "POST" && !$uploadSuccess){
                echo "<p style='text-align: center; color: #ff0000;'>Recipe has failed to upload!</p>";
                echo "<p style='text-align: center; color: #ff0000;'>Please fill in all fields.";
            }
            if (!isset($_SESSION['userName'])){
                echo "<p style='text-align: center; color: #ff0000;'>You must be logged in in order to upload recipes.</p>";
                echo "<p style='text-align: center; color: #ff0000;'>Please log in, at the top corner of the page.</p>";
                echo "</div>";
            }
            else{
        ?>
        <div style='font-size: x-large;'>
            Recipe Upload Form
        </div>
        <p>Please enter the following information about your recipe</p>
    </div>
	<div id="uploadBody">
        <form action="upload.php" method="post">
        <fieldset>
            <div class="formRow">
                <label for="recipe-title" class="topLabel">Recipe Title:</label>
                <input type="text" name="recipeTitle" id="recipe-title" value="<?php echo $formValues['RErecipeTitle'];?>" />
            </div>
            <div class="formRow">
                <label for="recipe-category" class="topLabel">Category:</label>
                <select name="category" id="recipe-category">
                <option selected="selected">Select one</option>
                <optgroup label="Courses">
                    <option>Appetizer</option>
                    <option>Breakfast</option>
                    <option>Dessert</option>
                    <option>Drink</option>
                    <option>Lunch</option>
                    <option>Main</option>
                    <option>Salad</option>
                    <option>Side</option>
                </optgroup>
                <optgroup label="Cuisine">
                    <option>Chinese</option>
                    <option>Indian</option>
                    <option>Mexican</option>
                    <option>Japanese</option>
                    <option>Southern</option>
                    <option>Thai</option>
                    <option>Other</option>
                </optgroup>
                <optgroup label="Lifestyle">
                    <option>BBQ</option>
                    <option>Healthy</option>
                    <option>Easy</option>
                    <option>Vegetarian</option>
                </optgroup>
                <optgroup label="Season">
                    <option>Spring</option>
                    <option>Summer</option>
                    <option>Fall</option>
                    <option>Winter</option>
                </optgroup>
                </select>
            </div>
            <div class="formRow">
                <label for="recipe-serves" class="topLabel">Serves:</label>
                <input type="text" name="recipeServes" id="recipe-serves" value="<?php echo $formValues['RErecipeServes'];?>"/>
            </div>
            <div class="formRow">
                <div style="width:100%;">
                    <label>Prep Time:</label>
                </div>
                <div>
                    <label><input type="text" name="hours" value="<?php echo $formValues['REhours'];?>" />Hours</label>
                </div>
                <div>
                    <label><input type="text" name="minutes" value="<?php echo $formValues['REminutes'];?>" />Minutes</label>
                </div>
            </div>
            <div class="formRow">
                <div>
                    <label for="recipe-equipment">Equipment:</label>
                    <label for="recipe-equipment-amount" style="position:absolute; left:160px;">Amount:</label>
                </div>
                <div>
                    <input type="text" name="equipment" id="recipe-equipment" value="<?php echo $formValues['REequipment'];?>"/>
                    <input type="text" name="equipmentAmount" id="recipe-equipment-amount" style="position:absolute; left:160px;" value="<?php echo $formValues['REequipmentAmount'];?>"/>
                </div>
            </div>
            <div class="formRow">
                <div>
                    <label for="recipe-ingredients">Ingredients:</label>
                    <label for="recipe-ingredients-amount" style="position:absolute; left:160px;">Amount:</label>
                </div>
                <div>
                    <input type="text" name="ingredients" id="recipe-ingredients" value="<?php echo $formValues['REingredients'];?>"/>
                    <input type="text" name="ingredientsAmount" id="recipe-equipment-amount" style="position:absolute; left:160px;" value="<?php echo $formValues['REingredientsAmount'];?>"/>
                    <select name="ingredientsAmountUnit" style="position:absolute; left:320px;">
                        <option selected="selected">Select one</option>
                        <option>Unit</option>
                        <option>Tablespoon</option>
                        <option>Teaspoon</option>
                        <option>Cup</option>
                        <option>Pounds(lb)</option>
                        <option>Ounce(oz)</option>
                        <option>Fluid Ounce(fl oz)</option>
                        <option>Pint</option>
                    </select>
                </div>
            </div>
            <div class="formRow">
                <label for="recipe-instructions" class="topLabel">Instructions:</label>
                <textarea name="instructions" id="recipe-instructions" value="<?php echo $formValues['REinstructions'];?>"></textarea>
            </div>
            <div class="formRow">
                <label for="recipe-tags" class="topLabel">Tags: Enter tags separated by commas:</label>
                <input type="text" name="tags" id="recipe-tags" style="width: 25%;" value="<?php echo $formValues['REtags'];?>"/>
            </div>
            <div class="formRow">
                <label for="recipe-picture" class="topLabel">Picture:</label>
                <input type="file" name="picture" id="recipe-picture" value="<?php echo $formValues['REpicture'];?>" style="width: 25%"/>
            </div>
            <div class="formRow">
                <label for="recipe-video" class="topLabel">Video link:</label>
                <input type="text" name="video" id="recipe-video" style="width: 25%;" value="<?php echo $formValues['REvideo'];?>"/>
            </div>

            <div class="formRow">
                <button type="submit">Upload</button>
            </div>
        </fieldset>
        </form>
        </div>
        <?php } ?>
    </div>

</div>

<?php
    include 'includes/rightsidebar.php';

        echo "\n</div>\n";
    echo "</div>\n";

    include 'includes/footer.php';
?>

</body>
</html>
