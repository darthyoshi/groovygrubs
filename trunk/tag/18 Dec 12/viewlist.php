<?php
/**
 * Author: Kay Choi
 * File: viewlist.php
 * Purpose: lists recipes associated with a user
 */

require_once "includes/categories.php";
require_once 'includes/Database.php';
require_once "includes/template.php";
session_start();
$db = new Database();

$pageNo = isset($_GET['page']) ? $_GET['page'] : 1;
$type = isset($_GET['type']) ? $_GET['type'] : 'none';
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
    <title>Favorite Recipes - GroovyGrubs.com</title>
    <script src="includes/general.js"></script>
    <script src="includes/jquery-1.8.2.min.js"></script>
</head>

<body id="body">
<?php
    printHeader();

    echo "\n<hr>\n";

    echo "<div id='content'>\n";

    printLeftSideBar();

    echo "<div class='column-2'>";

    echo "<div id='mainPanel' class='column-2-1'>";

    if (isset($_SESSION['userName']) && $type != 'none') {
        $user = $db->select("User","ID","userName='{$_SESSION["userName"]}'")->fetch_assoc();
        $UID = $user['ID'];

        switch ($type) {
            case 'favorite':
                $typeTitle = "Favorite";
                break;
            case 'upload':
                $typeTitle = 'Uploaded';
                break;
            case 'rating':
                $typeTitle = 'Rated';
                break;
            default:
                $typeTitle = '';
        }

        if ($type == 'favorite') {
            $tbl = "Favorites";
            $field = "recipeID";
            $rule = "userID=".$UID;
            $order = "addDate DESC LIMIT ".(5*($pageNo-1)).",5";
        }
        else if ($type == 'upload') {
            $tbl = "Recipe";
            $field = "ID";
            $rule = "userID=".$UID;
            $order = "uploadDate DESC LIMIT ".(5*($pageNo-1)).",5";
        }
        else if ($type == 'rating') {
            $tbl = "Ratings";
            $field = "recipeID";
            $rule = "raterID=".$UID;
            $order = "recipeID DESC LIMIT ".(5*($pageNo-1)).",5";
        }

        $total = $db->select($tbl, $field, $rule)->num_rows;
        if ($total == 0)
            $lastPageNo = $pageNo = 0;
        else
            $lastPageNo = floor(($total-1)/5)+1;
        $indexOutOfBounds = $pageNo > $lastPageNo || $pageNo < 1;
        if (!$indexOutOfBounds)
            $favorites = $db->select($tbl, $field, $rule,'',$order);

        $navbar0 = ($pageNo != 1 && $total > 0 ?
                "<a href='viewlist.php?type={$type}&amp;page=1'>|&laquo;First</a>" :
                "|&laquo;First");
        $navbar1 = (!$indexOutOfBounds && $pageNo > 1 ?
                "<a href='viewlist.php?type={$type}&amp;page=".($pageNo-1)."'>&larr;Prev</a>" :
                "&larr;Prev");
        $navbar2 = (!$indexOutOfBounds && $pageNo < $lastPageNo ?
                "<a href='viewlist.php?type={$type}&amp;page=".($pageNo+1)."'>Next&rarr;</a>" :
                "Next&rarr;");
        $navbar3 = ($pageNo != $lastPageNo ?
                "<a href='viewlist.php?type={$type}&amp;page={$lastPageNo}'>Last&raquo;|</a>" :
                "Last&raquo;|");

        echo <<<EOF
    <div id='browseColumn'>

        <div id='browseHeader' style='font-size: x-large; text-align:center'>
            Your {$typeTitle} Recipes
        </div>

        <div id='browseBody'>
            <div style='font-size:large;float:left'>Page {$pageNo} of {$lastPageNo}</div>

            <form style='float:right' action='viewlist.php' method='GET'>
                <label for='page'>Go to:</label>
                    {$navbar0}
                    {$navbar1}
                    {$navbar2}
                    {$navbar3}
                <input type='hidden' name='type' value='{$type}'><!--
                --><input type='text' id='page' name='page' value='' size='1' /><!--
                --><button type='submit'>Go!</button>
            </form>

EOF;

        if ($total == 0) {
            if ($type == 'favorite')
                $emptyMsg = "You currently have no favorite recipes.";
            elseif ($type == 'upload')
                $emptyMsg = "You currently have not uploaded any recipes.";
            elseif ($type == 'rating')
                $emptyMsg = "You currently have not rated any recipes.";

            echo <<<EOF

            <hr style='clear:both'>

            <div class='browseRow'>
                <div style='font-size:large;text-align:center;'>
                    {$emptyMsg}
                </div>
            </div>
        </div>
    </div>

EOF;
        }

        else if ($indexOutOfBounds) {
            echo <<<EOF

            <hr style='clear:both'>

            <div class='Row'>
                <div style='font-size:large;text-align:center;color: #ff0000;'>Invalid index.</div>
            </div>
        </div>
    </div>

EOF;
        }

        else {
            while ($row = mysqli_fetch_row($favorites)){
                $recipe = $db->select("Recipe", "*", "ID=".$row[0])->fetch_assoc();
                $rating = number_format($db->getRating($recipe['ID']));
                $imageRow = $db->select("Picture", "image,name", "recipeID=".$recipe['ID'])->fetch_row();
                $imgExt = pathinfo($imageRow[1], PATHINFO_EXTENSION);
                $user = $db->select("User","firstName,middleName,lastName","ID=".$recipe['userID'])->fetch_row();

                $imgSrc = ($imageRow == NULL ||  $imageRow[0] == '') ?
                    'recipe_pictures/default.jpg' :
                    "data:image/{$imgExt};base64,".base64_encode($imageRow[0]);

                echo <<<EOF
            <hr style='clear:both'>

            <div class='browseRow'>
                <div class='entry-image'>
                    <a href='recipe.php?id={$recipe['ID']}'>
                        <img src='{$imgSrc}' width='180' height='120' alt='{$recipe['name']}'/>
                    </a>
                </div>

EOF;

                if ($type == 'favorite') {
                    echo <<<EOF
                <div style='float:right'>
                    <form action='includes/Actions.php?ops=deleteFav' method='POST'>
                        <input type='hidden' id='deleteID' name='deleteID' value='{$recipe['ID']}'/>
                        <input type='hidden' id='UID' name='UID' value='{$_SESSION['id']}'/>
                        <input type='button' value='Remove this recipe from your favorites' onClick='deleteFavorite()'/>
                    </form>
                </div>
EOF;
                }

                echo <<<EOF
                <h2 class='entry-title'><a href='recipe.php?id={$recipe['ID']}'>{$recipe['name']}</a></h2>

                <div class='entry-data'>
                    <p>Rating: {$rating}</p>
                    <p>Uploaded by: {$user[0]} {$user[1]} {$user[2]}</p>
                    <p>Time: {$recipe['approxTime']} minutes</p>
                </div>

                <div class='summary'>
                    <p>{$recipe['description']}</p>
                </div>
            </div>

EOF;
            }

        echo "        </div>
    </div>\n";

        }
    }

    else if ($type == 'none') {
        echo "        <p style='text-align: center; color: #ff0000;'>Invalid view selection.</p>";
    }

    else {
        echo <<<EOF

        <p style='text-align: center; color: #ff0000;'>You must be logged in to view your favorites.</p>

        <div class ='column-2-3'>
            <form id="logonForm" action="login.php" method="POST"><table style = 'text-align: right;'>
            <tbody><tr><td>
                    <label for="userName">E-mail</label>
                        <input type="text" id="userName" name="userName" size="30">
                    </td></tr>

                    <tr><td>
                        <label for="userPass">Password</label>
                        <input type="password" id="userPass" name="userPass" size="30">
                    </td></tr>

                    <tr><td>
                        <small><a href="forgot.php">Forgot your password?</a></small>
                        <button type="submit">Login</button>
                    </td></tr>
                </tbody>
            </table></form>
        </div>

EOF;
    }
echo "    </div>";

    printRightSideBar();

        echo "\n        </div>
    </div>\n";

    printFooter();
?>

</body>
</html>
