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
    <title>Browse Recipes - GroovyGrubs.com</title>
    <style>
        ol, ul { list-style-type: none;}
        #browse-list div {
            overflow:auto;
            border: 1px solid black;
        }
        #browse-list {
            padding: 0;
            margin: 0;
        }
        #browse-list ul li{
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
                    <?php
                    if(isset($_GET['browseby'])){
                        $browse = $_GET['browseby'];

                        echo "<li><a href='browse.php'>Browse</a> &raquo;</li> ";

                        foreach($subCategories as $catKey => $i){
                            $subCatKey = array_search($browse, $i);

                            if($subCatKey !== false){
                                echo "<li><a href='browse.php?browseby={$catKey}'>{$catLabels[$catKey]}</a> &raquo;</li> ";
                                echo "<li>{$catLabels[$i[$subCatKey]]} &raquo;</li> ";
                                break;
                            }
                        }

                        if(in_array($browse, $categories))
                            echo "<li>{$catLabels[$browse]}</li>";
                    }
                    else
                        echo "<li>Browse</li>";
                    ?>
                </ul>

                <hr>

                
                    <div id="browse-column">
                    <div id="browse-header">
                        <p>Browse: <?php echo $browse;?> (# results found)</p>
                        <p>Title    Ratings     Serving size    Prep time</p>
                    </div>

                    <div id="browse-body">
                        <ul id="browse-list">
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
