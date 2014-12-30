<?php

/**
 * Author: Kay Choi
 * File: header.php
 * Purpose: webpage header template
 */

require_once("includes/categories.php");
?>
    <div id="header">
        <div id="logo" class="column-1" style="text-align: center;">
            <a href="index.php">
                <img src="logo.gif" alt="GroovyGrubs.com" width=200 height=100 style="font-size: medium; border: 1px solid black">
            </a>
        </div>

        <div id="searchBar" class="column-2">
            <div class="column-2-1" style="text-align: center">
                <label for="searchInput">Search for recipes now!</label>
                <form id="searchForm" action="search.php" method="GET" style="margin-left: 50px">
                    <input type="text" name="searchInput" id="searchInput" value="" size="50">
                    <button type="submit">Search</button>
                </form>
                <br>
                <ul id="menu">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="upload.php">Upload A Recipe</a></li>
                    <li><a href="about.php">About Us</a></li>
                </ul>
            </div>

            <div id="login" class="column-2-2">
    <!--when logged in, display welcome message instead of form-->
                <?php
                if (isset($_SESSION["userName"]) && $_SESSION["userName"] == TRUE) {
                ?>

                <form style="width: 100%; margin: auto" id="logoutForm" action="logout.php" method="POST">
                    <table style="position: relative; top: 10px; width: 100%; text-align: center">
                        <tr><td>
                            Welcome, <?php echo $_SESSION['firstMidLast'];?>!
                        </td></tr>

                        <tr><td style="font-size: small">
                            <a href="userhome.php">Go To Account Home</a>
                        </td></tr>

                        <tr><td>
                            <button type="submit">Logout</button>
                        </td></tr>
                    </table>
                </form>

                <?php
                } else {
                ?>

                <form id="logonForm" action="login.php" method="POST">
                    <table>
                        <tr><td>
                            <label for="userName">E-mail</label>
                            <input type="text" id="userName" name="userName" size="20" />
                        </td></tr>

                        <tr><td>
                            <label for="userPass">Password</label>
                            <input type="password" id="userPass" name="userPass" size="20" />
                        </td></tr>

                        <tr>
							<td><button type="submit">Login</button></td>
						</tr>
                    </table>
                </form>

                <small>
                    Not a member yet? <a href="register.php">Register</a> for free!
                </small>

                <?php
                }
                ?>
            </div>
        </div>
    </div>