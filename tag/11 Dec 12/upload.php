<?php

#Testing, testing

/**
 * Author: Victor Tobar
 * File: upload.php
 * Purpose: recipe upload page
 */

    require_once "includes/categories.php";
    require_once "includes/template.php";
    session_start();

    /*flag variables*/
    $titleIsEmpty = false;
    $categoryIsEmpty = false;
    $ingredientsIsEmpty = false;
    $ingredientsQuantityIsEmpty = false;
    $instructionsIsEmpty = false;
    $servesIsEmpty = false;
    $ingredientsQuantityUnitIsEmpty = false;
    $prepTimeIsEmpty = false;
    $descriptionIsEmpty = false;
    $uploadSuccess = false;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $uploadSuccess = true;

        if ($_POST["recipeTitle"]=="") {
        $titleIsEmpty = true;
            $uploadSuccess = false;
        }
        if ( $_POST["category"] == "Select one") {
            $categoryIsEmpty = true;
            $uploadSuccess = false;
        }
        if ($_POST["recipeServes"]== "") {
            $servesIsEmpty = true;
          $uploadSuccess = false;
        }
        if ($_POST["prepTime"] == "") {
            $prepTimeIsEmpty = true;
             $uploadSuccess = false;
        }
        if ($_POST["ingredients"]== "") {
            $ingredientsIsEmpty = true;
            $uploadSuccess = false;
        }
        if ($_POST["ingredientsQuantity"]== "") {
            $ingredientsQuantityIsEmpty = true;
            $uploadSuccess = false;
        }
        if ( $_POST["ingredientsQuantityUnit"] == "Select one") {
            $ingredientsQuantityUnitIsEmpty = true;
            $uploadSuccess = false;
        }
        if ($_POST["instructions"]== "") {
            $instructionsIsEmpty = true;
             $uploadSuccess = false;
        }
        if ($_POST["description"] == "") {
            $descriptionIsEmpty = true;
            $uploadSuccess = false;
        }

    }

    /*Refill data after failed attempt*/
    if ($_SERVER["REQUEST_METHOD"] == "POST" && $uploadSuccess == false) {
        $formValues = array("RErecipeTitle" => $_POST["recipeTitle"], "RErecipeServes" => $_POST["recipeServes"],
             "REprepTime" => $_POST["prepTime"], "REingredients" => $_POST["ingredients"], "REingredientsQuantity" => $_POST["ingredientsQuantity"],
            "REinstructions" => $_POST["instructions"], "REpicture" => $_POST["picture"], "REdescription" => $_POST["description"]);
    }
    else {
        $formValues = array("RErecipeTitle" => "", "RErecipeServes" => "",
             "REprepTime" => "", "REingredients" => "", "REingredientsQuantity" => "",
            "REinstructions" => "", "REpicture" => "", "REdescription" => "");
    }

?>
<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
    <title>Upload Recipes - GroovyGrubs.com</title>
    <script src="includes/general.js"></script>
    <script src="includes/jquery-1.8.2.min.js"></script>
</head>

<body id="body">
<?php
    printHeader();

    echo "\n<hr>\n";

    echo "<div id='content'>\n";

    printLeftSideBar();

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
                echo "<div class ='column-2-3'>";
                echo "<form id=\"logonForm\" action=\"login.php\" method=\"POST\"><table style = 'text-align: right;'>
	<tbody><tr><td>
                          <label for=\"userName\">E-mail</label>
                            <input type=\"text\" id=\"userName\" name=\"userName\" size=\"30\">
                        </td></tr>

                        <tr><td>
                            <label for=\"userPass\">Password</label>
                            <input type=\"password\" id=\"userPass\" name=\"userPass\" size=\"30\">
                        </td></tr>

                        <tr>
							<td>
								<small><a href=\"forgot.php\">Forgot your password?</a></small>
								<button type=\"submit\">Login</button>
							</td>
						</tr>
                    </tbody>
	</table></form></div>";
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
        <form action="includes/Actions.php?ops=upload" method="post" enctype="multipart/form-data">
        <fieldset>
            <input type="hidden" name="UID" value="<?=$_SESSION['id']?>">
            <div class="formRow">
                <label for="recipe-title" class="topLabel">Recipe Title:</label>
                <input type="text" name="recipeTitle" style="width:34em" id="recipe-title" value="<?php echo $formValues['RErecipeTitle'];?>" />
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
                <label for="recipe-description" class="topLabel">Description:</label>
                <textarea name="description" id="recipe-description" style="height:3em"></textarea>
            </div>
            <div class="formRow">
                <label for="recipe-serves" class="topLabel">Serves:</label>
                <input type="text" name="recipeServes" id="recipe-serves" value=""/>
            </div>
            <div class="formRow">
                <div style="width:100%;">
                    <label>Prep Time:</label>
                </div>
                <div>
                    <label><input type="text" name="prepTime" value="" />Minutes</label>
                </div>
            </div>
            <div class="formRow" id="ingredients">
                <input type="hidden" name="counter" id="counter" value='1' style="display:none">
                <div>
                    <label for="recipe-ingredients">Ingredients:</label>
                    <label for="recipe-ingredients-quantity" style="position:absolute; left:160px;">Quantity:</label>
                </div>
                <div id="ingredient_1">
                    <input type="text" name="ingredient_1" id="recipe-ingredients" value=""/>
                    <input type="text" name="ingredientQuantity_1" id="recipe-ingredients-quantity" style="position:absolute; left:160px;" value=""/>
                    <select name="ingredientUnit_1" style="position:absolute; left:320px;">
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
                    <input type="button" value="Less" style="display: inline-block;float:right;" onClick="remove()"/>
                    <input type="button" value="More" style="display: inline-block;float:right;" onClick="add()"/>
                </div>
            </div>
            <div class="formRow">
                <label for="recipe-instructions" class="topLabel">Instructions:</label>
                <textarea name="instructions" id="recipe-instructions"></textarea>
            </div>
            <div class="formRow">
                <label for="recipe-picture" class="topLabel">Picture:</label>
                <input type="file" name="picture" id="recipe-picture" style="width: 25%"/>
            </div>
            <div class="formRow">
				<br>
                <button type="submit" style="position:absolute; left: 200px; width: 160px; height: 40px; font-size: larger">Upload</button>
				<br><br>
			</div>
        </fieldset>
        </form>
        </div>
        <?php } ?>
    </div>

</div>

<?php
    printRightSideBar();

    echo "\n</div>\n";
    echo "</div>\n";

    printFooter();
?>

</body>
</html>
