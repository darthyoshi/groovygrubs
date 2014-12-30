<?php

/**
 * Author: James Latief
 * File: recipe.php
 * Purpose: recipe page
 */

require_once("includes/categories.php");
session_start();
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
    <title>View Recipe - GroovyGrubs.com</title>
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
                <div style='font-size: x-large; text-align: center'>
                    Recipe name<br><br>
                </div>

                <a href="#" target="blank">
                    <img src="#" alt="Recipe image" width=200
                        height=150 style="padding: 5px; float: left; border: solid black 1px">
                </a>

				 <p style="text-align: left; font-size: medium">
                    Rating:
                </p>


                <div style="font-size: small"><p>Submitted by: User</p></div>

                <p>Recipe description</p>

                <hr style="clear: both">

                <b><u>Ingredient</u></b>
                <ol>
                    <li>Ingredient #1</li>

                </ol>

				<b><u>Equipment</u></b>:

				<ol>
					<li> Equipment #1</li>
				</ol>


				<div style="clear: both">
                    <hr>
                    <b><u>Instructions</u></b>
					<ol>
						<li> Use Equipment #1 to whisk Ingredient #1.</li>
						<li> Place Ingredient #1 in the refrigerator overnight.</li>
					</ol>
                </div>


				<div style="clear: both; font-size: small">
                    <hr>
					<div style="float: left">
                    Like this recipe? <a href="#">Add to favorites</a>
                    <br>

					<script>function fbs_click() {u=location.href;t=document.title;window.open('http://www.facebook.com/sharer.php?u='+encodeURIComponent(u)+'&t='+encodeURIComponent(t),'sharer','toolbar=0,status=0,width=626,height=436');return false;}</script><style> html .fb_share_button { display: -moz-inline-block; display:inline-block; padding:1px 20px 0 5px; height:15px; border:1px solid #d8dfea; background:url(http://static.ak.facebook.com/images/share/facebook_share_icon.gif?6:26981) no-repeat top right; } html .fb_share_button:hover { color:#fff; border-color:#295582; background:#3b5998 url(http://static.ak.facebook.com/images/share/facebook_share_icon.gif?6:26981) no-repeat top right; text-decoration:none; } </style> <a rel="nofollow" href="http://www.facebook.com/share.php?u=<;url>" class="fb_share_button" onclick="return fbs_click()" target="_blank" style="text-decoration:none;">Share</a>

					<span style="padding-left:10px"><script src="https://apis.google.com/js/plusone.js"></script><g:plus action="share"></g:plus></span>
					<a href="https://twitter.com/share" class="twitter-share-button">Tweet</a>

					<span style="padding-left:10px"><script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script></span>
                    </div>
<!--
                    <div style="text-align: center; width: 60%; float: right; position: relative; right: 5%">
                    <b><u>Leave A Comment Here!</u></b>
                    <br>
                    <form id="comments" action="#">
                        <textarea name="instructions-description" id="recipe-instructions" style="width: 100%">
                        </textarea>
                        <br>
                        <button style="text-align: right; float: right; position: relative; top: 5px; left: 1%">Comment</button>
                    </form>
                    </div>

				<hr style="clear: both">
-->
				</div>
                <!--div style="text-align: center">&lt;Display comments here></div-->
            </div>

<?php
    include 'includes/rightsidebar.php';

        echo "\n</div>\n";
    echo "</div>\n";

    include 'includes/footer.php';
?>

</body>
</html>