<?php

session_start();

// unset session values only if the user is logged in
if ($_SESSION["loggedIn"] == TRUE)
{
	unset($_SESSION["userName"]);
	unset($_SESSION["userPass"]);
	unset($_SESSION["loggedIn"]);
	
	session_destroy();
}

header("Location: index.php");

?>
