<?php
/**
 * Author: Kay Choi
 * File: index.php
 * Purpose: main webpage
 */

require_once "includes/Database.php";
require_once "includes/categories.php";
require_once "includes/general.php";

session_start();
$date = getdate();
$seed = $date['yday']+$date['year'];
$db = new Database();

//picks out random recipe of the day
$ratingOfDay = $db->select("Ratings","recipeID,AVG(rating) AS ratings","rating>=3.5","recipeID","RAND(".$seed.")")->fetch_row();
$rowOfDay = $db->select("Recipe","*","ID=".$ratingOfDay[0])->fetch_assoc();
$userOfDay = $db->select("User","firstName,middleName,lastName","ID=".$rowOfDay['userID'])->fetch_row();
$imageOfDay = $db->select("Picture","image,name","recipeID=".$rowOfDay['ID'])->fetch_row();
$imgExt = pathinfo($imageOfDay[1], PATHINFO_EXTENSION);

//picks out random recipe with prep time < 30 min - currently doesn't work
if ($db->select("Recipe INNER JOIN Ratings","COUNT(Recipe.ID)","Recipe.approxTime<=30 AND Recipe.ID=Ratings.recipeID","Recipe.ID",'')->num_rows > 0) {
    $fastRecipe = $db->select("(SELECT Recipe.ID AS ID, "
        ."AVG(Ratings.rating) AS ratings "
        ."FROM Recipe "
        ."INNER JOIN Ratings "
        ."WHERE Recipe.approxTime<=30 AND Recipe.ID=Ratings.recipeID "
        ."GROUP BY Recipe.ID)q",
    "ID", "ratings>=3.5", '', "RAND(".$seed.")")->fetch_row();
    $fastRow = $db->select("Recipe","*","ID=".$fastRecipe[0])->fetch_assoc();
}
else
    $fastRow = $db->select("Recipe","*","approxTime<=30",'','RAND('.$seed.')')->fetch_assoc();

$fastImage = $db->select("Picture","image,name","recipeID=".$fastRow['ID'])->fetch_row();
$fastExt = pathinfo($fastImage[1], PATHINFO_EXTENSION);
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
    printheader();

    echo "\n<hr>\n";

    echo "<div id='content'>\n";

    leftsidebar();

echo <<<EOF

        <div class='column-2'>
            <div id='mainPanel' class='column-2-1'>
                <div style='text-align: center'>
                    <div style="font-size: xx-large; font-style: italic">
                        Welcome to GroovyGrubs.com
                    </div>

                    <div style="font-size: large">
                        we have recipes
                    </div>
                </div>

                <div id='recipeOfTheDay' style='padding-top: 10px; padding-bottom: 10px'>
                    <div style='font-size: large;padding-top:5px;padding-bottom:5px'>Recipe of the Day:</div>

                    <div style='float: left; font-size: medium; width: 200px; height: 150px; border: 1px solid black; margin-right: 5px'>
EOF;

echo "                        <a href='recipe.php?id=".$rowOfDay['ID']."' style='height:150;width:200;'>
                            <img src='data:image/".$imgExt.";base64,".base64_encode($imageOfDay[0])."' alt='Recipe of the Day: "
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
        (($ratingOfDay[1]==NULL)?"<small>Oops! No ratings yet. Be the first to rate this recipe!</small>":number_format($ratingOfDay[1],2)).
        "\n        <div style='font-size: small'>
            <p>Uploaded by: ".$userOfDay[0].' '.$userOfDay[1].' '.$userOfDay[2]."</p>
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

echo "                    <a href='recipe.php?id=".$fastRow['ID']."' style='width:200;height=150;'>
                        <img src='data:image/".$fastExt.";base64,".base64_encode($fastImage[0])."' alt='Easy Recommendation: ".$fastRow['name']
    ."' style='width: 200px; height: 150px; border: 0; word-wrap: break-word' /></a>\n";

echo <<<EOF
                    </div>

                    <div style='position: static'>
                        <div style='font-size: x-large;'>
EOF;

    echo "<a href='recipe.php?id=".$fastRow['ID']."'>".$fastRow['name']."</a>".
        "</div>\n";

    echo "Estimated Prep Time: ".$fastRow['approxTime']." minutes".
        "\n        <div style='font-size: small'>
            <p>Uploaded by: ".$fastUser[0].' '.$fastUser[1].' '.$fastUser[2]."</p>
        </div>

                        <p>".$fastRow['description']."</p>\n";
echo <<<EOF
                    </div>
                </div>


            </div>
EOF;

    rightsidebar();

echo <<<EOF
        </div>
    </div>
EOF;

    footer();
?>

</body>
</html>