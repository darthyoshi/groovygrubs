<!DOCTYPE html>
<?php

/**
 * Author: James Latief
 * File: userhome.php
 * Purpose: displays user account information
 */

require_once "includes/categories.php";
require_once "includes/general.php";
session_start();
?>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
    <title>User Home Page - GroovyGrubs.com</title>
    <script src="includes/general.js"></script>
</head>

<body id="body">

<?php

printheader();

echo "\n<hr>\n";
echo "<div id='content'>\n";

leftsidebar();

echo "<div class='column-2'>";

?>

<div id="mainPanel" class="column-2-1">
	<div style='text-align: center; font-size: x-large'>
		Account Information<br><br>
    </div>

    <?php
    if(isset($_SESSION['userName'])){
    ?>

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
    <br>

	<div id ="uploads" class="topTen" style="width: 45%; float: left; left: 2%">
		<div style='text-align: center;'>
			<p style = "font-size: large" > <b><u>Recipes You Uploaded</u></b> </p>

		</div>

		<ol>
			<li> <a href="recipe.php">Recipe name</a>
			</li>

		</ol>
	</div>



	<div id ="commented" class="topTen" style="width: 45%; float: right; right: 2%">


		<div style='text-align: center;'>
			<p style = "font-size: large" > <b><u>Rated Recipes</u></b> </p>

		</div>

		<ol>
			<li> <a href="recipe.php">Recipe name</a>
			</li>

		</ol>

	</div>
    <?php
    }
    else{
        echo "You are currently not logged in.";
    }
    ?>
</div>

<?php

rightsidebar();

echo "\n</div>\n";
echo "</div>\n";

footer();

?>

</body>
</html>