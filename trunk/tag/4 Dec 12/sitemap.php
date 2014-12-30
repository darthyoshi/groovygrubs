<?php

/**
 * Author: Kay Choi
 * File: sitemap.php
 * Purpose: webpage display sitemap
 */

require_once "includes/categories.php";
require_once "includes/general.php";
session_start();
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
    <title>Sitemap - GroovyGrubs.com</title>
    <script src="includes/general.js"></script>
</head>

<body id="body">
<?php
    printheader();

    echo "\n<hr>\n";

    echo "<div id='content'>\n";

    leftsidebar();

        echo "<div class='column-2'>";
?>

            <div id='mainPanel' class='column-2-1'>
                <div style='font-size: x-large; text-align: center'>
                    Sitemap<br><br>

                    &lt;to be done later>
                </div>
            </div>

<?php
    rightsidebar();

        echo "\n</div>\n";
    echo "</div>\n";

    footer();
?>

</body>
</html>