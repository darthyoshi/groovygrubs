<!DOCTYPE HTML>
<?php
require_once("includes/categories.php");
session_start();

?>

<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
    <title>Store Search - GroovyGrubs.com</title>
</head>

<body id="body">
<?php
    include 'includes/header.php';

    echo "\n<hr>\n";

    echo "<div id='content'>\n";

    include 'includes/leftsidebar.php';

        echo "<div class='column-2'>";
?>

            <div id="mainPanel" class="column-2-1">
                <ul id="breadcrumbs">
    <!--need to retrieve levels for display-->
                    <li><a href="index.php">Home</a> &raquo;</li>
                    <li>Store Search</li>
                </ul>

                <hr>

<!--need to parse location variable and use it to update map center - replace with Google API calls-->
<iframe width="425" height="350" style="border: none; overflow: hidden; margin: 0" src="https://maps.google.com/maps?oe=utf-8&amp;client=firefox-a&amp;ie=UTF8&amp;q=grocery+stores&amp;fb=1&amp;gl=us&amp;hq=grocery+stores&amp;hnear=Daly+City,+San+Mateo,+California&amp;t=m&amp;fll=37.795542,-122.404819&amp;fspn=0.026994,0.045447&amp;st=115179435013108446196&amp;rq=1&amp;ev=zo&amp;split=1&amp;ll=37.675196,-122.475802&amp;spn=0.026994,0.045447&amp;output=embed"></iframe><br /><small><a href="https://maps.google.com/maps?oe=utf-8&amp;client=firefox-a&amp;ie=UTF8&amp;q=grocery+stores&amp;fb=1&amp;gl=us&amp;hq=grocery+stores&amp;hnear=Daly+City,+San+Mateo,+California&amp;t=m&amp;fll=37.795542,-122.404819&amp;fspn=0.026994,0.045447&amp;st=115179435013108446196&amp;rq=1&amp;ev=zo&amp;split=1&amp;ll=37.675196,-122.475802&amp;spn=0.026994,0.045447&amp;source=embed" style="color:#0000FF;text-align:left">View Larger Map</a></small>
            </div>

<?php
    include 'includes/rightsidebar.php';

        echo "\n</div>\n";
    echo "</div>\n";

    include 'includes/footer.php';
?>

</body>
</html>