<?php

/**
 * Author: Dylan Tu
 * File: login.php
 * Purpose: Authenticates user logons
 */

require_once "includes/categories.php";
require_once "includes/Database.php";
require_once "includes/general.php";
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
    <script src="includes/general.js"></script>
</head>
<body id="body">


<?php

printheader();

echo "\n<hr>\n";
echo "<div id='content'>\n";

leftsidebar();

echo "<div class='column-2'>";

rightsidebar();

//Login failure notice
echo "<h1 style='text-align: center; color: #ff0000;'>Login Failure</h1>";




//Login fields in login.php's body.
echo "<div class ='column-2-3'>";
echo "<form id=\"logonForm\" action=\"login.php\" method=\"POST\"><table style = 'text-align: right;'>
	<tbody><tr><td>
                          <label for=\"userName\">E-mail</label>
                            <input type=\"text\" id=\"userName\" name=\"userName\" size=\"30\">
                        </td></tr>

                        <tr><td>
                            <label for=\"userPass\">Password</label>
                            <input type=\"password\" id=\"userPass\" name=\"userPass\" size=\"30\">
                        </td></tr>

                        <tr>
							<td>
								<small><a href=\"forgot.php\">Forgot your password?</a></small>
								<button type=\"submit\">Login</button>
							</td>
						</tr>
                    </tbody>
	</table></form></div>";



echo "\n</div>\n";
echo "</div>\n";


footer();

?>

</body>
</html>
