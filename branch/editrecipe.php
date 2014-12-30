<?php

/**
 * Author: Dylan Tu
 * File: editrecipe.php
 * Purpose: Allows a user to edit a recipe
 */

require_once("includes/categories.php");
require_once("includes/template.php");
require_once("includes/Database.php");
session_start();

$db = new Database();
$recipe = $db->select('Recipe','*','ID="'.$_POST['recipeId'].'"')->fetch_assoc();
$description = trim(stripslashes($recipe['description']));
$serves = stripslashes($recipe['serves']);
$time = stripslashes($recipe['approxTime']);
$ingredients = $db->select('Ingredients','*','recipeID='.$recipe['ID']);

if (empty($picture))
	$imgSrc = "recipe_pictures/default.jpg";
else if ($picture['image'] == '')
	$imgSrc = "recipe_pictures/default.jpg";
else
{
	$imgExt = pathinfo($picture['name'], PATHINFO_EXTENSION);
	$imgSrc = "data:image/{$imgExt};base64," . base64_encode($picture['image']);
}

?>
<!DOCTYPE html>
<html lang="en">
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
		$uploadFailure = false;
		echo "<div class='column-2'>";
		?>

		<div id="mainPanel" class="column-2-1">
			<div id="uploadColumn">
				<div id="uploadHeader">
					<?php
					if (!isset($_SESSION['userName']))
					{
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
					else
					{
					?>
						<div style='font-size: x-large;'>
							Edit your recipe
						</div>
						<p>Please enter the following information about your recipe</p>
					</div>
					<div id="uploadBody">
						<form action="includes/Actions.php?ops=update" method="post" enctype="multipart/form-data">
							<fieldset>
								<input type="hidden" name="recipeId" value="<?php echo $_POST['recipeId']; ?>">
								<input type="hidden" name="UID" value="<?php echo $_SESSION['id']; ?>">
								<div class="formRow">
									<label for="recipe-title" class="topLabel">Recipe Title:</label>
									<input type="text" name="recipeTitle" style="width:34em" id="recipe-title" value="<?php echo ($uploadFailure ? $formValues['RErecipeTitle'] : $recipe['name']); ?>" />
								</div>
								<div class="formRow">
									<label for="recipe-category" class="topLabel">Category:</label>
									<select name="category" id="recipe-category">
										<option>Select one</option>
										<?php
										$categories = getCat();
										$subCategories = getSubCat();
										$catLabels = getCatLabels();
										
										foreach ($categories as $i)
										{
											if ($i == 'all')
												break;

											echo "<optgroup label='{$catLabels[$i]}'>\n";
											//lists each subcategory associated with a category
											foreach ($subCategories[$i] as $j)
											{
												if (strcasecmp($j,$recipe["category"]) == 0)
													echo "<option selected='selected'>{$catLabels[$j]}</option>\n";
												else
													echo "<option>{$catLabels[$j]}</option>\n";
											}
											echo "</optgroup>\n";
										}
										?>
									</select>
								</div>
								<div class="formRow">
									<label for="recipe-description" class="topLabel">Description:</label>
									<textarea name="description" id="recipe-description" style="height:3em">
										<?php echo ($uploadFailure ? $formValues['REdescription'] : $description); ?>
									</textarea>
								</div>
								<div class="formRow">
									<label for="recipe-serves" class="topLabel">Serves:</label>
									<input type="text" name="recipeServes" id="recipe-serves" value="<?php echo ($uploadFailure ? $formValues['RErecipeServes'] : $serves); ?>"/>
								</div>
								<div class="formRow">
									<div style="width:100%;">
										<label for='prepTime'>Prep Time:</label>
									</div>
									<div>
										<label><input type="text" id="prepTime" name="prepTime" value="<?php echo ($uploadFailure ? $formValues['REprepTime'] : $time); ?>" />Minutes</label>
									</div>
								</div>
								<div class="formRow" id="ingredients">
									<input type="hidden" name="counter" id="counter" value='1' />
									<div>
										<label for="recipe-ingredients">Ingredients:</label>
										<label for="recipe-ingredients-quantity" style="position:absolute; left:160px;">Quantity:</label>
									</div>
									<div id="ingredient_1">
										<input type="text" name="ingredient_1" id="recipe-ingredients" value="" />
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
										<input type="button" value="Less" style="display: inline-block;float:right;" onclick="remove()"/>
										<input type="button" value="More" style="display: inline-block;float:right;" onclick="add()"/>
									</div>
								</div>
								<div class="formRow">
									<label for="recipe-instructions" class="topLabel">Instructions:</label>
									<textarea name="instructions" id="recipe-instructions">
										<?php echo ($uploadFailure ? $formValues['REinstructions'] : trim($recipe['instructions'])); ?>
									</textarea>
								</div>
								<div class="formRow">
									<label for="recipe-picture" class="topLabel">Picture:</label>
									<input type="file" name="picture" id="recipe-picture" style="width: 25%"/>
								</div>
								<div class="formRow">
									<br>
									<button type="submit" style="position:absolute; left: 200px; width: 160px; height: 40px; font-size: larger">Upload</button>
									<br /><br />
								</div>
							</fieldset>
						</form>
					</div>
				<?php
				}
				?>
			</div>

		</div>

		<?php
		printRightSideBar();
		echo "\n</div>\n";
		echo "</div>\n";
		printFooter();

		if ($uploadFailure)
			echo "<script type='text/javascript'>alert('Please fill in all fields.')</script>";
		?>

	</body>
</html>
