<?php
/**
 * Author: Victor Tobar, Kay Choi
 * File: browse.php
 * Purpose: webpage for browsing recipes
 */

require_once "includes/categories.php";
require_once "includes/template.php";
require_once "includes/Search.php";
session_start();
ob_start();
$searchC = new Search();
$db = new Database();
$catLabels = getCatLabels();
$browse = isset($_GET['browse'])?$_GET['browse']:"all";
$pageNo = isset($_GET['page']) ? $_GET['page'] : 1;
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
    <title>Browse Recipes - GroovyGrubs.com</title>
    <script src="includes/general.js"></script>
</head>

<body id="body">
<?php
    printHeader();

    echo "\n<hr>\n";

    echo "<div id='content'>\n";

    printLeftSideBar();

    echo "<div class='column-2'>";

    $results = $searchC->searchByCategory($browse);
    $total = count($results);

    if ($total == 0)
        $lastPageNo = $pageNo = 0;
    else
        $lastPageNo = floor(($total-1)/5)+1;
    $indexOutOfBounds = $pageNo > $lastPageNo || $pageNo < 1;

    $navbar0 = ($pageNo != 1 && $total > 0 ?
            "<a href='browse.php?browse={$browse}&amp;page=1'>|&laquo;First</a>" :
            "|&laquo;First");
    $navbar1 = (!$indexOutOfBounds && $pageNo > 1 ?
            "<a href='browse.php?browse={$browse}&amp;page=".($pageNo-1)."'>&larr;Prev</a>" :
            "&larr;Prev");
    $navbar2 = (!$indexOutOfBounds && $pageNo < $lastPageNo ?
            "<a href='browse.php?browse={$browse}&amp;page=".($pageNo+1)."'>Next&rarr;</a>" :
            "Next&rarr;");
    $navbar3 = ($pageNo != $lastPageNo ?
            "<a href='browse.php?browse={$browse}&amp;page=".$lastPageNo."'>Last&raquo;|</a>" :
            "Last&raquo;|");
    
    echo "<div id='mainPanel' class='column-2-1'>
    <div id='browseColumn'>
    	<div id='browseHeader' style='font-size: x-large; text-align:center'>
            Browsing Recipes - {$catLabels[$browse]}
        </div>

        <div id='browseBody'>
            <div style='font-size:large;float:left'>Page {$pageNo} of {$lastPageNo}</div>

            <form style='float:right' action='browse.php' method='GET'>
                <label for='page'>Go to:</label>
                    {$navbar0}
                    {$navbar1}
                    {$navbar2}
                    {$navbar3}
                <input type='hidden' name='browse' value='{$browse}'><!--
                --><input type='text' id='page' name='page' value='' size='1' /><!--
                --><button type='submit'>Go!</button>
            </form>";

    if ($total > 0 && !$indexOutOfBounds) {
        //todo: possibly rewrite search algorithm to handle the following database calls with a single function call
        for ($i = 5*($pageNo-1); $i < 5*$pageNo && $i < $total; $i++){
            $recipe = $results[$i];
            $rating = $db->getRating($recipe['ID']);
            $rating = empty($rating) ? 
                'Not rated yet.' : 
                ($rating == floor($rating) ? 
                    number_format($rating,0) : 
                    number_format($rating,2))
                .' stars';
            $imageRow = $db->select("Picture", "image,name", "recipeID=".$recipe['ID'])->fetch_row();
            if (!empty($imageRow) && $imageRow[1] != '')
                $imageExt = pathinfo($imageRow[1], PATHINFO_EXTENSION);
            $user = $db->select("User","firstName,middleName,lastName","ID=".$recipe['userID'])->fetch_row();

            $imgSrc = (empty($imageRow) || $imageRow[1] == '') ?
                "recipe_pictures/default.jpg" :
                "data:image/{$imageExt};base64,".base64_encode($imageRow[0]);

            echo "            <hr style='clear:both'>

            <div class='browseRow'>
                <div class='entry-image'>
                    <a href='recipe.php?id={$recipe['ID']}'>
                        <img src='{$imgSrc}' width='180' height='120' alt='{$recipe['name']}'/>
                    </a>
                </div>

                <h2 class='entry-title'><a href='recipe.php?id={$recipe['ID']}'>{$recipe['name']}</a></h2>

                <div class='entry-data'>
                
                    <div><!--";
                for ($j = 1; $j <= floor($rating) ; $j++)
                    echo "--><img class='star' src='starbright.png' alt='{$j} star' /><!--\n";

                if ($j - $rating >= 0.25 && $j - $rating < 0.75) {
                    echo "--><img class='star' src='starbrightleft.png' style='width:10px;' alt='{$j} star' /><!--\n";
                    echo "--><img class='star' src='stargrayright.png' style='width:10px;' alt='{$j} star' /><!--\n";
                    $j++;
                }
                for (; $j <= 5 ; $j++)
                    echo "--><img id='star' src='stargray.png' alt='{$j} star' /><!--\n";
                
                echo "                    --></div>
                    <p><b>Rating:</b> {$rating}</p>
                    <p>Uploaded by: {$user[0]} {$user[1]} {$user[2]}</p>
                    <p>Preparation Time: {$recipe['approxTime']} minutes</p>
                </div>

                <div class='summary'>
                    <p>{$recipe['description']}</p>
                </div>
            </div>\n";
        }
    }

    else if ($total == 0) {
        echo "            <hr style='clear:both'>
            <div class='browseRow'>
                <p style='font-size:large'>There are no recipes in this category. Sorry!</p>
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

echo <<<EOF

        </div>
    </div>
</div>

EOF;

    printRightSideBar();
    echo "\n</div>\n";
    echo "</div>\n";
    printFooter();
?>

</body>
</html>