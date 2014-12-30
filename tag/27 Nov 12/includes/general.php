<?php

/**
 * Author: Kay Choi
 * File: general.php
 * Purpose: Defines functions for displaying templated elements of the webpage.
 */

require_once 'Database.php';
require_once 'categories.php';

/**
 * leftSideBar generates html code to display the GroovyGrubs.com left sidebar.
 */
function leftSideBar(){

$db = new Database();
$categories = getCat();
$subCategories = getSubCat();
$catLabels = getCatLabels();

echo <<<EOF

        <div id='sidebarLeft' class='column-1'>
            <div style='font-size: large'>&nbsp; Browse recipes:</div>

            <ul class='cat'>

EOF;
    //lists each category
    foreach ($categories as $i) {
        echo "<li><a href='browse.php?browse={$i}'>{$catLabels[$i]}</a><ul>\n";

        //lists each subcategory associated with a category
        foreach($subCategories[$i] as $j)
            echo "<li><a href='browse.php?browse={$j}'>{$catLabels[$j]}</a><li>\n";

        echo "</ul></li>\n";
    }

echo <<<EOF

            </ul>

            <div style='font-size: x-small; padding-left: 5px'>
                <a href='browse.php'>View all recipes</a>
            </div>

            <hr style='width: 20%'>
            <div style='font-size: large'>&nbsp; Your top recipes:</div>

            <div id='favorites' class='topTen'>

EOF;

    //if the user is not logged in
    if (isset($_SESSION["userName"]) == FALSE) {
echo <<<EOF

                <div style='padding: 5px'>
                    Login to view your top recipes!
                </div>

EOF;

    } else {
        echo '<ol>';
        $user = $db->select("User","ID","userName='".$_SESSION["userName"]."'")->fetch_assoc();
        $UID = $user['ID'];

        $favRecipes = $db->select('Ratings','recipeID','userID = '.$UID,'','rating DESC');

        //lists the ten recipes that the user has given the highest ratings to
        for ($i = 0; $i < 10 && $row = mysqli_fetch_assoc($favRecipes); $i++) {
            $recipeName = $db->select('Recipe', 'name', 'ID = '.$row['recipeID'])->fetch_assoc();
            echo "<li>".
                "<a class='truncate' style='width:160px' href='recipe.php?".$row['recipeID']."'>".
                    $recipeName['name'].
                "</a>".
            "</li>";
        }

        //the user has not rated any recipes
        if ($i == 0)
            echo "You currently have not rated any recipes.";

        echo '</ol>';
    }

//displays map search form
echo <<<EOF

            </div>

            <hr style='width: 20%'>

            <form id='map' method='GET' action='storesearch.php' style="position: relative; left: 8px">
                <label for='location'>
                    Need ingredients?<br>
                    <small>Find a store now!</small>
                </label><br>
                <input type='text' id='location' name='location' />
                <button type='submit' onclick="return mapSearchCheck(this.form)">Search</button>
            </form>
        </div>

EOF;
}

/**
 * rightSideBar generates html code to display the GroovyGrubs.com right sidebar.
 */
function rightSideBar(){

    $db = new Database();
	$newRecipes = $db->select('Recipe','ID,name,uploadDate','1','','uploadDate');
	$topRecipes = $db->select('Ratings','recipeID,AVG(rating)','1','recipeID','AVG(rating) DESC');

echo <<<EOF

            <div id='sidebarRight' class='column-2-2'>
               <div style='font-size: large'>&nbsp; Newest recipes:</div>

                <div id='recent10' class='topTen'>
                    <ol>

EOF;

    //displays a list of the ten newest recipes
    for ($i = 0; $i < 10 && $row = mysqli_fetch_row($newRecipes); $i++) {
        echo "<li>".
            "<a class='truncate' style='width:160px' href='recipe.php?".$row[0]."'>".
                $row[1].
            "</a>".
        "</li>\n";
    }

    if ($i == 0)
        echo "There are currently rated recipes.";

echo <<<EOF

                    </ol>
                </div>

                <hr style="width: 20%">
                <div style="font-size: large">&nbsp; Most popular recipes:</div>

                <div id="top10" class="topTen">
                    <ol>

EOF;

    //displays a list of the ten recipes with the highest average rating, along with the actual recipe rating
    for ($i = 0; $i < 10 && $row = mysqli_fetch_assoc($topRecipes); $i++) {
        $recipeName = mysqli_fetch_assoc($db->select('Recipe', 'name', 'ID = '.$row['recipeID']));
        echo "<li>".
            "<a class='truncate' style='width:120px' href='recipe.php?".$row['recipeID']."'>".
                $recipeName['name'].
            "</a>".
            "<span style='float:right;position:absolute;left:170px'>".
                number_format($row['AVG(rating)'],2).
            "</span>".
        "</li>\n";
    }

    if ($i == 0)
        echo "There are currently no rated recipes.";

echo <<<EOF

                    </ol>
                </div>
            </div>

EOF;

}
/**
 * printHeader generates html code to display the GroovyGrubs.com header bar.
 */
function printHeader(){

//displays the site logo
echo <<<EOF

    <div id="header">
        <div id="logo" class="column-1" style="text-align: center;">
            <a href="index.php">
                <img src="logo.jpg" alt="GroovyGrubs.com" width=200 height=100>
            </a>
        </div>

EOF;

//displays the search bar and main menu bar
echo <<<EOF

        <div id="searchBar" class="column-2">
            <div class="column-2-1" style="text-align: center">
                <label for="searchInput">Search for recipes now!</label>
                <form id="searchForm" action="search.php" method="GET" style="margin-left: 50px">
                    <input type="text" name="searchInput" id="searchInput" value="" size="50">
                    <button type="submit">Search</button>
                </form>
                <br>
                <ul id="menu">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="upload.php">Upload A Recipe</a></li>
                    <li><a href="register.php">Register For Free</a></li>
					<li><a href="about.php">About Us</a></li>
                </ul>
            </div>

            <div id="login" class="column-2-2">

EOF;

    //displays user welcome message
    if (isset($_SESSION["userName"]) && $_SESSION["userName"] == TRUE) {
echo <<<EOF

                <form style="width: 100%; margin: auto" id="logoutForm" action="logout.php" method="POST">
                    <table style="position: relative; top: 10px; width: 100%; text-align: center">
                        <tr><td>

EOF
.'                            Welcome, '.$_SESSION['firstMidLast'].'!'.<<<EOF

                        </td></tr>

                        <tr><td style="font-size: small">
                            <a href="userhome.php">Go To Account Home</a>
                        </td></tr>

                        <tr><td>
                            <button type="submit">Logout</button>
                        </td></tr>
                    </table>
                </form>

EOF;

    } else {
//displays login form
echo <<<EOF

                <form id="logonForm" action="login.php" method="POST">
                    <table>
                        <tr><td>
                            <label for="userName">E-mail</label>
                            <input type="text" id="userName" name="userName" size="20" />
                        </td></tr>

                        <tr><td>
                            <label for="userPass">Password</label>
                            <input type="password" id="userPass" name="userPass" size="20" />
                        </td></tr>

                        <tr>
							<td>
								<small><a href="forgot.php">Forgot your password?</a></small>
								<button type="submit">Login</button>
							</td>
						</tr>
                    </table>
                </form>

                <small>
                    Not a member yet? <a href="register.php">Register</a> for free!
                </small>

EOF;
    }
echo <<<EOF

            </div>
        </div>
    </div>

EOF;

}

/**
 * footer generates html code to display the GroovyGrubs.com footer bar.
 */
function footer(){

echo <<<EOF

        <div id="footer">
            <hr>
            <a href="sitemap.php">Sitemap</a> |
            <a href="terms.php">Terms of Service</a> |
            <a href="privacy.php">Privacy Policy</a> |
            <a href="about.php">About Us</a> |
            <a href="contact.php">Contact Us</a>

            <br>&COPY; 2012 GroovyGrubs.com. All rights reserved.
        </div>

EOF;

}

?>
