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
srand($date['yday']);
$db = new Database();

$numRecipes = $db->select("Recipe","COUNT(ID) AS numRecipes","1")->fetch_assoc();
$recipeOfDay = rand()%$numRecipes['numRecipes'];
$row = $db->select("Recipe","*","1 LIMIT ".$recipeOfDay.','.$recipeOfDay)->fetch_assoc();
$rating = $db->select("Ratings","AVG(rating)","recipeID=".$row['ID'])->fetch_row();
$user = $db->select("User","firstName,middleName,lastName","ID=".$row['userID'])->fetch_row();
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
                    <div style="font-size: xx-large">
                        Welcome to GroovyGrubs.com
                    </div>

                    <div style="font-size: large">
                        the place to find food for students, by students, and of students
                    </div>
                </div>

                <div style='padding-top: 10px; padding-bottom: 10px'>
                    <div style='font-size: large'>Recipe of the Day:</div>

                    <div style='float: left; font-size: medium; width: 200px; height: 150px; border: 1px solid black'>
EOF
    ."<a href='recipe.php?".$row['ID']."'>
                        <img src='' alt='Recipe of the Day: ".$row['name']."' width=200 height=150></a>\n";
echo <<<EOF
                    </div>

                    <div style='position: relative; left: 5px'>
                        <div style='font-size: x-large;'>
EOF;
    echo "<a href='recipe.php?".$row['ID']."'>".$row['name']."</a>"
        ."</div>\n"
        ."Rating: ".$rating[0]
        ."\n        <div style='font-size: small'>
            <p>Submitted by: ".$user[0].' '.$user[1].' '.$user[2]."</p>
        </div>

                        <p>".$row['description']."</p>\n";
echo <<<EOF
                    </div>
                </div>

                <div style='clear: both; padding-top: 10px; padding-bottom: 10px'>
                    <hr>
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