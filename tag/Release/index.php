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

$tbl = '(SELECT AVG(rating) AS ratings,recipeID FROM Ratings GROUP BY recipeID)q';
$ratingOfDay = $db->select($tbl,"*","ratings>=3.5","","RAND(".$seed.")")->fetch_row();
//picks out random recipe of the day
if ($ratingOfDay != NULL)
    $rowOfDay = $db->select("Recipe","*","ID=".$ratingOfDay[1])->fetch_assoc();
else {
    $rowOfDay = $db->select("Recipe","*","1",'',"RAND(".$seed.")")->fetch_assoc();
    $ratingOfDay = Array($db->getRating($rowOfDay['ID']));
}
$dailyRating = ($ratingOfDay[0] == NULL ? 
        'Not rated yet.' : 
        ($ratingOfDay[0] == floor($ratingOfDay[0]) ? 
            number_format($ratingOfDay[0],0) : 
            number_format($ratingOfDay[0],2))
        .' stars');
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
if ($fastRow == null)
    $fastRow = $db->select('Recipe','*,ID AS recipeID','approxTime <= 30 AND ID <> '.$rowOfDay['ID'],'',$orderBy)->fetch_assoc();

$fastRating = $db->getRating($fastRow['recipeID']);
$fastRating = empty($fastRating) ? 
    'Not rated yet.' : 
    ($fastRating == floor($fastRating) ? 
        number_format($fastRating,0) : 
        number_format($fastRating,2))
    .' stars';
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
                        <a href='recipe.php?id={$rowOfDay['ID']}' style='height:150;width:200;'>
                            <img src='{$imgSrc}' alt='Recipe of the Day: {$rowOfDay['name']}' style='width:200px; height:150px; word-wrap: break-word; border: 0' />
                        </a>\n
                    </div>

                    <div style='position: static;'>
                        <div style='font-size: x-large;'>
                            <a href='recipe.php?id={$rowOfDay['ID']}'>{$rowOfDay['name']}</a>
                        </div>
                        
                        <div><!--
EOF;
                            
    for ($j = 1; $j <= floor($dailyRating) ; $j++)
        echo "--><img class='star' src='starbright.png' alt='{$j} star' /><!--\n";

    if ($j - $dailyRating >= 0.25 && $j - $dailyRating < 0.75) {
        echo "--><img class='star' src='starbrightleft.png' style='width:10px;' alt='{$j} star' /><!--\n";
        echo "--><img class='star' src='stargrayright.png' style='width:10px;' alt='{$j} star' /><!--\n";
        $j++;
    }
    for (; $j <= 5 ; $j++)
        echo "--><img id='star' src='stargray.png' alt='{$j} star' /><!--\n";

    echo <<<EOF
                        --></div>
                        <b>Rating:</b> {$dailyRating}
                        <div style='font-size: small'>
                            <p>
                                Prep Time: {$rowOfDay['approxTime']} minutes<br>
                                Uploaded by: {$userOfDay[0]} {$userOfDay[1]} {$userOfDay[2]}
                            </p>
                        </div>

                        <p>{$rowOfDay['description']}</p>
                    </div>
                </div>

                <hr style='clear:both'>

                <div id='quickRecipe' style='clear: both; padding-top: 10px; padding-bottom: 10px'>
                    <div style='font-size: large;padding-bottom:5px'>In a hurry? Try something easy:</div>

                    <div style='float: right; font-size: medium; width: 200px; height: 150px; border: 1px solid black; margin-left: 5px'>
                        <a href='recipe.php?id={$fastRow['recipeID']}' style='width:200;height=150;'>
                            <img src='{$fastSrc}' alt='Easy Recommendation: {$fastRow['name']}' style='width: 200px; height: 150px; border: 0; word-wrap: break-word' /></a>
                    </div>

                    <div style='position: static'>
                        <div style='font-size: x-large;'>
                            <a href='recipe.php?id={$fastRow['recipeID']}'>{$fastRow['name']}</a>
                        </div>

                        <div><!--
EOF;
                            
    for ($j = 1; $j <= floor($fastRating) ; $j++)
        echo "--><img class='star' src='starbright.png' alt='{$j} star' /><!--\n";

    if ($j - $fastRating >= 0.25 && $j - $fastRating < 0.75) {
        echo "--><img class='star' src='starbrightleft.png' style='width:10px;' alt='{$j} star' /><!--\n";
        echo "--><img class='star' src='stargrayright.png' style='width:10px;' alt='{$j} star' /><!--\n";
        $j++;
    }
    for (; $j <= 5 ; $j++)
        echo "--><img id='star' src='stargray.png' alt='{$j} star' /><!--\n";

    echo <<<EOF
                        --></div>
                        <b>Rating:</b> {$fastRating}
                        <div style='font-size: small'>
                            <p>
                                Prep Time: {$fastRow['approxTime']} minutes<br>
                                Uploaded by: {$fastUser[0]} {$fastUser[1]} {$fastUser[2]}
                            </p>
                        </div>

                        <p>{$fastRow['description']}</p>
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