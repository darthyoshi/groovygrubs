<?php

/**
 * Author: Victor Tobar
 * File: search.php
 * Purpose: webpage displaying recipe search results
 */

require_once "includes/categories.php";
require_once "includes/general.php";
require_once "includes/Search.php";
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
    printheader();

    echo "\n<hr>\n";

    echo "<div id='content'>\n";

    leftsidebar();

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
                    $results = $SearchC->searchByName($_GET['searchInput']);
                    echo "The number of results are: ".count($results).'<br>';
		?> 
        </div>
        <div id="searchBody">
                <?php
                    for($i = 0; $i < count($results); $i++){
                        $row = $results[$i];
                        $ratingRow = $SearchC->searchForRating($row['ID']);
                        $imageRow = $SearchC->searchForImage($row['ID']);
                        $imgExt = pathinfo($imageRow['Image'], PATHINFO_EXTENSION);
                        
                        echo "
                        <hr/>
                        <div class='searchRow'>
                        <div class='entry-image'>
                            <img src='data:image/".$imgExt.";base64,".base64_encode($imageRow['Image'])."' width='180' height='120' alt='Recipe Picture'/>
                        </div>
                        <h2 class='entry-title'><a href='recipe.php?id=".$row['ID']."'>".$row['name']."</a></h2>
                        <div class='entry-data'>
                            <p>Rating: ".$ratingRow['rating']."</p>
                            <p>Time: ".$row['approxTime']."</p>
                        </div>
                        <div class='summary'>
                            <p>Description: ".$row['description']."</p>
                        </div>
                        </div> 
                        ";
                    }
                ?>
        </div>
    </div>

</div>

<?php
    rightsidebar();

        echo "\n</div>\n";
    echo "</div>\n";

    footer();
?>

</body>
</html>
