

<!--
    Document   : 404errorPage.php
    Created on : July 22, 2010, 12:36:45 PM
    Author     : Peter
    Description:
        The 404error page.

    Updated: 22/7/2010


-->





<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">


<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

        <script type="text/javascript" src="javascripts/main.js"></script>

        <?php
            include("stylesheet.inc.php");
        ?>

        <!Redirect after 5 second>
        <meta http-equiv="refresh" content="5;url=index.php" >
    </head>
    <body>
        <?php
            include("headSection.inc.php");
        ?>

            <div id="middleSection">
                <div id="middleLeftSection">
                    <div id ="bigHeading">Page Not Found</div>
                    <br/>
                    <!display the help content>
                    <p>The page you are trying to access could not be found. It may have moved to a new location.<br/>
                        Please <a href="index.php">click here</a> to go back to the Twizla home page immediately or wait 5 seconds for the auto-redirect.<br/>

                    </p>
                </div>
            <?php

                include("middleRightSection.inc.php");


            ?>

            </div>


            <?php
                include("footerSection.inc.php");
            ?>

    </body>
</html>
