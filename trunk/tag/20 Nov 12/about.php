<?php
/**
 * Author: Kay Choi
 * File: about.php
 * Purpose: webpage displaying info about the team
 */

require_once "includes/categories.php";
session_start();
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
    <title>About GroovyGrubs.com</title>
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
                    About GroovyGrubs.com<br><br>
                </div>
                GroovyGrubs.com is maintained by SFSU CSc640 Group Six.
                <ol>
                    <li>Kay Choi</li>
                    <li>Therese Demers</li>
                    <li>James Latief</li>
                    <li>Ian Pitts</li>
                    <li>Victor Tobar</li>
                    <li>Dylan Tu</li>
                </ol>
            </div>

<?php
    include 'includes/rightsidebar.php';

        echo "\n</div>\n";
    echo "</div>\n";

    include 'includes/footer.php';
?>

</body>
</html>