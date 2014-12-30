<?php

/**
 * Author: Kay Choi
 * File: leftsidebar.php
 * Purpose: webpage left sidebar template
 */

require_once("includes/categories.php");
?>

<script type="text/javascript">
    function mapSearchCheck(form){
        if(form.location.value == ""){
            alert("Please enter your location.");
            form.location.focus();
            return false;
        }
        return true;
    }
</script>

        <div id='sidebarLeft' class='column-1'>
            <div style='font-size: large'>&nbsp; Browse recipes:</div>

            <ul class='cat'>
                <?php
                foreach ($categories as $i) {
                    echo "<li><a href='browse.php?browse={$i}'>{$catLabels[$i]}</a><ul>\n";

                    foreach($subCategories[$i] as $j)
                        echo "<li><a href='browse.php?browse={$j}'>{$catLabels[$j]}</a><li>\n";

                    echo "</ul></li>\n";
                }
                ?>
            </ul>

            <div style='font-size: x-small; padding-left: 5px'>
                <a href='browse.php'>View all recipes</a>
            </div>

            <hr style='width: 20%'>
            <div style='font-size: large'>&nbsp; Favorite recipes:</div>

            <div id='favorites' class='topTen'>
        <!--need to retrieve list of favorites-->
                <?php
                $numFav = 1;
                if (isset($_SESSION["userName"]) == FALSE) {
                ?>

                <div style='padding: 5px'>
                    Login to view your favorite recipes!
                </div>

                <?php
                } else if ($numFav == 0) {
                ?>

                <div style='padding: 5px'>
                    You currently have no favorite recipes.
                </div>

                <?php
                } else {
                    echo '<ol>';
                    for ($i = 0; $i < $numFav; $i++) {
        //                 $recipe_id;
                        echo "<li><a href='recipe.php'>"."Recipe name"."</a></li>";
                    }
                    echo '</ol>';
                }
                ?>
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