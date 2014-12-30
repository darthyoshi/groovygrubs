<!DOCTYPE HTML>
<?php
require_once("includes/categories.php");
session_start();

?>

<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
    <title>View Recipe - GroovyGrubs.com</title>
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
                <ul id="breadcrumbs">
<!--need to retrieve levels for display-->
                    <li><a href="index.php">Home</a> &raquo;</li>
                    <li>Recipe</li>
                </ul>

                <hr>

                <p style="text-align: center; font-size: x-large">
                    Recipe name
                </p>

                <a href="logo.gif" target="blank">
                    <img src="logo.gif" alt="Recipe image" width=200
                        height=150 style="padding: 5px; float: left">
                </a>

                Rating:

                <div style="font-size: small"><p>Submitted by: User</p></div>

                <p>Recipe description</p>

                <hr style="clear: both">

                <img src="" alt="Recipe video" width=200 height=150 style="padding: 5px; float: right; border: solid black 1px">

                Ingredient list:
                <ol>
                    <li>Ingredient #1</li>

                </ol>

                <div style="clear: both; text-align: center">
                    <hr>
                    &lt; comment/rating system goes here >
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