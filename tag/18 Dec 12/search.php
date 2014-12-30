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
$pageNo = isset($_GET['page']) ? $_GET['page'] : 1;
$search = isset($_GET['search']) ? $_GET['search'] : '';
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

<div id="mainPanel" class="column-2-1">
    <div id="browseColumn">
    	<div id="browseHeader" style="font-size: x-large; text-align: center">
<?php
    $SearchC = new Search();
    $db = new Database();
    $results = $SearchC->searchByName($search);

    $total = count($results);
    if ($total == 0)
        $lastPageNo = $pageNo = 0;
    else
        $lastPageNo = floor(($total-1)/5)+1;
    $indexOutOfBounds = $pageNo > $lastPageNo || $pageNo < 1;

    echo "    Search Results - ".$search;
?>
        </div>
        <div id="browseBody">
<?php
    echo "            <div style='font-size:large;float:left'>Page ".$pageNo." of ".$lastPageNo."</div>

            <form style='float:right' action='search.php' method='GET'>
                <label for='page'>Go to:</label>
                    ".($pageNo != 1 && $total > 0 ?
                        "<a href='search.php?search=".$search."&amp;page=1'>|&laquo;First</a>" :
                        "|&laquo;First")
                    ."
                    ".(!$indexOutOfBounds && $pageNo > 1 ?
                        "<a href='search.php?search=".$search."&amp;page=".($pageNo-1)."'>&larr;Prev</a>" :
                        "&larr;Prev")
                    ."
                    ".(!$indexOutOfBounds && $pageNo < $lastPageNo ?
                        "<a href='search.php?search=".$search."&amp;page=".($pageNo+1)."'>Next&rarr;</a>" :
                        "Next&rarr;")
                    ."
                    ".($pageNo != $lastPageNo ?
                        "<a href='search.php?search=".$search."&amp;page=".$lastPageNo."'>Last&raquo;|</a>" :
                        "Last&raquo;|")
                    ."
                <input type='hidden' name='search' value='".$search."'><!--
                --><input type='text' id='page' name='page' value='' size='1' /><!--
                --><button type='submit'>Go!</button>
            </form>";

    if ($total > 0 && !$indexOutOfBounds) {
        for ($i = 5*($pageNo-1); $i < $total && $i < 5*$pageNo; $i++){
            $row = $results[$i];
            $rating = $db->getRating($row['ID']);
            $imageRow = $db->getImage($row['ID']);
            if (!empty($imageRow) && $imageRow['name'] != '')
                $imageExt = pathinfo($imageRow['name'], PATHINFO_EXTENSION);
            $user = $db->select("User","firstName,middleName,lastName","ID=".$row['userID'])->fetch_row();

            $imgSrc = (empty($imageRow)) ?
                "recipe_pictures/default.jpg" :
                "data:image/".$imageExt.";base64,".base64_encode($imageRow['image']);

            echo "            <hr style='clear:both'>

            <div class='browseRow'>
                <div class='entry-image'>
                    <a href='recipe.php?id=".$row['ID']."'>
                        <img src='".$imgSrc."' width='180' height='120' alt='".$row['name']."'/>
                    </a>
                </div>

                <h2 class='entry-title'><a href='recipe.php?id=".$row['ID']."'>".$row['name']."</a></h2>

                <div class='entry-data'>
                    <p>Rating: ".number_format($rating,2)."</p>
                    <p>Uploaded by: ".$user[0].' '.$user[1].' '.$user[2]."</p>
                    <p>Time: ".$row['approxTime']."</p>
                </div>

                <div class='summary'>
                    <p>Description: ".$row['description']."</p>
                </div>
            </div>";
        }
    }


    else if ($total == 0) {
        echo "            <hr style='clear:both'>
            <div class='browseRow'>
                <p style='font-size:large'>The search returned no results. Sorry!</p>
            </div>\n";
    }

    else if ($indexOutOfBounds) {
        echo <<<EOF

            <hr style='clear:both'>

            <div class='browseRow'>
                <div style='font-size:large;text-align:center;color: #ff0000;'>Invalid index.</div>
            </div>

EOF;
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
