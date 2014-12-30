<!DOCTYPE HTML>
<?php
    require_once("includes/categories.php");
    session_start();

    $loggedIn = false;

    /*flag variables*/
    $titleIsEmpty = false;
    $categoryIsEmpty = false;
    $ingredientsIsEmpty = false;
    $ingredientsAmountIsEmpty = false;
    $instructionsIsEmpty = false;
    $servesIsEmpty = false;
    $prepTimeIsEmpty = false;
    $agreementIsEmpty = false;
    $uploadSuccess = false;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        $uploadSuccess = true;
        
        if ($_POST["recipetitle"]=="") {
        $titleIsEmpty = true;
            $uploadSuccess = false;
        }
        if ($_POST["recipecategory"]=="") {
            $categoryIsEmpty = true;
            $uploadSuccess = false;
        }
        if ($_POST["ingredients"]== "") {
            $ingredientsIsEmpty = true;
            $uploadSuccess = false;
        } 
        if ($_POST["ingredients-amount"]== "") {
            $ingredientsAmountIsEmpty = true;
            $uploadSuccess = false;
        } 
        if ($_POST["instructions-description"]== "") {
            $instructionsIsEmpty = true;
             $uploadSuccess = false;
        } 
        if ($_POST["serves"]== "") {
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
        if ($_POST["agree"] == "") {
            $agreementIsEmpty = true;
            $uploadSuccess = false;
        }
    }

?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
    <title>Upload Recipes - GroovyGrubs.com</title>
    <style>
	#uploadcol ul {
		list-style-type: none;
		padding: 0;
		margin: 0;
	}
	#uploadcol{}
	#uploadcol li {
		overflow: auto;
		height: 4em;
		/*border: 1px solid #ba89a8;*/
	}
	#uploadcol textarea {
		resize: none;
		width: 15em;
		height: 4em;
		overflow:auto;
	}
	#uploadcol label {
		float:left;
		width: 100%;
	}
	#uploadcol input {
		clear:left;
	}
	#leftcol{
		overflow: auto;
		float:left;
		width: 40%;
	}
	#rightcol{
		overflow: auto;
	}
	#servesDiv{
		width: 100%;
	}
	#prepTimeDiv{}
	/*
	#hoursLabel{
		width: 50%;
	}
	#minutesLabel{
		width: 50%;
	}
	#hoursInput {
		clear: none;
	}
	#minutesInput {
		clear:none;
	}
	*/
	#instructionsLi {
		height: 10em;
	}
	#servesLi {
		height:10em;
	}
	#agreement {
		clear:left;
		float:left;
	}
	#submit {
		clear:left;
	}
    </style>
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
                <ul id="breadcrumbs" >
                    <li><a href="index.php">Home</a> &raquo;</li>
                    <li>Upload</li>
                </ul>

                <hr>
                	<div id="uploadcol">
                            <div id="uploadheader">
                                <?php
                                if($uploadSuccess){
                                    echo "<p>Your recipe has been uploaded succesfully!</p>";
                                    echo "<p>Upload another?";
                                }
                                ?>
                                <p><strong>Recipe Upload Form</strong></p>
                                <p><strong>Please enter in the following information about your recipe</strong></p>
                                <p>(* indicates required field)</p>
                            </div>
                            <div id="uploadbody">
                                <form id="upload-form" action="upload.php" method="post">
                                <fieldset>
                                    <div id="leftcol">
                                        <ul>
                                            <li>
                                                <label for="recipe-title">Recipe Title:</label>
                                                <input type="text" name=recipetitle" value="" id="recipe-title"/>
                                                <?php
                                                if ($titleIsEmpty) {
                                                    echo ("Enter title!");
                                                }  
                                                    ?>
                                            </li>
                                            <li>
                                                <label for="recipe-tags">Tags:Enter tags separatted by commas</label>
                                                <input type="text" name="taglist" id="recipe-tags"/>
                                            </li>
                                            <li>
                                                <label for="recipe-equipment">Equipment:</label>
                                                <input type="text" name="equipment" id="recipe-equipment"/>
                                            </li>
                                            <li>
                                                <label for="recipe-ingredients">Ingredients:</label>
                                                <input type="text" name="ingredients" id="recipe-ingredients"/>
                                                <?php
                                                    if ($ingredientsIsEmpty) {
                                                        echo ("Enter ingredients!");
                                                    }  
                                                ?>
                                            </li>
                                            <li id="instructionsLi" style="height:7em">
                                                <label for="recipe-instructions">Instructions:</label>
                                                <textarea name="instructions-description" id="recipe-instructions">
                                                </textarea>
                                                <?php
                                                    if ($instructionsIsEmpty) {
                                                        echo ("Enter instructions!");
                                                    }  
                                                ?>
                                            </li>
                                        </ul>
                                    </div>
                                    <div id="rightcol">
                                        <ul>
                                            <li>
                                                <label for="category">Category:</label>
                                                <select name="recipecategory" id="recipe-category">
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
                                                <?php
                                                    if ($categoryIsEmpty) {
                                                        echo ("Select a category!");
                                                    }  
                                                ?>
                                            </li>
                                            <li>
                                            </li>
                                            <li>
                                                <label for="recipe-equipment-amount">Amount</label>
                                                <input type="text" name="equipment-amount" id="recipe-equipment-amount"/>
                                            </li>
                                            <li>
                                                <label for="recipe-ingredients-amount">Amount</label>
                                                <input type="text" name="ingredients-amount" id="recipe-ingredients-amount"/>
                                                <?php
                                                    if ($ingredientsAmountIsEmpty) {
                                                        echo ("Enter ingredient amount!");
                                                    }  
                                                ?>
                                            </li>
                                            <li id="servesLi" style="height:7em">
                                                <div id="servesDiv">
                                                    <label for="recipe-instructions-serves">Serves</label>
                                                    <input type="text" name="serves" id="recipe-instructions-serves"/>
                                                    <?php
                                                        if ($servesIsEmpty) {
                                                            echo ("Entere serving size!");
                                                        }  
                                                    ?>
                                                </div>
                                                <div id="prepTimeDiv">
                                                    <label>Prep time</label>
                                                    <label style="width:30%"><input type="text" style="width:2em"/>Hours</label>
                                                    <label style="width:30%"><input type="text" style="width:2em"/>Minutes</label>
                                                    <?php
                                                        if ($prepTimeIsEmpty) {
                                                            echo ("\nEnter prep time!");
                                                        }  
                                                    ?>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    <div>
                                        <label for="recipe-picture">Pictures:</label>
                                        <input type="file" name="image" id="recipe-picture"/>
                                    </div>
                                    <div>
                                        <label>Video:</label>
                                        <input type="text" value="Type link here."/>
                                    </div>
                                    <div id="agreement">
                                        <p>* I agree to the GroovyGrubs.com 
                                        <a href="terms.php">Terms of Service</a>
                                        and
                                        <a href="privacy.php">Privacy Policy</a>
                                        <input type="checkbox" name="agree" />
                                        <?php
                                            if ($agreementIsEmpty) {
                                                echo ("\nYou must agree to continue!");
                                            }  
                                        ?>
                                        </p>
                                    </div>
                                    <div id="submit">
                                        <input type="submit" value="Submit" />
                                    </div>
                                </fieldset>
                                </form>
                            </div>
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
