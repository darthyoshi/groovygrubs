<!DOCTYPE html>
<?php
require_once("includes/categories.php");
session_start();
?>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
    <title>User Home Page - GroovyGrubs.com</title>
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
		<li>User Account</li>
	</ul>
	<hr>
</div>

<?php

include 'includes/rightsidebar.php';

echo "\n</div>\n";
echo "</div>\n";

include 'includes/footer.php';

?>

</body>
</html>