<?php

require_once("includes/categories.php");
require_once("includes/Database.php");

session_start();

// If the user is already logged on
if (isset($_SESSION["loggedIn"]))
	header("Location: userhome.php");

if (isset($_POST["userName"]) && isset($_POST["userPass"]))
{
	$uname = $_POST["userName"];
	$passwd = $_POST["userPass"];
	
	// authenticate the user's credentials
	if ($uname == "a" && $passwd == "s")
	{
		// Set session values for all the user's information
		$_SESSION["userName"] = $uname;
		$_SESSION["loggedIn"] = TRUE;
		
		// Redirect to the user's customized homepage for a successful login
		header("Location: userhome.php");
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
