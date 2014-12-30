<?php
/**
 * Author: Victor Tobar
 * File: browse.php
 * Purpose: webpage for browsing recipes
 */

require_once("includes/categories.php");
session_start();
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
    <title>Browse Recipes - GroovyGrubs.com</title>
    <style>
    /*browseColumn styles*/
    /*browseHeader styles*/
    /*browseBody styles*/
    #browseBody {
            width: 100%;
            float: left;
    }
    #browseRow {
            width: 100%;
            border: 1px solid black;
            overflow: auto;
            margin: 0 0 10px 0;
            height: 100px;
    }
    #browseRow div {
            float: left;
            width: 18.5%;
            overflow: auto;
            height: 100px;
            text-align: center;
    }
    #browseRow img {
            max-width: 100%;
            position: relative;
            top: 5px;
    }
    .nonImageCell {
            border-right: 1px solid black;
            margin: 0 1%;
    }
    .imageCell {
            border-right: 1px solid black;
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
    <div id="browseColumn">
    	<div id="browseHeader" style="font-size: x-large">
            Browsing:
            <?php
            if(isset($_GET['browse']))
                echo $catLabels[$_GET['browse']];
            else echo 'All';
            ?>
            (# results found)<br><br>
        </div>
        <div id="browseBody">
            <div id="browseRow"><a href="recipe.php">
                <div class="imageCell"><img src="food.jpg" alt="" height=100 /></div>
                <div class="nonImageCell"><p>Title: Blackberry Pie</p></div>
                <div class="nonImageCell"><p>Rating: 5 Star</p></div>
                <div class="nonImageCell"><p>Serves: 2 People</p></div>
                <div><p>Prep Time: 50 Minutes</p></div></a>
            </div>
            <div id="browseRow"><a href="recipe.php">
                <div class="imageCell"><img src="food.jpg" alt="" height=100 /></div>
                <div class="nonImageCell"><p>Title: Banana Bread</p></div>
                <div class="nonImageCell"><p>Rating: 1 Star</p></div>
                <div class="nonImageCell"><p>Serves: 2 People</p></div>
                <div><p>Prep Time: 45 Minutes</p></div></a>
            </div>
            <div id="browseRow"><a href="recipe.php">
                <div class="imageCell"><img src="food.jpg" alt="" height=100 /></div>
                <div class="nonImageCell"><p>Title: Apple Pie</p></div>
                <div class="nonImageCell"><p>Rating: 4 Star</p></div>
                <div class="nonImageCell"><p>Serves: 3 People</p></div>
                <div><p>Prep Time: 35 Minutes</p></div></a>
            </div>
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
