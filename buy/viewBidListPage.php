<?php
    session_start();
    include("../mySQL_connection.inc.php");
    include("../login.php");
    include('../loadHome.php');
    include ("getItemDetail.inc.php");

    //create connection and connect to the Twizla database
    $conn = dbConnect();
    $sql = "SELECT * FROM bid, user WHERE ItemID = ".$_GET['ItemID']." AND bid.BidderID = user.UserID ORDER BY bidAmount DESC";

    $result = mysql_query($sql) or die(mysql_error());

    while($row = mysql_fetch_array($result))
    {
        $bidList[] = $row;
    }

    if(isset($_SESSION['userID']))
    {
        $sql = "SELECT * FROM user WHERE UserID = ".$_SESSION['userID'];

        $result = mysql_query($sql) or die(mysql_error());
        $currentUser =  mysql_fetch_array($result);

        //get the seller ID to check if the seller is watching the bidlist
        $sql = "SELECT UserID FROM user, item WHERE user.UserID = item.SellerID AND item.ItemID = ".$_GET['ItemID'];

        $result = mysql_query($sql) or die(mysql_error());
        $row = mysql_fetch_array($result);
        $sellerID = $row['UserID'];
    }

    mysql_close($conn);



?>

<!--
    Document   : viewItemBidPage.php
    Created on : Feb 9, 2010, 12:36:45 PM
    Author     : Peter
    Description:
        The main page.

    Updated: 9/2/2010
-->


<!Include php files for login, sign up function>


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
                        putenv("TZ=Australia/Sydney");
                        $timeRemain = strtotime($item['timeFinish']) - (time());
                        //check if the item is unsold or deleted
                        if(isset($_GET['confirm']))
                        {
                            echo "<div id='bigHeading'>Thank you for purchase this item.</div><br>";
                            echo "<a href='paymentPage.php' style='text-decoration:none;'><button id='button2'>Pay Now</button></a> or check out <a href='searchProductPage.php?searchSubmit=true&SellerID=".$_GET['SellerID']."'>other items listed by this seller</a>";
                        }
                        else if((count($item) == 0 OR $timeRemain < 0) AND !isset($_GET['view']))
                        {
                            echo "<label id='bigHeading'>This item is no longer available.<br/>You can check out
                                <a href='searchProductPage.php?searchSubmit=true&searchString=&searchCategory=".urlencode($item['CategoryName'])."'/>other products</a>
                                that belong to the same category.
                                </label>";

                        }
//                        else if(!isset($_SESSION['username']))
//                        {
//
//                            <!--div id="bigHeading">
//                                You must login to buy this item.<br/>
//                                Don't have a Twizla account? <br/>
//                               <a href="registrationPage.php">Register</a> in 30 seconds and start listing and checking products.
//                            </div-->

//                        }
                        else
                        {
                    ?>
                            <label id="bigHeading">Review and Confirmation</label>
                            <label style="font-size:14px; position: relative; left: 325px;"><a href="<?php echo $PROJECT_PATH."listing/".$_GET['ItemID']."/".formatItemTitle($item['ItemTitle']);?>"> >> Back to Item Detail </a></label>
                            <br><br>
                            <b>Item Number: </b><?php echo $item['ItemID']; ?>
                            <br>
                            <b>Item Title:  </b><?php echo $item['ItemTitle'];?>
                            <br>
                            <b>Number of bids: </b><?php echo $item['numberOfBid'];?>
                            <br>
                            <b>Time Remaining: </b>

                            <?php
                                $A_DAY_TIMESTAMP = 24*60*60;
                                $A_HOUR_TIMESTAMP = 60*60;
                                $dayRemain = floor($timeRemain/$A_DAY_TIMESTAMP);
                                $hourRemain = floor(($timeRemain - ($dayRemain * 24*60*60))/$A_HOUR_TIMESTAMP) ;

                                if($timeRemain <= 0)
                                {
                                    echo " Ended.";
                                }
                                else if($dayRemain < 1) //if less than one day display the countdown clock
                                {
                                    ?>

                                    <script type="text/javascript">
                                        countdown_clock(<?php echo strtotime($item['timeFinish']);?>, <?php echo time();?>);
                                    </script>
                                <?php
                                    echo "&nbsp;  (".date("d M, Y H:i:s T",strtotime($item['timeFinish'])).")";
                                }
                                else
                                {
                                    echo $dayRemain ." days ".$hourRemain." hours (".date("d M, Y H:i:s T",strtotime($item['timeFinish'])).")";
                                }

                            ?>
                            <br><br>
                            <div style="overflow: auto; height: 444px; width: 695px;">
                            <table id="bidTable" border="1">
                                <tr>
                                    <th><div style='width:200px;'>Bidder</div></th>
                                    <th><div style='width:200px;'>Bid Amount</div></th>
                                    <th><div style='width:200px;'>Bid Time</div></th>
                                </tr>

                                <?php
                                    if(count($bidList) > 0)
                                    {
//                                        for($c = 0; $c< 6; $c++)
//                                        {
//                                            $bidList[] = $bidList[0];
//                                        }
                                        
                                        foreach($bidList as $bid)
                                        {

                                            echo "<tr><td>";
                                            //only display the name of current user
                                            //for other users, keep the identity hidden for security purpose
                                            if(!isset($_SESSION['userID']))
                                            {
                                                echo "Bidder - Identity Protected";
                                            }
                                            else if($bid['BidderID'] == $_SESSION['userID'])
                                            {
                                            ?>
                                                <a href="<?php echo $PROJECT_PATH."user/".$currentUser['UserName']."/";?>"><?php echo $currentUser['UserName'];?></a>
                                            <?php
                                                echo "  ( ".$currentUser['feedbackPoint'];

                                                include_once 'showMemberIcon.inc.php';
                                                showIcon($currentUser);

                                                echo " )";


                                            }
                                            else if($_SESSION['userID'] == $sellerID)
                                            {
                                            ?>
                                                <a href="<?php echo $PROJECT_PATH."user/".$bid['UserName']."/";?>"><?php echo $bid['UserName'];?></a>
                                            <?php
                                                echo "  ( ".$bid['feedbackPoint'];

                                                include_once 'showMemberIcon.inc.php';
                                                showIcon($bid);

                                                echo " )";
                                            }
                                            else
                                            {
                                                echo "Bidder - Identity Protected";
                                            }
                                            echo "</td>";

                                            if(($bid['BidAmount'] > $item['currentBid']) AND ($bid['BidderID'] != $_SESSION['userID']))
                                            {
                                                echo "<td>".$item['currentBid']."</td>";
                                            }
                                            else
                                            {
                                                echo "<td>".$bid['BidAmount']."</td>";
                                            }
                                            
                                            echo "<td>".date('M-d-Y H:i:s T',strtotime($bid['BidTime']))."</td></tr>";
                                        }

                                        echo "<tr>";
                                        echo "<td>Starting Price</td>";
                                        echo "<td>".$item['startingBid']."</td>";
                                        echo "<td>".$item['listedDate']."</td>";
                                        echo "</tr>";
                                    }
                                    else
                                    {
                                        echo "<tr><td colspan='3'>There are currently no bid place on this item.</td></tr>";
                                    }
                                ?>

                            </table>
                            </div>


                    <?php
                        }
                    ?>
                </div>

                <?php
                    include("../middleRightSection.inc.php");
                ?>
            </div>

            <?php
                include("../footerSection.inc.php");
            ?>

    </body>
</html>
