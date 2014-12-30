<?php

/**
 * Author: Victor Tobar
 * File: search.php
 * Purpose: webpage displaying recipe search results
 */

require_once "includes/categories.php";
require_once "includes/template.php";
require_once "includes/Search.php";
require_once "includes/Database.php";
session_start();
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
    <title>Search Recipes - GroovyGrubs.com</title>
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


<!--<div id="mainPanel" class="column-2-1">
    <div id="searchColumn">
    	<div id="searchHeader" style="font-size: x-large">
        	<?php
                /*
                    $SearchC = new Search();
                    $results = $SearchC->searchByName($_GET['searchInput']);
                    #print_r($results);
                    echo "The number of results are: ".count($results).'<br>';
                    for($i = 0; $i < count($results); $i++){
                    $row = $results[$i];
                    echo "Recipe Name: ".$row['name'].'<br>';
                    echo $row['pictureID'].'<br>';
                    }
                 */
		?>
		<br><br>
        </div>
    </div>
</div>
-->

<div id="mainPanel" class="column-2-1">
    <div id="searchColumn">
    	<div id="searchHeader" style="font-size: x-large">
<?php
    $SearchC = new Search();
    $db = new Database();
    $results = $SearchC->searchByName($_GET['searchInput']);
    echo "The number of results are: ".count($results).'<br>';
?>
        </div>
        <div id="searchBody">
<?php
    for($i = 0; $i < count($results); $i++){
        $row = $results[$i];
        $rating = $db->getRating($row['ID']);
        $imageRow = $db->getImage($row['ID']);
        if (!empty($imageRow) && $imageRow['name'] != '')
            $imageExt = pathinfo($imageRow['name'], PATHINFO_EXTENSION);

        $imgSrc = (empty($imageRow)) ?
            "recipe_pictures/default.jpg" :
            "data:image/".$imageExt.";base64,".base64_encode($imageRow['image']);

        echo "
            <hr/>
            <div class='searchRow'>
            <div class='entry-image'>
                <a href='recipe.php?id=".$row['ID']."'>
                  <img src='".$imgSrc."' width='180' height='120' alt='".$row['name']."'/>
                </a>
            </div>
            <h2 class='entry-title'><a href='recipe.php?id=".$row['ID']."'>".$row['name']."</a></h2>
            <div class='entry-data'>
                <p>Rating: ".$rating."</p>
                <p>Time: ".$row['approxTime']."</p>
            </div>
            <div class='summary'>
                <p>Description: ".$row['description']."</p>
            </div>
            </div>";
    }
?>
        </div>
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
