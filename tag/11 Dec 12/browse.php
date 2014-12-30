<?php
/**
 * Author: Victor Tobar
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

    $results = $searchC->searchByCategory($browse,$pageNo);

    echo "<div id='mainPanel' class='column-2-1'>
    <div id='browseColumn'>
    	<div id='browseHeader' style='font-size: x-large'>
            <p>".$catLabels[$browse]." Recipes - "
            .count($results)." recipes found</p>
        </div>

        <div id='browseBody'>";

    if(count($results) > 0) {
        //todo: possibly rewrite search algorithm to handle the following database calls with a single function call
        for($i = 0; $i < count($results); $i++){
            $recipe = $results[$i];
            $rating = $db->select("Ratings","AVG(rating)","recipeID=".$recipe['ID'])->fetch_row();
            $imageRow = $db->select("Picture", "image,name", "recipeID=".$recipe['ID'])->fetch_row();
            if (!empty($imageRow) && $imageRow[1] != '')
                $imageExt = pathinfo($imageRow[1], PATHINFO_EXTENSION);
            $user = $db->select("User","firstName,middleName,lastName","ID=".$recipe['userID'])->fetch_row();

            $imgSrc = (empty($imageRow) || $imageRow[1] == '') ?
                "recipe_pictures/default.jpg" :
                "data:image/".$imageExt.";base64,".base64_encode($imageRow[0]);

            echo "            <hr>
            <div class='browseRow'>
                <div class='entry-image'>
                    <a href='recipe.php?id=".$recipe['ID']."'>
                        <img src='".$imgSrc."' width='180' height='120' alt='".$recipe['name']."'/>
                    </a>
                </div>

                <h2 class='entry-title'><a href='recipe.php?id=".$recipe['ID']."'>".$recipe['name']."</a></h2>

                <div class='entry-data'>
                    <p>Rating: ".$rating[0]."</p>
                    <p>Uploaded by: ".$user[0].' '.$user[1].' '.$user[2]."</p>
                    <p>Time: ".$recipe['approxTime']." minutes</p>
                </div>

                <div class='summary'>
                    <p>".$recipe['description']."</p>
                </div>
            </div>\n";
        }
    }

    else
        echo "            <hr>
            <div class='browseRow'>
                <p style='font-size:large'>There are no recipes in this category. Sorry!</p>
            </div>\n";

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