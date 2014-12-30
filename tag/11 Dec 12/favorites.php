<?php
/**
 * Author: Kay Choi
 * File: favorites.php
 * Purpose: lists all of a user's favorite recipes
 */

require_once "includes/categories.php";
require_once 'includes/Database.php';
require_once "includes/template.php";
session_start();
$db = new Database();

$pageNo = isset($_GET['page']) ? $_GET['page'] : 1;
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
    <title>Favorite Recipes - GroovyGrubs.com</title>
    <script src="includes/general.js"></script>
</head>

<body id="body">
<?php
    printHeader();

    echo "\n<hr>\n";

    echo "<div id='content'>\n";

    printLeftSideBar();

    echo "<div class='column-2'>";

    echo "<div id='mainPanel' class='column-2-1'>";

    if(isset($_SESSION['userName'])) {
        $user = $db->select("User","ID","userName='".$_SESSION["userName"]."'")->fetch_assoc();
        $UID = $user['ID'];
        $total = $db->select("Favorites", "recipeID", "userID=".$UID)->num_rows;
        $lastPageNo = floor($total/5) + 1;
        $indexOutOfBounds = $pageNo > $lastPageNo || $pageNo < 1;
        if (!$indexOutOfBounds)
            $favorites = $db->select("Favorites", "recipeID", "userID=".$UID,'',"addDate DESC LIMIT ".(5*($pageNo-1)).",5");

        echo <<<EOF

    <div id='browseColumn'>

        <div id="browseHeader" style='font-size: x-large; text-align:center'>Your Favorite Recipes
        </div>

        <div id="browseBody">

EOF;

        echo "<div style='font-size:large;float:left'><form action='favorites.php' method='GET'>Page ".$pageNo." of ".$lastPageNo."</div>\n";

        echo "<div style='float:right'>Go to: |&larr; First\n";
//        echo "<input type='hidden name='browse' value='".$_GET['browse']."'>";
        echo "<input type='text' name='page' value='' size='2' /><button type='submit'>Go!</button>\n";
        echo "Last &rarr;| </form></div>
            <hr style='clear:both'>";

        if ($indexOutOfBounds)
            echo <<<EOF

            <div class='browseRow'>
                <div style='font-size:large;text-align:center'>Invalid index.</div>
            </div>
        </div>
    </div>

EOF;

        else if ($total == 0)
            echo <<<EOF

            <div class='browseRow'>
                <div style='font-size:large;text-align:center'>You currently do not have any favorite recipes.</div>
            </div>
        </div>
    </div>

EOF;

        else {
            while($row = mysqli_fetch_row($favorites)){
                $recipe = $db->select("Recipe", "*", "ID=".$row[0])->fetch_assoc();
                $rating = $db->select("Ratings","AVG(rating)","recipeID=".$recipe['ID'])->fetch_row();
                $imageRow = $db->select("Picture", "image,name", "recipeID=".$recipe['ID'])->fetch_row();
                $imgExt = pathinfo($imageRow[1], PATHINFO_EXTENSION);
                $user = $db->select("User","firstName,middleName,lastName","ID=".$recipe['userID'])->fetch_row();

                $imgSrc = ($imageRow == NULL ||  $imageRow[0] == '') ?
                    'recipe_pictures/default.jpg' :
                    "data:image/".$imgExt.";base64,".base64_encode($imageRow[0]);

                echo "            <div class='browseRow'>
                <div class='entry-image'>
                    <a href='recipe.php?id=".$recipe['ID']."'>
                        <img src='".$imgSrc."' width='180' height='120' alt='".$recipe['name']."'/>
                    </a>
                </div>

                <div style='float:right'>
                    <form action='includes/Actions.php?ops=deleteFav' method='POST'>
                        <input type='hidden' id='deleteID' name='deleteID' value='".$recipe['ID']."'/>
                        <input type='hidden' id='UID' name='UID' value='".$_SESSION['id']."'/>
                        <input type='button' value='Remove this recipe from your favorites' onClick='deleteFavorite();'/>
                    </form>
                </div>

                <h2 class='entry-title'><a href='recipe.php?id=".$recipe['ID']."'>".$recipe['name']."</a></h2>

                <div class='entry-data'>
                    <p>Rating: ".number_format($rating[0],2)."</p>
                    <p>Uploaded by: ".$user[0].' '.$user[1].' '.$user[2]."</p>
                    <p>Time: ".$recipe['approxTime']." minutes</p>
                </div>

                <div class='summary'>
                    <p>".$recipe['description']."</p>
                </div>
            </div>\n";
            }

        echo "        </div>
    </div>";

        }
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
    echo "</div>";

    printRightSideBar();

        echo "\n</div>\n";
    echo "</div>\n";

    printFooter();

    if (isset($_GET['delete']))
        echo "<script type='text/javascript'>alert('The recipe has been successfully removed from your favorites list.');</script>";
?>

</body>
</html>
