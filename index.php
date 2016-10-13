<?php
    session_start();
    include("mySQL_connection.inc.php");
    include("login.php");

    include("loadHome.php");


    // create connection and connect to the Twizla database
    $conn = dbConnect();
   //get the random products to display on home page
    $loadHomeSQL = "SELECT * FROM item, picturelink WHERE item.ItemID = picturelink.ItemID AND
                                                            item.Quantity > 0 AND
                                                            item.timeFinish > '".date("Y-m-d H:i:s",time())."'
                                                        GROUP BY item.ItemID ORDER BY RAND() LIMIT 14";

    $result = mysql_query($loadHomeSQL) or die(mysql_error());;

    while($row = mysql_fetch_array($result))
    {
         $homeItemList[] = $row;
    }

    mysql_close();


?>

<!--
    Document   : index.php
    Created on : Dec 22, 2009, 12:36:45 PM
    Author     : Peter
    Description:
        The main page.

    Updated: 12/1/2010
-->


<!Include php files for login, sign up function>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">

<html  xmlns="http://www.w3.org/1999/xhtml" xmlns:og="http://opengraphprotocol.org/schema/" xmlns:fb="http://www.facebook.com/2008/fbml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">



        
        <script type="text/javascript" src="javascripts/main.js"></script>

        <?php
            include("stylesheet.inc.php");
        ?>



    </head>
    <body>
        <?php

        if(isset($_SESSION['username']))
        { 
        ?>
            <img id="feedbackTag" src="<?php echo $PROJECT_PATH;?>webImages/givefeedback.png" alt="feedbackIcon" onclick="window.location='<?php echo $PROJECT_PATH;?>help/feedbackPage.php'"/>
        <?php
        }

            include("headSection.inc.php");
        ?>
        <div id="headerText">Twizla brings a whole new meaning to the online auctions marketplace. Not only do we encourage you to buy, sell and participate in our community discussions, we also rely
            on your feedback to ensure your user experience is more enjoyable.</div>
        <div id="middleSection">

            <div id="counter">We currently have <label style="font-weight: bold; color: blue;"><?php echo number_format($userAmount) ?></label> members and <label style="font-weight: bold; color: #ff0069;"><?php echo number_format($itemAmount) ?></label> items.</div>

            <div id="itemPictureBox">
                <!Insert the list of latest products pictures here>

                <?php

                    if($homeItemList)
                    {
                        include ('displayItemList.inc.php');
                        displayItemList($homeItemList,14,"", "featureList","featureItemContainer",true, "", false);

                    }
                ?>
            </div>

            <img alt="homePicture" src="webImages/homePicture.jpg" id="homePicture" />
        </div>

        <?php
            include("footerSection.inc.php");
        ?>
    </body>
</html>
