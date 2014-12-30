<?php
/**
 * Author: Kay Choi, Dylan Tu
 * File: contact.php
 * Purpose: webpage for contacting site staff
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
    <title>Contact Us - GroovyGrubs.com</title>
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
	<div style="text-align: center">
		<span style="text-decoration: underline; font-size: x-large;">
		Contact GroovyGrubs.com
		</span>
		<br>

		<?php
		if (isset($_POST["comments"]) == FALSE)
		{
		?>

		<h1>Comments? Questions? Found a bug? Let us know!</h1>
		<form method='post' action='contact.php' style="text-align: left; position: relative; left: 10%">
			Your Email: <input type="text" name="name" size="65" style="position:relative;left: 8.5px"/>
			<br />
			<br />
			Comments<br />
			<textarea name="comments" rows="15" cols="60"></textarea>
			<br />
			<input type="submit" value="Submit" style="float: right; position: relative;right: 20.1%"/>
		</form>

		<?php
		}
		else
		{
			require_once("includes/Database.php");

			// mail variables need to be set since the php.ini aren't set by default
			ini_set("SMTP","sfsuswe.com");
			ini_set("smtp_port","587");

			// to - receipient
			// subject - the subject of the email
			// headers - sender
			$to = "dtu@sfsuswe.com";
			$subject = $_POST["name"] . " - GroovyGrubs Feedback";
			$headers = "From: " . $_POST["name"] . "\r\n";

			if (mail($to,$subject,$_POST["comments"],$headers) == TRUE)
				echo "<p style='text-align: center; font-size: 24px'>Your comments have been sent.</p>";
			else
				echo "<p style='text-align: center; font-size: 24px'>Failed to send feedback.</p>";
		}
		?>
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
