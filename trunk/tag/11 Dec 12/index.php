<?php
/**
 * Author: Kay Choi
 * File: index.php
 * Purpose: main webpage
 */

require_once "includes/Database.php";
require_once "includes/categories.php";
require_once "includes/template.php";

session_start();
$date = getdate();
$seed = $date['yday']+$date['year'];
$db = new Database();

$ratingOfDay = $db->select("Ratings","recipeID,AVG(rating) AS ratings","rating>=3.5","recipeID","RAND(".$seed.")")->fetch_row();
//picks out random recipe of the day
if ($ratingOfDay != NULL)
    $rowOfDay = $db->select("Recipe","*","ID=".$ratingOfDay[0])->fetch_assoc();
else {
    $rowOfDay = $db->select("Recipe","*","1",'',"RAND(".$seed.")")->fetch_assoc();
    $ratingOfDay = $db->select("Ratings","recipeID,AVG(rating) AS ratings","recipeID=".$rowOfDay['ID'],"recipeID","")->fetch_row();
}

$userOfDay = $db->select("User","firstName,middleName,lastName","ID=".$rowOfDay['userID'])->fetch_row();
$imageOfDay = $db->select("Picture","image,name","recipeID=".$rowOfDay['ID'])->fetch_row();
if (!empty($imageOfDay) && $imageOfDay[1] != '')
    $imgExt = pathinfo($imageOfDay[1], PATHINFO_EXTENSION);
$imgSrc = (empty($imageOfDay) || $imageOfDay[1] == '') ?
    "recipe_pictures/default.jpg" :
    "data:image/".$imgExt.";base64,".base64_encode($imageOfDay[0]);

$tbl = 'Recipe LEFT JOIN Ratings ON Recipe.ID = Ratings.recipeID';
$fields = '*';
$rule = 'Recipe.approxTime <= 30 AND Ratings.rating >= 3.5 AND Recipe.ID <> '.$rowOfDay['ID'];
$orderBy = 'RAND('.$seed.') LIMIT 1';
$fastRow = $db->select($tbl,$fields,$rule,'',$orderBy)->fetch_assoc();

$fastRating = $db->getRating($fastRow['recipeID']);
$fastImage = $db->getImage($fastRow['recipeID']);
if (!empty($fastImage) && $fastImage['fileSize'] > 0)
    $fastExt = pathinfo($fastImage['name'], PATHINFO_EXTENSION);
$fastSrc = (empty($fastImage) || $fastImage['fileSize'] == 0) ?
    "recipe_pictures/default.jpg" :
    "data:image/".$fastExt.";base64,".base64_encode($fastImage['image']);
$fastUser = $db->select("User","firstName,middleName,lastName","ID=".$fastRow['userID'])->fetch_row();
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
    <title>GroovyGrubs.com</title>
    <script src="includes/general.js"></script>
</head>

<body id="body">
<?php
    printHeader();

    echo "\n<hr>\n";

    echo "<div id='content'>\n";

    printLeftSideBar();

    echo <<<EOF

        <div class='column-2'>
            <div id='mainPanel' class='column-2-1'>
                <div style='text-align: center'>
                    <div style="font-size: xx-large; font-style: italic">
                        Welcome to GroovyGrubs.com
                    </div>

                    <div>
                        SFSU CSc640 - F12 Group 6 project
                    </div>
                </div>

                <div id='recipeOfTheDay' style='padding-top: 10px; padding-bottom: 10px'>
                    <div style='font-size: large;padding-top:5px;padding-bottom:5px'>Recipe of the Day:</div>

                    <div style='float: left; font-size: medium; width: 200px; height: 150px; border: 1px solid black; margin-right: 5px'>
EOF;

    echo "                        <a href='recipe.php?id=".$rowOfDay['ID']."' style='height:150;width:200;'>
                            <img src='".$imgSrc."' alt='Recipe of the Day: "
        .$rowOfDay['name']."' style='width:200px; height:150px; word-wrap: break-word; border: 0' />
                        </a>\n";
    echo <<<EOF
                    </div>

                    <div style='position: static;'>
                        <div style='font-size: x-large;'>
EOF;

    echo "<a href='recipe.php?id=".$rowOfDay['ID']."'>".$rowOfDay['name']."</a>".
        "</div>\n";

    echo "Rating: ".
        (($ratingOfDay[1]==NULL)?"<small>No one has rated this recipe yet. Be the first!</small>":number_format($ratingOfDay[1],2)).
        "\n        <div style='font-size: small'>
            <p>
                Prep Time: ".$rowOfDay['approxTime']." minutes<br>
                Uploaded by: ".$userOfDay[0].' '.$userOfDay[1].' '.$userOfDay[2]."
            </p>
        </div>

                        <p>".$rowOfDay['description']."</p>\n";

    echo <<<EOF
                    </div>
                </div>

                <hr style='clear:both'>

                <div id='quickRecipe' style='clear: both; padding-top: 10px; padding-bottom: 10px'>
                    <div style='font-size: large;padding-bottom:5px'>In a hurry? Try something easy:</div>

                    <div style='float: right; font-size: medium; width: 200px; height: 150px; border: 1px solid black; margin-left: 5px'>
EOF;

    echo "                    <a href='recipe.php?id=".$fastRow['recipeID']."' style='width:200;height=150;'>
                        <img src='".$fastSrc."' alt='Easy Recommendation: ".$fastRow['name']
    ."' style='width: 200px; height: 150px; border: 0; word-wrap: break-word' /></a>\n";

    echo <<<EOF
                    </div>

                    <div style='position: static'>
                        <div style='font-size: x-large;'>
EOF;

    echo "<a href='recipe.php?id=".$fastRow['recipeID']."'>".$fastRow['name']."</a>".
        "</div>\n";

    echo "Rating: ".
        (!isset($fastRating)?"<small>Oops! No ratings yet. Be the first to rate this recipe!</small>":number_format($fastRating,2)).
        "<div style='font-size: small'>
            <p>
                Prep Time: ".$fastRow['approxTime']." minutes<br>
                Uploaded by: ".$fastUser[0].' '.$fastUser[1].' '.$fastUser[2]."
            </p>
        </div>

                        <p>".$fastRow['description']."</p>\n";
    echo <<<EOF
                    </div>
                </div>


            </div>
EOF;

    printRightSideBar();

    echo <<<EOF
        </div>
    </div>
EOF;

    printFooter();
?>

</body>
</html>