<!DOCTYPE HTML>
<?php
require_once "includes/categories.php";
session_start();

?>

<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
    <title>GroovyGrubs.com</title>
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
                <div style='text-align: center'>
                    <div style="font-size: xx-large">
                        Welcome to<br>
                        GroovyGrubs.com
                    </div>

                    <div style="font-size: large">
                        Insert clever slogan here
                    </div>
                </div>

                <div style='padding-top: 10px; padding-bottom: 10px'>
                    <div style='font-size: large'>Recipe of the Day:</div>

                    <div style='float: left; font-size: medium; width: 200px; height: 150px; border: 1px solid black'>
                        <a href='recipe.php'>
                            <img src='' alt='Recipe of the Day' width=200 height=150>
                        </a>
                    </div>

                    <div style='position: relative; left: 5px'>
                        <div style='font-size: x-large;'>
                            <a href='recipe.php'>Recipe name</a>
                        </div>

                        Rating:

                        <div style='font-size: small'>
                            <p>Submitted by: User</p>
                        </div>

                        <p>Short recipe description</p>
                    </div>
                </div>

                <div style='clear: both; padding-top: 10px; padding-bottom: 10px'>
                    <hr>
                    <p>blah blah</p>
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