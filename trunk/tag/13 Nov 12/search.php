<!DOCTYPE HTML>
<?php
require_once("includes/categories.php");
session_start();

$loggedIn = false;
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
    <title>Search Recipes - GroovyGrubs.com</title>
    <style>
        ol, ul { list-style-type: none;}
        #search-list div {
            overflow:auto;
            border: 1px solid black;
        }
        #search-list ul {
            padding: 0;
            margin: 0;
        }
        #search-list ul li{
            float: left;
            border: 1px solid black;
            margin: 0 0 0 0;
            padding: 0;
        }
    </style>
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
                <ul id="breadcrumbs" >
                    <li><a href="index.php">Home</a> &raquo;</li>
                    <li>Search</li>
                </ul>

                <hr>

                
                
                <div id="search-column">
                    <div id="search-header">
                        <?php
                            if ($_SERVER["REQUEST_METHOD"] == "GET"){
                                $search = array("search-input" => $_GET["searchInput"], "search-type" => $_GET["searchType"]);
                            }
                            else if ($_GET["searchInput"]=="") {
                                header('Location: index.php');
                                exit;
                            }
                        ?>
                        <p>Search: <?php echo $search['search-input'];?> (# results found)</p>
                        <p>Title    Ratings     Serving size    Prep time</p>
                    </div>

                    <div id="search-body">
                        <ul id="search-list">
                            <ul>
                                <li>Picture</li>
                                <li>Title:</li>
                                <li>Ratings:</li>
                                <li>Serving size:</li>
                                <li>Prep time:</li>
                            </ul>
                        </ul>
                        <br/>
                        <p>Rows created depending on database fetch.</p>
                    </div>
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
