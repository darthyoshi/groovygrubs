<?php

/**
 * Author: Kay Choi
 * File: storesearch.php
 * Purpose: webpage displaying map of nearby grocery stores
 */

require_once "includes/categories.php";
require_once "includes/template.php";
session_start();

function toCoordinates($address)
{
    $bad = array(
        " " => "+",
        "," => "",
        "?" => "",
        "&" => "",
        "=" => ""
    );
    $address = str_replace(array_keys($bad), array_values($bad), $address);
    $data = new SimpleXMLElement(file_get_contents("http://maps.google.com/maps/geo?output=xml&q={$address}"));
    $coordinates = explode(",", $data->Response->Placemark->Point->coordinates);
    return array(
        "longitude" => $coordinates[0],
        "latitude" => $coordinates[1]
    );
}

if (isset($_GET['location']) && $_GET['location'] != '')
    $locale = $_GET['location'];

else
    $locale = 'thorton hall sfsu';

$coord = toCoordinates($locale);
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
    <title>Store Search - GroovyGrubs.com</title>
    <script src="includes/general.js"></script>
</head>

<body id="body">
<?php
    printHeader();

    echo "\n<hr>
    <div id='content'>\n";

    printLeftSideBar();

    echo <<<EOF
        <div class='column-2'>
            <div id='mainPanel' class='column-2-1'>
                <div style='font-size: x-large; text-align: center'>
                    Store Search<br><br>
                </div>

                <div style='text-align: center'>
<iframe width='600' height='480' style='border: none; overflow: hidden; margin: 0' src='https://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=en&amp;q=grocery&amp;aq=&amp;sll={$coord['latitude']},{$coord['longitude']}&amp;sspn=0.052101,0.090895&amp;ie=UTF8&amp;t=m&amp;st=115968771510351694523&amp;rq=1&amp;ev=zi&amp;split=1&amp;radius=2.98&amp;hq=grocery&amp;hnear=&amp;ll={$coord['latitude']},{$coord['longitude']}&amp;spn=0.052101,0.090895&amp;z=14&amp;output=embed'></iframe>
                </div>
<a href='https://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=en&amp;q=grocery&amp;aq=&amp;sll={$coord['latitude']},{$coord['longitude']}&amp;sspn=0.052101,0.090895&amp;ie=UTF8&amp;t=m&amp;st=115968771510351694523&amp;rq=1&amp;ev=zi&amp;split=1&amp;radius=2.98&amp;hq=grocery&amp;hnear=&amp;ll={$coord['latitude']},{$coord['longitude']}&amp;spn=0.052101,0.090895&amp;z=14&amp;output=embed' style='color:#0000FF;position:relative;left:16px;font-size:small'>View Larger Map</a>
            </div>

EOF;

    printRightSideBar();

    echo "\n    </div>
        </div>\n";

    printFooter();
?>

</body>
</html>