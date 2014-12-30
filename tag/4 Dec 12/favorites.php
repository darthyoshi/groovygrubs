<?php
/**
 * Author: Kay Choi
 * File: favorites.php
 * Purpose: lists all of a user's favorite recipes
 */

require_once "includes/categories.php";
require_once 'includes/Database.php';
require_once "includes/general.php";
session_start();
$db = new Database();
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
    printheader();

    echo "\n<hr>\n";

    echo "<div id='content'>\n";

    leftsidebar();

    echo "<div class='column-2'>";

    echo "<div id='mainPanel' class='column-2-1'>";

    if(isset($_SESSION['userName'])) {
        $user = $db->select("User","ID","userName='".$_SESSION["userName"]."'")->fetch_assoc();
        $UID = $user['ID'];
        $favorites = $db->select("Favorites", "recipeID", "userID=".$UID,'',"addDate DESC");

echo <<<EOF

    <div id='browseColumn'>

        <div id="browseHeader" style="font-size: x-large">
            <p style='text-align:center'>Your Favorite Recipes</p>
        </div>

        <div id="browseBody">

EOF;

        if(mysqli_num_rows($favorites) == 0)
echo <<<EOF

            <p style='font-size:large;text-align:center'>You currently do not have any favorite recipes.</p>
        </div>
    </div>

EOF;

        else {
echo <<<EOF

EOF;
            while($row = mysqli_fetch_row($favorites)){
                $recipe = $db->select("Recipe", "*", "ID=".$row[0])->fetch_assoc();
                $rating = $db->select("Ratings","AVG(rating)","recipeID=".$recipe['ID'])->fetch_row();
                $image = $db->select("Picture", "image,name", "recipeID=".$recipe['ID'])->fetch_row();
                $imageExt = pathinfo($image[1], PATHINFO_EXTENSION);
                $user = $db->select("User","firstName,middleName,lastName","ID=".$recipe['userID'])->fetch_row();

echo "            <hr>
            <div class='browseRow'>
                <div class='entry-image'>
                    <a href='recipe.php?id=".$row[0]."' style='height: 120; width: 180'>
                        <img src='data:image/".$imageExt.";base64,".base64_encode($image[0])."' style='width:180px; height:120px; border: 0; word-wrap: break-word' alt='"
                        .$recipe['name']."'/>
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

echo "        </div>
    </div>";

        }
    }

    else{
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

    rightsidebar();

        echo "\n</div>\n";
    echo "</div>\n";

    footer();
?>

</body>
</html>
