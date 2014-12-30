<?php
require_once("includes/categories.php");
?>
    <div id="header">
        <div id="logo" class="column-1" style="text-align: center;">
            <a href="index.php">
                <img src="logo.gif" alt="GroovyGrubs.com" width=200 height=100 style="font-size: medium; border: 1px solid black">
            </a>
        </div>

        <div id="searchBar" class="column-2">
            <div class="column-2-1" style="text-align: center"><br>
                <label for="searchInput">Search for recipes now!</label>
                <form id="searchForm" action="search.php" method="GET" >
                    <input type="text" name="searchInput" id="searchInput" value="" size="50">
                    <input type="submit" value="Search" name="search">

                    <div style="font-size: small">
                        Search by:
                        <input type="radio" name="searchType" value="title" checked="checked" id="title"/><!--
                        --><label for="title">title</label>

                        <input type="radio" name="searchType" value="ingred" id="ingredients"/><!--
                        --><label for="ingredients">ingredients</label>
                    </div>
                </form>
            </div>

            <div id="login" class="column-2-2">
    <!--when logged in, display welcome message instead of form-->
                <?php
                if (isset($_SESSION["userName"]) && $_SESSION["userName"] == TRUE) {
                ?>

                <form style="float: right" id="logoutForm" action="logout.php" method="POST">
                    <table>
                        <tr><td>
                            Welcome, User!
                        </td></tr>

                        <tr><td style="font-size: small">
                            <a href="userhome.php">Account Home</a>
                        </td></tr>

                        <tr><td>
                            <input type="submit" value="Logout" name="logout"/>
                        </td></tr>
                    </table>
                </form>

                <?php
                } else {
                ?>

                <form id="logonForm" action="login.php" method="POST">
                    <table>
                        <tr><td>
                            <label for="userName">Username</label>
                            <input type="text" id="userName" name="userName" size="20" />
                        </td></tr>

                        <tr><td>
                            <label for="userPass">Password</label>
                            <input type="password" id="userPass" name="userPass" size="20" />
                        </td></tr>

                        <tr>
							<td><input type="submit" value="Login" name="logon"/></td>
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