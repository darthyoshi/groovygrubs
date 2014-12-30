<?php

/**
 * Author: Kay Choi
 * File: terms.php
 * Purpose: webpage explaining site tersm of service
 */

require_once "includes/categories.php";
session_start();
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
    <title>Terms of Service - GroovyGrubs.com</title>
</head>

<body id="body">
<?php
    include 'includes/header.php';

    echo "\n<hr>\n";

    echo "<div id='content'>\n";

    include 'includes/leftsidebar.php';

        echo "<div class='column-2'>";
?>

            <div id='mainPanel' class='column-2-1'>
                <div style='font-size: x-large; text-align: center'>
                    Terms of Service<br><br>

                    &lt;form to be done later>
                </div>
            </div>

<?php
    include 'includes/rightsidebar.php';

        echo "\n</div>\n";
    echo "</div>\n";

    include 'includes/footer.php';
?>

</body>
</html>