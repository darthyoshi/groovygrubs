<?php

/**
 * Author: James Latief
 * File: recipe.php
 * Purpose: recipe page
 */

require_once "includes/categories.php";
require_once "includes/template.php";
require_once "includes/Search.php";
session_start();

$db = new Database();

$validRecipe = isset($_GET['id']);
do if ($validRecipe) {
    $recipe      = $db->select('Recipe','*','ID="'.$_GET['id'].'"')->fetch_assoc();
    if ($recipe == NULL) {
        $validRecipe = false;
        break;
    }
    $picture     = $db->getImage($recipe['ID']);
    $user        = $db->select('User','*','ID="'.$recipe['userID'].'"')->fetch_assoc();
    $description = stripslashes($recipe['description']);
    $rating      = $db->getRating($recipe['ID']);
    $rating 	 = empty($rating) ? '<span id="notifyRating">No one has rated this recipe yet. Be the first!</span>' : number_format($db->getRating($recipe['ID']),2);
    $serves      = stripslashes($recipe['serves']);
    $time        = stripslashes($recipe['approxTime']);
    $ingredients = $db->select('Ingredients','*','recipeID='.$recipe['ID']);
    $servingSize = isset($_POST['servingSize']) ? $_POST['servingSize'] : $serves;

    if (empty($picture))
        $imgSrc = "recipe_pictures/default.jpg";
    else if ($picture['image'] == '')
        $imgSrc = "recipe_pictures/default.jpg";
    else
        $imgSrc = "data:image/jpeg;base64,".base64_encode($picture['image']);
}while (false);
?>
<!DOCTYPE HTML>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
    <title><?=$recipe['name']?> - GroovyGrubs.com</title>
    <script src="includes/general.js"></script>
    <script src="includes/jquery-1.8.2.min.js"></script>
    <style>
        html .fb_share_button {
            display: -moz-inline-block;
            display:inline-block;
            padding:1px 20px 0 5px;
            height:15px;
            border:1px solid #d8dfea;
            background:url(http://static.ak.facebook.com/images/share/facebook_share_icon.gif?6:26981) no-repeat top right;
        }
        html .fb_share_button:hover {
            color:#fff;
            border-color:#295582;
            background:#3b5998 url(http://static.ak.facebook.com/images/share/facebook_share_icon.gif?6:26981) no-repeat top right;
            text-decoration: none;
        }
    </style>
</head>

<body id="body">
<?php
    printHeader();

    echo "\n<hr>\n";

    echo "<div id='content'>\n";

    printLeftSideBar();

    echo "    <div class='column-2'>";

?>
            <div id="mainPanel" class="column-2-1">
            <?php
            if ($validRecipe) {
            ?>
                <div style='font-size: x-large; text-align: center'>
                    <?=$recipe['name']?><br>
                </div>

                <a href="<?=$imgSrc?>" target="blank">
                    <img src="<?=$imgSrc?>" alt="Recipe image" style="padding: 5px; float: left; border:  1px  solid #000000; width:200px; height:150px; ">
                </a>

				<div id ="mainPanelA" class="column-2-1-1">
                    <p style="text-align: left; font-size: medium">
                        <b>Rating:</b>
                        <?
                        echo  $rating;
                        ?>
					</p>
                    <p>
                        <?
                        if (isset($_SESSION['id'])) {
                            echo '<input id="rating">';
                            echo '<input type="button" value="Rate" onclick="rate(\''.$_GET['id'].'\',\''.$_SESSION['id'].'\')"';
                        }
                        else
                            echo "<small>Login to rate this recipe!</small>";
                        ?>
                    </p>
					<div style="font-size: medium"><p><b>  Submitted by:</b> <?=$user['firstName']." ".$user['middleName']." ".$user['lastName']?></p></div>

					<p><b> Recipe description:</b></p>
					<div id = "mainPanelB" class = "column-2-1-2" style ='font-size: 12;'>
					<?=$description?><br><br></div>

                    <?php
                    echo "<form name='servingInput' action='recipe.php?id=".$recipe['ID']."' method='POST' style='clear:both'>
                            <label for='servingSize' style='font-weight:bold'>Serves: </label>
                            <input type='text' size='3' name='servingSize' id='servingSize' value='".$servingSize."' />
                            <button type='submit'>Submit</button>
                        </form>";
                    ?>

					<p><b>  Preparation Time: </b><?=$time?> minutes</p>
				</div>

				<hr style="clear: both">

                <b><u>Ingredient list</u></b>
                <ol><?php
                    while ($row = mysqli_fetch_assoc($ingredients)){
                        $multiplier = $serves == 0 ? 0 : $row['quantity']/$serves;
                        echo "                    <li>".$multiplier*$servingSize." ".$row['unit']." of ".$row['name']."</li>";
                    }
                ?></ol>

				<div style="clear: both">
                    <hr>
                    <b><u>Instructions</u></b>

					<?php
						$instructions = explode("\n",$recipe['instructions']);
						for($i =0;$i< count($instructions); $i++){
							echo '<p>'.$instructions[$i].'</p>';
						}
					?>
                </div>

				<div style="clear: both; font-size: small">
                    <hr>
					<div style="float: left">
					<!-- Add to favorites only displayed if user is logged in -->
					<?php
					if (isset($_SESSION["userName"]) == TRUE)
					{
					?>
						<form method="post" action="includes/Actions.php?ops=addFav">
							Like this recipe?
							<input type="hidden" id="UIDfav" name="userId" value="<?php echo $_SESSION['id']; ?>" />
							<input type="hidden" id="RIDfav" name="recipeId" value="<?php echo $_GET['id']; ?>" />
							<input type="button" onclick="addFavorite()" value="Add to favorites" />
						</form>
					<?php } ?>
					<script>
                        function fbs_click() {
                            u=location.href;
                            t=document.title;
                            window.open('http://www.facebook.com/sharer.php?u='+encodeURIComponent(u)+'&t='+encodeURIComponent(t),'sharer','toolbar=0,status=0,width=626,height=436');
                            return false;
                        }
                    </script>
                    <a rel="nofollow" href="http://www.facebook.com/share.php?u=<;url>" class="fb_share_button" onclick="return fbs_click()" target="_blank" style="text-decoration:none;">Share</a>

					<span style="padding-left:10px">
                        <script src="https://apis.google.com/js/plusone.js"></script>
                        <g:plus action="share"></g:plus>
                    </span>

                    <a href="https://twitter.com/share" class="twitter-share-button">Tweet</a>

					<span style="padding-left:10px">
                        <script>
                            !function(d,s,id){
                                var js,fjs=d.getElementsByTagName(s)[0];
                                if(!d.getElementById(id)){
                                    js=d.createElement(s);
                                    js.id=id;
                                    js.src="//platform.twitter.com/widgets.js";
                                    fjs.parentNode.insertBefore(js,fjs);
                                }
                            }(document,"script","twitter-wjs");
                        </script>
                    </span>
                    </div>


<!--

                    <div style="text-align: center; width: 60%; float: right; position: relative; right: 5%">
                    <b><u>Leave A Comment Here!</u></b>
                    <br>
                    <form id="comments" action="#">
                        <textarea name="instructions-description" id="recipe-instructions" style="width: 100%">
                        </textarea>
                        <br>
                        <button style="text-align: right; float: r


ight; position: relative; top: 5px; left: 1%">Comment</button>
                    </form>
                    </div>

				<hr style="clear: both">
-->
				</div>
                <!-- <div style="text-align: center">&lt;Display comments here></div>   -->
            <?php
            }
            else
                echo "
                <div style='font-size: x-large; text-align: center'>
                    Oops, recipe not found!
                </div>\n";
            ?>
            </div>
<?php
    printRightSideBar();

        echo "\n</div>\n";
    echo "</div>\n";

    printFooter();

    if (isset($_GET['add'])) {
        if($_GET['add'] == '0')
            $message = "The recipe has been successfully added to your favorites list.";
        else if ($_GET['add'] == '1')
            $message = "There was an error recipe while attempting to add this recipe to your favorites list.";
        else
            $message = "This recipe is already in your favorites list.";

        echo "<script type='text/javascript'>alert('".$message."');</script>";
    }
?>

</body>
</html>