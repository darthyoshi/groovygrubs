<?php
/**
 * Author: Dylan Tu
 * File: forgot.php
 * Purpose: Retrieves a lost password and emails it to the user
 */
require_once "includes/categories.php";
require_once "includes/template.php";
session_start();
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
    <title>Forgot Your Password - GroovyGrubs.com</title>
    <script src="includes/general.js"></script>
</head>

<body id="body">

<?php
printHeader();
echo "\n<hr>\n";
echo "<div id='content'>\n";
printLeftSideBar();
echo "<div class='column-2'>";
?>

<div id='mainPanel' class='column-2-1'>
	<div style="text-align: center">

		<?php
		if (isset($_POST["email"]) == TRUE)
		{
			require_once("includes/Database.php");
			$db = new Database();
			$resource = $db->select("User","*","userName='".$_POST["email"]."'");

			// check if the username exists
			if ($resource->num_rows == 0)
				echo "<h2 style='color: #ff0000;'>That username does not exist.</h2>";
			else
			{
				$result = $resource->fetch_assoc();
				$newPass = $db->newID();
				$to = $result["userName"];
				$subject = "Password Reset - GroovyGrubs.com";
				$message = "Your new password is: " . $newPass;
				$headers = "From: dtu@sfsuswe.com\r\n";
				$oldPass = $result["passWord"];

				// mail variables need to be set since the php.ini aren't set by default
				ini_set("SMTP","sfsuswe.com");
				ini_set("smtp_port","587");

				// insert the new password into the database
				if ($db->update("User","passWord='".md5($newPass)."'",
								"userName='".$result["userName"]."'") == FALSE)
					echo "<p style='text-align: center; font-size: 24px'>Failed to get new password.</p>";
				else
				{
					if (mail($to,$subject,$message,$headers) == TRUE)
							echo "<p style='text-align: center; font-size: 24px'>Your password have been sent.</p>";
					else
					{
						echo "<p style='text-align: center; font-size: 24px'>Failed to send password.</p>";
						// if the email containing the new password was not sent, undo the password reset
						$db->update("User","passWord='".$oldPass."'","userName='".$result["userName"]."'");
					}
				}
			}
		}
		else
		{
		?>
		<span style="font-size: x-large;">
		Enter your username, and an email will be sent to you with your new password.
		</span>
		<br /><br />
		<form id='forgot' method='post' action='forgot.php'>
			Username: <input type='text' name='email' size='40' />
			<br />
			<input type='submit' value='Reset Password' />
			<input type='reset' value='Clear Form' />
		</form>

<?
}

echo "</div></div>";
printRightSideBar();
echo "\n</div>\n";
echo "</div>\n";
printFooter();
?>

</body>
</html>
