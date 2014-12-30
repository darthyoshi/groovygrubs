            <div id='sidebarRight' class='column-2-2'>
                <div style='text-align: center;'>
                    <small><a href='upload.php'>Upload a recipe!</a></small>
                </div>

                <hr style='width: 20%'>
                <div style='font-size: large'>Newest recipes:</div>

                <div id='recent10' class='topTen'>
<!--need to retrieve list from database-->
                    <ol>
                        <?php
                        $numRecent = 1;
                        for ($i = 0; $i < $numRecent; $i++) {
        //                 $recipe_id;
                            echo "<li><a href='recipe.php'>"."Recipe name"."</a></li>\n";
                        }
                        ?>
                    </ol>
                </div>

                <hr style="width: 20%">
                <div style="font-size: large">Most popular recipes:</div>

                <div id="top10" class="topTen">
<!--need to retrieve list from database-->
                    <ol>
                        <?php
                        $numTop = 1;
                        for ($i = 0; $i < $numTop; $i++) {
        //                 $recipe_id;
                            echo "<li><a href='recipe.php'>"."Recipe name"."</a></li>\n";
                        }
                        ?>
                    </ol>
                </div>
            </div>