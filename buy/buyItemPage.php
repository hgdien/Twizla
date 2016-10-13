<?php
    session_start();
    include("../mySQL_connection.inc.php");
    include("../login.php");

    include("../loadHome.php");
?>

<!--
    Document   : buyItemPage.php
    Created on : Dec 22, 2009, 12:36:45 PM
    Author     : Peter
    Description:
        The main page.

    Updated: 29/1/2010


-->


<!Include php files for login, sign up function>
<?php

    // create connection and connect to the Twizla database
    $conn = dbConnect();

    // get the list of latest products from database
    $selectSQL = "SELECT * FROM item, picturelink Where item.ItemID = picturelink.ItemID
                                                        AND item.timeFinish > '".date("Y-m-d H:i:s",time())."' AND
                                                        item.Quantity > 0
                                        GROUP BY item.ItemID ORDER BY item.listedDate DESC LIMIT 10";

    $result = mysql_query($selectSQL) or die(mysql_error());

    while($row = mysql_fetch_array($result))
    {
        $latestList[] = $row;
    }

//    //get the favourite products to display on home page
    $selectSQL = "SELECT * FROM item, picturelink, rating Where item.ItemID = picturelink.ItemID And
                                                                item.ItemID= rating.ItemID AND
                                                                rating.total_value >= 4 AND item.timeFinish > '".date("Y-m-d H:i:s",time())."' AND
                                                                item.Quantity > 0
                                                        GROUP BY item.ItemID ORDER BY rating.total_value DESC LIMIT 10";

    $result = mysql_query($selectSQL) or die(mysql_error());;

    while($row = mysql_fetch_array($result))
    {
         $favouriteList[] = $row;
    }

    mysql_close($conn);    
    
?>




<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">

<html>
    <head>
    
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">


        <script type="text/javascript" src="<?php echo $PROJECT_PATH;?>javascripts/main.js"></script>
        <link rel="stylesheet" type="text/css" href="<?php echo $PROJECT_PATH;?>css/rating.css" />
        
        <?php
            include("../stylesheet.inc.php");
        ?>

    </head>
    <body>
        <?php
            include("../headSection.inc.php");
        ?>

            <div id="middleSection">
                <div id="sideBarBorder">
                    <label id="bigHeading" style="font-weight:bold; position:absolute; top:5px; left: 30px;">Category List</label>
                    <ul class="categorySideBar">
                    <?php
                        foreach ($categoryList as $category)
                        {
                            ?>
                            <li onmouseover="mOver(this)" onmouseout="mOut(this)" onclick="window.location ='<?php echo $PROJECT_PATH."category/".formatCategoryName($category['CategoryName']);?>';"><?php echo $category['CategoryName'];?></li>
                            <?php

                        }
                    ?>
                    </ul>
                </div>

                <!--[if gte IE 6]>
                    <script type="text/javascript">
                        function mOver(obj)
                        {
                            obj.style.backgroundColor = '#7cc5ff';
                        }
                        function mOut(obj)
                        {
                            obj.style.backgroundColor = 'white';
                        }
                    </script>

                <![endif]-->

                <div id="adBar">
                    <!img class="adBox" src="adImages/navsports.jpg" alt="Nav Sport Ad" onclick="window.location='http://www.navsports.com/'"/>


                    <!img class="adBox" src="adImages/waam.jpg" alt="WAAM Ad" onclick="window.location='http://waam.com.au/'"/>


                    <img style="height: 500px;" class="adBox" src="<?php echo $PROJECT_PATH;?>adImages/twizlaad.jpg" alt="Twizla Ad Long Banner" onclick="window.location='<?php echo $PROJECT_PATH;?>help/helpPage.php'" />

                </div>


                <div id="middleLeftSection" style=" left: 285px; width: 665px;">
                    <label id="bigHeading" style="font-weight:bold">Latest Listing:</label>
                    
                    <div id="latestItemBox" >
                        <!Insert the list of latest products pictures here>
                        <?php
//                            echo var_dump($latestList);
                            if($latestList)
                            {

                                include_once '../displayItemList.inc.php';
                                displayItemList($latestList,10,"", "latestList","buyItemContainer",true, "", false);
                            }
                        ?>
                    </div>
                    
                    <label id="bigHeading" style="font-weight:bold">Favourite Items: </label> (5 out of  <img src ="webImages/5stars.png" alt="5 stars" style="margin-bottom:-10px;"/>)
                    <div id="favouriteItemBox" style="margin-top: 10px;">
                        <!Insert the list of latest products pictures here>
                        <?php
//                            echo var_dump($latestList);
                            if($favouriteList)
                            {

                                include_once '../displayItemList.inc.php';
                                displayItemList($favouriteList,10,"", "favouriteList","buyItemContainer",true, "", false);

                            }
                            else
                            {
                                echo "<label style='padding:20px;'>None at the moment.</label>";
                            }
                        ?>
                    </div>
                </div>
                <!--label style='color:blue;'>".$item['total_value']." stars.</label-->


            </div>
        <!Put end div tag here to complete the div tags start in the included
            file headSection.php for content div>


            <?php
                include("../footerSection.inc.php");
            ?>

            <script type="text/javascript">

                    window.document.body.style.height = 1320 + "px";
                    var middleSession = document.getElementById("middleSection");
//                        var borderBox = document.getElementById("mediumBorderBox");
                    middleSession.style.height = 820 + "px";
//                        borderBox.style.backgroundImage = "url(webImages/largeBoxBorder.png)";
                    //case IE, set grassfooter position
                    if (/MSIE (\d+\.\d+);/.test(navigator.userAgent)) //test for MSIE x.x;
                    {
                        document.getElementById("footer").style.top =  1260   + "px";
                        var grassFooter = document.getElementById("grassFooter");
                        grassFooter.style.top = 1340 + "px";

                    }

            </script>
    </body>
</html>
