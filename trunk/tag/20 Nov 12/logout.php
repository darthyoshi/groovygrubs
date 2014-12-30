<?php

/**
 * Author: Dylan Tu
 * File: logout.php
 * Purpose: Performs user logouts
 */
 
session_start();

// unset session values only if the user is logged in
if (isset($_SESSION["userName"]) == TRUE)
{
	unset($_SESSION["userName"]);
	unset($_SESSION["id"]);
	unset($_SESSION["firstMidLast"]);

	session_destroy();
}

header("Location: index.php");

?>
