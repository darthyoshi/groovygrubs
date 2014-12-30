<?php

/**
 * Author: Kay Choi, Dylan Tu
 * File: privacy.php
 * Purpose: webpage explaining site privacy policy
 */

require_once "includes/categories.php";
require_once 'includes/template.php';
session_start();
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
    <title>Privacy Policy - GroovyGrubs.com</title>
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
                <div>
                    <h2 style='text-align: center;'>Privacy Policy</h2><br />
					At GroovyGrubs, we highly value our user's privacy, and maintaining their
					trust and confidence with us is of the utmost importance. This page lists
					our privacy policy which indicates what we do with your data and how we
					secure it.
					<ol>
						<li><b>Information Collected</b>. The information we collect is only the
						data that you submit or upload to our website. Your registration information
						is saved on our servers, and the data regarding your recipes are also
						stored and displayed on our website publicly.</li>
						<li><b>Mandatory and Optional Data</b>. The data that you wish to submit to
						submit to our website is completely optional. Registration is not required
						to use our website, but is required for more advanced features.</li>
						<li><b>Tracking and Logging Data</b>. The tracking data we use is simply
						a cookie that is stored on your browser. We use that cookie to maintain your
						session on our website (e.g., so that you don't have to re-log in). After a
						fixed period of time, that data is automatically erased after its expiration
						time. You may manualy clear the cookies in your browser by referring to your
						browser's documentation.</li>
						<li><b>Sharing of Information</b>. We do not share your information with
						any 3rd parties. Information that you submit to us is strictly stored in our
						servers and is never shared with anyone else except the administrators of
						GroovyGrubs. Information that you submit to us will be used for identifying
						registered users for login purposes.</li>
					</ol>
                </div>
            </div>

<?php
    printRightSideBar();

        echo "\n</div>\n";
    echo "</div>\n";

    printFooter();
?>

</body>
</html>