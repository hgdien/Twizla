<?php
    session_start();
    include("../mySQL_connection.inc.php");

    include("../loadHome.php");

?>

<!--
    Document   : listItemPage1.php
    Created on : Jan 27, 2010, 12:36:45 PM
    Author     : Peter
    Description:
        The selling page.

    Updated: 27/6/2010


-->

<?php
//     process the script only if the user is logged in
    if(isset($_SESSION['userID']))
    {
        $conn = dbConnect();

        // prepare the query for adding new item into database
        //select all item selled by user which is not yet won
        $sql = "SELECT * FROM item, picturelink WHERE item.ItemID = picturelink.ItemID AND
                                                        SellerID =".$_SESSION['userID']." AND
                                                        item.Quantity > 0
                                                GROUP BY item.ItemID ORDER BY listedDate desc";

        $result = mysql_query($sql) or die(mysql_error());
//        $idString = "(";
        while($row = mysql_fetch_array($result))
        {
            //exclude the item listing that have expired ( ended listing duration)
            $timeFinish = strtotime("+".$row['listDuration']." days",strtotime($row['listedDate']));
            if(($timeFinish - time()) > 0)
            {
                $list[] = $row;
            }
            else
            {
                $expireList[] = $row;
            }
        }
//
        $_SESSION['ItemList'] = $list;
        $_SESSION['unsoldList'] = $expireList;

        $sql = "SELECT * FROM user, userpayment WHERE user.UserID = userpayment.UserID AND user.UserID = ".$_SESSION['userID'];
        $result = mysql_query($sql) or die(mysql_error());
        $currentUser = mysql_fetch_array($result);


        mysql_close($conn);

    }

?>




<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">


<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

        <script type="text/javascript" src="<?php echo $PROJECT_PATH;?>javascripts/main.js"></script>


        <?php
            include("../stylesheet.inc.php");
        ?>
    </head>
    <body>
        <?php
            include("../headSection.inc.php");
        ?>

           <div id="middleSection">
                <div id="middleLeftSection">
                    <?php
                    if(!$_SESSION['username'])
                    {
    //                         var_dump($_GET);
                    ?>
                            <div id="bigHeading">
                                Please login to list items on your personal Twizla store.<br/>
                                Don't have a Twizla account? <br/>
                               <a href="<?php echo $SECURE_PATH;?>registration/">Register</a> in 30 seconds and start listing and checking products.
                            </div>

                    <?php
                    }
                    else
                    {
                    ?>
                    <b><div id="bigHeading">Add New Item for Sale</div></b>
                    <div id="bigHeading">Free to list with no sale fees.</div>
                    <div id="mediumBorderBox">
                        <img id="paperClip" src="<?php echo $PROJECT_PATH;?>webImages/additempaperclip.png" alt="paperClip"/>

                            <?php
                                if(isset($_SESSION['unsoldList']))
                                {
                                    echo "<div id='expireListingBox'>";
                                    echo "<div id='colorHeading' style='background-color:purple;'>Unsold Items</div>";
                                    echo "<ul id='currentListing'>";
                                    //Display 4 unsold item as a representation and link to
                                    //the full unsold item list in my account page
                                    for($count = 0; $count < count($_SESSION['unsoldList']); $count ++)
                                    {
                                        if($count > 3)
                                        {
                                            break;
                                        }
                                        $item = $_SESSION['unsoldList'][$count];

                                        include_once '../imageResize.inc.php';
                                        $imageSize = getimagesize($item['PictureLink']);
                                        echo "<li>
                                                <div id='listedItemBox'>
                                                    <a href='".$PROJECT_PATH."sell/reList/".$item['ItemID']."'>

                                                        <img id='picture' src='".$PROJECT_PATH.$item['PictureLink']."' ".imageResize($imageSize[0],$imageSize[1],  100, 110)." onmousemove='displayRemoveButton(".$item['ItemID'].")' onmouseout='hideRemoveButton(".$item['ItemID'].")' border='0'/>
                                                    </a>
                                                </div>
                                                <a href='../account/removeItem.php?ItemID=".$item['ItemID']."' style='width: 30px;height: 30px;'/>
                                                    <img id='../account/removeItemButton".$item['ItemID']."' class='removeItemButton' src='".$PROJECT_PATH."webImages/cross.png' border='0'  onmousemove='displayRemoveButton(".$item['ItemID'].")' onmouseout='hideRemoveButton(".$item['ItemID'].")'/>
                                                </a>
                                        </li>";
                                    }
                                    echo "</ul>";
                                    echo "<a href='".$PROJECT_PATH."account/sell/3/' style=' position:absolute; bottom:10px; right:10px;'/>see full list...</a>";
                                    echo "</div>";
                                }
                                //display the trolley image used to add new item
                            ?>

                        <div id="currentListingBox">
                            <div id="colorHeading">Current Items</div>
                            <ul id='currentListing'>
                            <?php
                                if(isset($_SESSION['ItemList']))
                                {
                                    //Determine the number of item to display per page.
                                    //For the moment the number of item displayed per page is 11.
                                    $ITEM_PER_PAGE = 11;
                                    $numberOfPage = ceil(count($_SESSION['ItemList']) / $ITEM_PER_PAGE);

                                    //set the number of start item to display
                                    //if there is no current page set by user, the start item number is 0
                                    $startItemNumber = 0;

                                    if(isset($_GET['pageNumber']))
                                    {
                                        $startItemNumber = ($_GET['pageNumber'] - 1) * $ITEM_PER_PAGE;
                                    }

                                    for($count = $startItemNumber; $count < count($_SESSION['ItemList']); $count ++)
                                    {
                                        //break when reach the set number of items displayed on the page
                                        if($count == ($startItemNumber + $ITEM_PER_PAGE))
                                        {
                                            break;
                                        }

                                        $item = $_SESSION['ItemList'][$count];

                                        include_once '../imageResize.inc.php';
                                        $imageSize = getimagesize($item['PictureLink']);

                                        echo "<li>
                                                <div id='listedItemBox'>";

                                        if(!($item['numberOfBid'] > 0))
                                        {
                                                echo "<a href='".$PROJECT_PATH."sell/edit/".$item['ItemID']."'>";
                                        }
                                        else
                                        {
                                                echo "<a href='".$PROJECT_PATH."listing/".$item['ItemID']."/".formatItemTitle($item['ItemTitle'])."'>";

                                        }

                                        echo "<img id='picture' src='".$PROJECT_PATH.$item['PictureLink']."' ".imageResize($imageSize[0],$imageSize[1],  100, 110)." border='0'/>
                                            </a>
                                        </div>";

                                        if($item['numberOfBid'] > 0)
                                        {
                                            echo "<img class='haveBidButton' src='".$PROJECT_PATH."webImages/haveBidIcon.png' alt='biddedImage'/>";
                                        }
                                        else
                                        {
                                            echo "</li>";
                                        }


                                    }
                                }
                                //display the trolley image used to add new item

                            ?>

                                <li><a href="
                                       <?php
                                        if(($currentUser['PaypalEmail'] == "" OR $currentUser['PaypalEmail'] == null) AND ($currentUser['AccountHolder'] == "" OR $currentUser['AccountHolder'] == null)
                                                AND ($currentUser['AddressLine1'] == "" OR $currentUser['AddressLine1'] == null AND ($currentUser['AddressLine2'] == "" OR $currentUser['AddressLine2'] == null)))
                                        {
                                            echo "warningPaymentPage.php";
                                        }
                                        else
                                        {
                                           echo "listItem/";
//                                           if(count($_SESSION['ItemList']) == 0)
//                                               echo "?testList=true";
                                        }

                                       ?>
                                       " style="z-index: 21;"><img src="<?php echo $PROJECT_PATH;?>webImages/trolley.png" alt="trolleypic" border="0" width="110" height="100" /></a>
                                </li>
                            </ul>

                            <?php

                                    //Show the page bar if there is more items to display on the screen.
                                    if($numberOfPage > 1)
                                    {
                                        echo "<ul id='pageBar' style='margin-bottom:4px; margin-left:60px;'>";
                                        echo "<li style='border-style:none; float: left;'><b>Page</b></li>";

                                        if(isset($_GET['pageNumber']))
                                        {
                                            if($_GET['pageNumber'] > 5)
                                            {
                                                //add 3 page links on the left of the current page
                                                $pageBarStart = $_GET['pageNumber'] - 3;

                                                echo "<li><a href='&1/' style='text-decoration: none; color:#213155;'>1</a></li>";
                                                echo "<li>... |</a></li>";
                                            }
                                            else
                                            {
                                                $pageBarStart = 1;
                                            }
                                        }
                                        else
                                        {
                                            echo "<li style='text-decoration:underline;'>
                                                <a href='&1/' style=' color:#F52887;'>1</a>
                                            </li>";
                                            $pageBarStart = 2;
                                        }
                                        for ($count = $pageBarStart; $count <= $numberOfPage; $count++)
                                        {
                                           //stop when there is 3 page link on the right of the current page
                                            if($count > ($pageBarStart + 6))
                                            {
                                                //if there is more than 1 page link still not display, then add ...
                                                if(($count + 1 ) < $numberOfPage)
                                                {
                                                    echo "<li>...</a></li>";
                                                    echo "<li style='border:0;'>
                                                            <a href='&$numberOfPage/' style='text-decoration: none; color:#213155;'> $numberOfPage</a>
                                                        </li>";
                                                }
                                                //if there is still hidden page link then insert the next page button
                                                if($count < $numberOfPage)
                                                {
                                                    if(!isset($_GET['pageNumber']))
                                                    {
                                                        $currentPage = 1;
                                                    }
                                                    else
                                                    {
                                                        $currentPage = $_GET['pageNumber'];
                                                    }
                                                    echo "<li style='border: 0;'><a href='&".($currentPage + 1)."/'><img  id='nextPageButton' src='".$PROJECT_PATH."webImages/pageBarButton.png' border='0'/></a></li>";
                                                }
                                                break;
                                            }
                                            //bold format the current page
                                            if($count == $_GET['pageNumber'])
                                            {
                                                echo "<li style='text-decoration:underline;'>
                                                        <a href='&$count/' style='color:#F52887;'>$count</a>
                                                    </li>";
                                            }
                                            else
                                            {
                                                echo "<li>
                                                        <a href='&$count/' style='text-decoration: none; color:#213155;'>$count</a>
                                                    </li>";
                                            }
                                        }
                                        echo "</ul>";
                                    }
                            ?>


                        </div>
                    </div>

                    <?php
                        }
                    ?>

                </div>
                <!--label style='color:blue;'>".$item['total_value']." stars.</label-->

            <?php
                if(!isset($_GET['height']))
                {
                    include("../middleRightSection.inc.php");
                }

            ?>

            </div>


            <?php
                include("../footerSection.inc.php");
            ?>

            <?php
            if($_SESSION['username'])
            {
            ?>
                <script type="text/javascript">
                    //set the longer body height to fit in the unsold item list
                    var unsoldList = <?php echo count($_SESSION['unsoldList']);?>;

                    if(parseInt(unsoldList) > 0)
                    {
                        window.document.body.style.height = 1390 + "px";
                        var middleSession = document.getElementById("middleSection");
                        var borderBox = document.getElementById("mediumBorderBox");
                        middleSession.style.height = 840 + "px";

                        borderBox.style.backgroundImage = "url(webImages/largeBoxBorder.png)";

                        var grassFooter = document.getElementById("grassFooter");
                        grassFooter.style.top = 1360 + "px";
                    }
                </script>

        <?php
            }
        ?>
    </body>
</html>
