<?php
/**
 * Author: Kay Choi
 * File: about.php
 * Purpose: webpage displaying info about the team
 */
require_once "includes/categories.php";
require_once 'includes/Database.php';
require_once "includes/general.php";

session_start();
?>

<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
    <title>About GroovyGrubs.com</title>
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
		<span style="text-decoration: underline">About GroovyGrubs.com</span><br><br>
	</div>
	GroovyGrubs.com is maintained by SFSU CSc 640 Group Six.
	<ol>
		<li>Kay Choi</li>
		<li>Therese Demers</li>
		<li>James Latief</li>
		<li>Ian Pitts</li>
		<li>Victor Tobar</li>
		<li>Dylan Tu</li>
	</ol>
	<p>
	At groovygrubs.com we provide the ability to view and share recipes. Like many
	other recipe sharing websites, you will be able to browse the different categories
	and varieties of recipes. Registered users can share their recipes, post pictures of
	their dishes and improve on each other's recipes. What separates us from our
	competitors is the ability to discover new recipes with the food you already have,
	right in your pantry. In addition, if you decide to purchase extra ingredients to make a
	particular entree but don't know where to buy the ingredients from, we will provide a search
	for all the nearby stores that carry the missing ingredients.
	</p>
	<p>
	The current population by large is very computer-savvy. Almost everyone owns a computer and
	can go on the internet and use google. So, for the people that love to cook and know how to
	use a browser, GroovyGrubs.com is their one stop for sharing recipes, posting recipes and
	forming their own little food-communities.
	</p>
</div>

<?php
rightsidebar();
echo "\n</div>\n";
echo "</div>\n";
footer();
?>

</body>
</html>
