<?php

/**
 * Author: James Latief, Dylan Tu
 * File: userhome.php
 * Purpose: displays user account information
 */

require_once "includes/categories.php";
require_once "includes/template.php";
session_start();

if (isset($_SESSION["userName"]) == FALSE)
	header("Location: index.php");
?>

<!DOCTYPE html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
    <title>User Home Page - GroovyGrubs.com</title>
    <script src="includes/general.js"></script>
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
	<div style='text-align: center; font-size: x-large'>
		Account Information<br><br>
    </div>

	<div id ="memberInfo" class="topTen" style="width: 95%">
		<div style='text-align: center;'>
			<p style = "font-size: x-large; text-align: center" > <b><u>GroovyGrub Member Information</u></b> </p>
		</div>

		<table style="position: relative; left: 10%">
            <tr style = "font-size: large">
                <td><b>Name</b>:</td>
                <td><?php echo $_SESSION["firstMidLast"]; ?></td>
            </tr>
            <tr style = "font-size: large">
                <td><b>Email</b>:</td>
                <td><?php echo $_SESSION["userName"]; ?></td>
            </tr>
            <tr style  = "font-size: medium">
                <td><b>Date Joined</b>:</td>
				<?php
				require_once("includes/Database.php");
				$db = new Database();
				$row = $db->select("User","regDate","userName='".$_SESSION["userName"]."'")->fetch_assoc();
				$joinDate = $row["regDate"];
				?>
                <td><?php echo $joinDate; ?></td>
            </tr>
		</table>

	</div>
    <br />

	<div id ="uploads" class="topTen" style="width: 45%; float: left; left: 2%">
		<div style='text-align: center;'>
			<p style = "font-size: large" > <b>Recipes You <a href="viewlist.php?type=upload">Uploaded</a></b> </p>

		</div>
		<?php
		$handle = $db->select("Recipe","ID,name","userID='".$_SESSION["id"]."'","","uploadDate DESC");
		$recipesUploaded = mysqli_num_rows($handle);
		echo "<ol>\n";

		if ($recipesUploaded == 0)
			echo "You haven't uploaded any recipes. Try adding some <a href='upload.php'>here</a>!";
		for ($i = 0; $i < 8 && $recipe = mysqli_fetch_assoc($handle); $i++)
			echo "<li><a class='truncate' href='recipe.php?id=".$recipe['ID']."'>".$recipe['name']."</a></li>\n";

		echo "</ol>\n";
		?>
	</div>

	<div id ="commented" class="topTen" style="width: 45%; float: right; right: 2%">
		<div style='text-align: center;'>
            <p style = "font-size: large" > <b>Recipes You <a href="viewlist.php?type=rating">Rated</a></b> </p>
		</div>
		<?php
        $handle = $db->select('Recipe LEFT JOIN Ratings ON Recipe.ID = Ratings.recipeID','Recipe.ID,Recipe.name','Ratings.raterID='.$_SESSION['id']);

		$recipesRated = mysqli_num_rows($handle);
		echo "<ol>\n";

		if ($recipesRated == 0)
			echo "You haven't rated any recipes.";
        for ($i = 0; $i < 8 && $recipe = mysqli_fetch_assoc($handle); $i++) {
            $yourRating = $db->select("Ratings",'rating','raterID='.$_SESSION['id'].' AND recipeID='.$recipe['ID'])->fetch_row();
			echo "<li><a class='truncate' href='recipe.php?id=".$recipe['ID']."' style='width:195px'>"
                    .$recipe['name']
                ."</a>"
                ."<span style='float:right;position:absolute;left:245px'>".
                    number_format($yourRating[0],2).
                "</span>"
            ."</li>\n";
        }

		echo "</ol>\n";
		?>
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