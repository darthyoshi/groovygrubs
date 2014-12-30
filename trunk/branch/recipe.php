<?php
//need to apply stars to everything, need to select user's previous rating on recipe load
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
    $rating 	 = empty($rating) ? 
        'Not rated yet.' : 
        ($rating == floor($rating) ? 
            number_format($rating,0) : 
            number_format($rating,2))
        .' stars';
    $serves      = stripslashes($recipe['serves']);
    $time        = stripslashes($recipe['approxTime']);
    $ingredients = $db->select('Ingredients','*','recipeID='.$recipe['ID']);

    if (empty($picture))
        $imgSrc = $imgPath = "recipe_pictures/default.jpg";
    else if ($picture['image'] == '')
        $imgSrc = $imgPath = "recipe_pictures/default.jpg";
    else {
        $imgExt = pathinfo($picture['name'], PATHINFO_EXTENSION);
        $imgSrc = "data:image/{$imgExt};base64,".base64_encode($picture['image']);
        $imgPath = "recipe_pictures/".$recipe['ID'].$picture['name'];
    }
} while (false);
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

    <script>
        window.onload=function() {
            document.getElementById("star5").onclick=radioClicked;
            document.getElementById("star4").onclick=radioClicked;
            document.getElementById("star3").onclick=radioClicked;
            document.getElementById("star2").onclick=radioClicked;
            document.getElementById("star1").onclick=radioClicked;
        }

function radioClicked() {
  rate(this.value,'<?=$_GET['id']?>','<?=$_SESSION['id']?>');
}


    </script>
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

                <div style='float:left'><a href="<?=$imgPath?>" target="blank">
                    <img src="<?=$imgSrc?>" alt="Recipe image" style="padding: 5px; float: left; border:  1px  solid #000000; width:200px; height:150px; ">
                    <br><small style="padding-left:1px">View larger image</small>
                </a></div>

				<div id ="mainPanelA" class="column-2-1-1">
                    <?php
                    echo "                    <fieldset id='avgRating' class='rating' style='float:left;'>
                        <legend>Current rating</legend>\n<!--";

                        for ($i = 1; $i <= floor($rating) ; $i++)
                            echo "--><img class='star' src='starbright.png' alt='{$i} star' /><!--\n";

                        if ($i - $rating >= 0.25 && $i - $rating < 0.75) {
                            echo "--><img class='star' src='starbrightleft.png' style='width:10px;' alt='{$i} star' /><!--\n";
                            echo "--><img class='star' src='stargrayright.png' style='width:10px;' alt='{$i} star' /><!--\n";
                            $i++;
                        }


                        for (; $i <= 5 ; $i++)
                            echo "--><img class='star' src='stargray.png' alt='{$i} star' /><!--\n";

                        echo  "--><br>{$rating}</fieldset>\n";

                    ?>
                    <?php
                        echo "                         <fieldset class='rating' style='position:relative;left:75px'>
    <legend>Your rating</legend>";
                        if (isset($_SESSION['id'])) {
                            $yourRateRow = $db->select('Ratings','rating',"raterID={$_SESSION['id']} AND recipeID={$recipe['ID']}")->fetch_row();
                            if ($yourRateRow != null)
                                $yourRating = $yourRateRow[0].' stars';
                            else 
                                $yourRating = 'Not rated yet.';
                        
                            for ($i = 5; $i > 0; $i--)
                                echo "<input type='radio' id='star{$i}' name='rating' value='{$i}' /><label for='star{$i}' title='{$i} stars'></label>\n";
                                
                            echo "<br><span id='userRate' style='position: absolute;top: 43px;left: 0;text-align: center;width: 145px;'>{$yourRating}</span>";
                        }
                        else
                            echo "<small>Login to rate!</small>";
                        
                        echo "</fieldset>";
                    ?>

					<div style="font-size: medium; clear:both"><p style="padding-top:1em"><b>  Submitted by:</b> <?=$user['firstName']." ".$user['middleName']." ".$user['lastName']?></p></div>

					<p><b> Recipe description:</b></p>
					<div id = "mainPanelB" class = "column-2-1-2" style ='font-size: 12;'>
					<?=$description?><br><br></div>

                    <div style="float:left;clear:both">
                    <?php
                        echo "<label for='newServe' style='font-weight:bold'>Servings: </label>
							<input type='text' size='3' name='newServe' id='newServe' value='".$serves."' />
							<input type='hidden' name='RID' id='RID' value='{$_GET['id']}' />
							<input type='hidden' name='serves' id='serves' value='{$serves}' />
							<input type='button' value='Update' onclick='updateServings()' />";
                    ?>
                    </div>
					<p style='clear:both; padding-top: 0.5em'><b>  Preparation Time: </b><?=$time?> minutes</p>
				</div>

				<hr style="clear: both">

                <b><u>Ingredient list</u></b>
                <ol id='ingList'>
					<?php
                    for ($i = 0; ($row = mysqli_fetch_assoc($ingredients)); $i++) {
                       echo "\n<li>".number_format($row['quantity'],2)." ".$row['unit']." of ".$row['name']."</li>";
                    }
                    if ($i == 0)
                        echo "\n<p>This recipe requires no ingredients.</p>\n";
					?>
				</ol>

				<div style="clear: both">
                    <hr>
                    <b><u>Instructions</u></b>

					<?php
						$instructions = explode("\n",$recipe['instructions']);
						for ($i =0;$i< count($instructions); $i++){
							echo '<p>'.$instructions[$i].'</p>';
						}
					?>
                </div>

				<div style="clear: both; font-size: small">
                    <hr>
					<div style="float: left">
						<?php
						if (isset($_SESSION["id"]) == TRUE && $_SESSION["id"] == $recipe["userID"])
						{
						?>
						<form method="post" action="editrecipe.php">
							Need to change something?
							<input type="hidden" name="userId" value="<?php echo $_SESSION['id']; ?>" />
							<input type="hidden" name="recipeId" value="<?php echo $_GET['id']; ?>" />
							<input type="submit" value="Edit this recipe" />
						</form>
						<?php
						}
						?>
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
					<?php
					}
					?>
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
                                if (!d.getElementById(id)){
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
        if ($_GET['add'] == '0')
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