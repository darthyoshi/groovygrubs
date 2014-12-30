<?php

/**
 * Author: Dylan Tu
 * File: login.php
 * Purpose: Authenticates user logons
 */

require_once("includes/categories.php");
require_once("includes/Database.php");

session_start();

// If the user is already logged on
if (isset($_SESSION["userName"]))
	header("Location: userhome.php");

if (isset($_POST["userName"]) && isset($_POST["userPass"]))
{
	$uname = $_POST["userName"];
	$passwd = $_POST["userPass"];
	$prev = $_SERVER['HTTP_REFERER'];

	// Query the database
	$db = new Database();
	$resource = $db->select("User","*","userName='".$uname."' AND passWord='".md5($passwd)."'");

	if (mysqli_num_rows($resource) > 0)
	{
		// Fetch the results
		$result = $resource->fetch_assoc();
		$isValid = TRUE;
	}
	else
		$isValid = FALSE;

	// authenticate the user's credentials
	if ($isValid == TRUE)
	{
		// Set session values for all the user's information
		$_SESSION["userName"] = $uname;
		$_SESSION["id"] = $result["ID"];
        $_SESSION["firstMidLast"] = $result["firstName"].' '.$result['middleName'].' '.$result['lastName'];

		// Redirect to the user's customized homepage for a successful login
		header("Location: " . $prev);
	}
}

?>

<!-- Displays only for login failure -->
<!DOCTYPE html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
	<title>Login - GroovyGrubs.com</title>
</head>
<body id="body">

<?php

include 'includes/header.php';

echo "\n<hr>\n";
echo "<div id='content'>\n";

include 'includes/leftsidebar.php';

echo "<div class='column-2'>";

include 'includes/rightsidebar.php';

// temporary login failure notice
echo "<h1 style='text-align: center; color: #ff0000;'>Login Failure</h1>";

echo "\n</div>\n";
echo "</div>\n";

include 'includes/footer.php';

?>

</body>
</html>
