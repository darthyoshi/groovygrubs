<?php

require_once("includes/categories.php");
session_start();

?>

<!DOCTYPE html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
    <title>Account Registration - GroovyGrubs.com</title>
	<script type="text/javascript">
	
	function checkForm(form)
	{
		var fname = form.firstName.value;
		var lname = form.lastName.value;
		var password = form.pass.value;
		var password2 = form.pass2.value;
		var username = form.loginID.value;
		var email = form.mail.value;
		var email2 = form.mail2.value;
		var pattern = /^[A-z0-9]+@[A-z0-9]+\.[A-Za-z]+$/g;
		
		if (fname == "" || fname == null ||
			lname == "" || lname == null ||
			username == "" || username == null ||
			password == "" || password == null ||
			password2 == "" || password2 == null ||
			email == "" || email == null ||
			email2 == "" || email2 == null)
		{
			alert("All fields must be filled.");
			return false;
		}
		
		if (password != password2)
		{
			alert("Passwords much match.");
			return false;
		}
		
		if (pattern.test(email) == false)
		{
			alert("Email must contain letters or numbers and end with @<domain name>.<domain suffix>.");
			return false;
		}
		else if (email != email2)
		{
			alert("Emails must match.");
			return false;
		}
		
		if (document.getElementById("tos").checked == false)
		{
			alert("You must agree to the terms of service.");
			return false;
		}
		
		return true
	}
	
	</script>
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
	<li>Registration</li>
</ul>

<hr>

<?php

// form is not submitted
if (isset($_POST["mail"]) == FALSE)
{
	echo "<div style=\"font-size: large; text-align: center\">
		<p>User Registration</p>
		</div>

		<form style=\"text-align: center\" id=\"register_form\" action=\"register.php\" method=\"POST\">
		<table style=\"margin-left: auto; margin-right: 35%\">
			<tr style=\"text-align: right\">
				<td><label for=\"firstName\">First Name</label></td>
				<td><input type=\"text\" name=\"firstName\" id=\"firstName\"/></td>
			</tr>
			<tr style=\"text-align: right\">
				<td><label for=\"lastName\">Last Name</label></td>
				<td><input type=\"text\" name=\"lastName\" id=\"lastName\"/></td>
			</tr>
		</table>

		<table style=\"margin-left: auto; margin-right: 35%; padding-top: 15px\">
			<tr style=\"text-align: right\">
				<td><label for=\"loginID\">Username</label></td>
				<td><input type=\"text\" name=\"loginID\" id=\"loginID\"/></td>
			</tr>

			<tr style=\"text-align: right\">
				<td><label for=\"pass\">Enter Password</label></td>
				<td><input type=\"password\" name=\"pass\" id=\"pass\"/></td>
			</tr>

			<tr style=\"text-align: right\">
				<td><label for=\"pass2\">Confirm Password</label></td>
				<td><input type=\"password\" name=\"pass2\" id=\"pass2\"/></td>
			</tr>
		</table>

		<table style=\"margin-left: auto; margin-right: 35%;
			padding-top: 15px\">
			<tr style=\"text-align: right\">
				<td>
					<label for=\"mail\">Enter E-mail</label>
				</td>

				<td>
					<input type=\"text\" name=\"mail\" id=\"mail\"/>
				</td>
			</tr>

			<tr style=\"text-align: right\">
				<td>
					<label for=\"mail2\">Confirm E-mail</label>
				</td>

				<td>
					<input type=\"text\" name=\"mail2\" id=\"mail2\"/>
				</td>
			</tr>
		</table>

		<!--captcha goes here-->
		<input type=\"checkbox\" id=\"tos\" name=\"tos\" value=\"ON\" />
		<label style=\"font-size: small\" for=\"tos\">
			I have read and agree to the GroovyGrubs.com
			<a href=\"terms.php\">Terms of Service</a> and
			<a href=\"privacy.php\">Privacy Policy</a>.
		</label>

		<p>
			<input style=\"position: relative; left: 20px\"
					type=\"submit\" value=\"Register\" onclick='return checkForm(this.form);' />
		</p>
		</form>";
}
else
{
	require_once("includes/Database.php");
	// insert data into database
	// ...
	// temporary success message
	echo "<h1 style='text-align: center; color: #ff0000;'>Registration Successful</h1>";
}

echo "</div>";

include('includes/rightsidebar.php');

echo "\n</div>\n";
echo "</div>\n";

include('includes/footer.php');

?>

</body>
</html>
