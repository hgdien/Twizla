<?php
    session_start();
    include("../mySQL_connection.inc.php");
//    Include php files for login, sign up function
    include("../login.php");

    include("../loadHome.php");

    //clear any warning left over from previous actions
    $warning ="";
    if(isset($_GET['UserName']))
    {
        $conn = dbConnect();
        //get the user information
        $selectSQL = "SELECT * FROM user WHERE UserName = '".$_GET['UserName']."'";
//        echo $selectSQL;
        $result = mysql_query($selectSQL) or die(mysql_error());
        $user = mysql_fetch_array($result);

        if($user['State_Country'] != null)
        {
            $selectSQL = "SELECT * FROM state_country WHERE State_CountryID = ".$user['State_Country'];

            $result = mysql_query($selectSQL) or die(mysql_error());
            $row = mysql_fetch_array($result);
            $user['State_CountryName'] = $row['State_CountryName'];
        }
        else
        {
            $user['State_CountryName'] = "";
        }
        
        $positiveBuy = 0;
        $neutralBuy = 0;
        $negativeBuy = 0;
        $positiveSell = 0;
        $neutralSell = 0;
        $negativeSell = 0;

        //get feedback information
            $buyerFeedbackList = array();
            $sellerFeedbackList = array();
            $allFeedbackList = array();
            //get feeback list with user as seller
            $selectSQL = "SELECT * FROM feedback, sale, item, user WHERE feedback.SaleID = sale.SaleID AND
                                                                    sale.ItemID = item.ItemID AND
                                                                    item.SellerID = ".$user['UserID']." AND
                                                                    user.UserID = sale.BuyerID AND
                                                                    feedback.buyerComment IS NOT NULL
                                                                GROUP BY feedback.FeedbackID
                                                                ORDER BY feedback.buyerFeedbackDate DESC";
                                                                
            $result = mysql_query($selectSQL) or die(mysql_error());
            while($row = mysql_fetch_array($result))
            {
                 $sellerFeedbackList[] = $row;
                 if($row['buyerRating'] == '1')
                 {
                     $positiveSell ++;
                 }
                 else if($row['buyerRating'] == '0')
                 {
                     $neutralSell ++;
                 }
                 else
                 {
                     $negativeSell ++;
                 }
            }

            //get feeback list with user as buyer
            $selectSQL = "SELECT * FROM feedback, sale, user, item WHERE feedback.SaleID = sale.SaleID AND
                                                                    sale.ItemID = item.ItemID AND
                                                                    user.UserID = item.SellerID AND
                                                                    sale.BuyerID = ".$user['UserID']." AND
                                                                    feedback.sellerComment IS NOT NULL
                                                                GROUP BY feedback.FeedbackID
                                                                ORDER BY feedback.sellerFeedbackDate DESC";
//echo $selectSQL;
            $result = mysql_query($selectSQL) or die(mysql_error());
            while($row = mysql_fetch_array($result))
            {
                 $buyerFeedbackList[] = $row;
                 if($row['sellerRating'] == '1')
                 {
                     $positiveBuy ++;
                 }
                 else if($row['sellerRating'] == '0')
                 {
                     $neutralBuy ++;
                 }
                 else
                 {
                     $negativeBuy ++;
                 }
            }
            //get all feedback for this user          
            //merge all feedback , then sort the list by feedback date
            $allFeedbackList = array_merge($buyerFeedbackList, $sellerFeedbackList);

            //function to compare feedbackdate
            function cmp_date( $a, $b )
            {
                //compare the type of feedback date based on the user is a seller or buyer
                if( $a['SellerID'] == $user['UserID'])
                {
                    $a_date = strtotime($a['buyerFeedbackDate']) ;

                }
                else
                {
                    $a_date = strtotime($a['sellerFeedbackDate']) ;
                }

                if( $b['SellerID'] == $user['UserID'])
                {
                    $b_date = strtotime($b['buyerFeedbackDate']) ;

                }
                else
                {
                    $b_date = strtotime($b['sellerFeedbackDate']) ;
                }

                if( $a_date == $b_date ) return 0 ;
                return ($a_date > $b_date ) ? -1 : 1;
            }

            usort($allFeedbackList, "cmp_date") ;


        //get item listing by this user
        $selectSQL = "SELECT * FROM item, picturelink WHERE item.ItemID = picturelink.ItemID AND
                                                            item.SellerID = ".$user['UserID']." AND
                                                            timeFinish > '".date("Y-m-d H:i:s",time())."' AND
                                                            item.ItemID NOT IN (SELECT ItemID FROM sale)
                                                        GROUP BY item.ItemID
                                                        ORDER BY item.listedDate DESC";
//        echo $selectSQL;
        $result = mysql_query($selectSQL) or die(mysql_error());
        while($row = mysql_fetch_array($result))
        {
             $sellingList[] = $row;

        }

        //check if the user have some eBay feedback imported
        $selectSQL = "SELECT * FROM ebay_imported_list WHERE UserID = ".$user['UserID'];

        $result = mysql_query($selectSQL) or die(mysql_error());

        //if user have already imported in the past, user is trying to access importer
        //illegally, go back to main page
        if(mysql_num_rows($result))
        {
            $imported = mysql_fetch_array($result);

        }

        mysql_close($conn);

        //include the function to display the feedbackList
        include_once 'displayFeedbackList.inc.php';
    }
?>

<!--
    Document   : viewUserProfilePage.php
    Created on : Dec 22, 2009, 12:36:45 PM
    Author     : Peter
    Description:
        The main page.

    Updated: 27/1/2010
-->

<?php

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

        <link rel="stylesheet" type="text/css" href="<?php echo $PROJECT_PATH;?>css/viewUserProfile_firefox.css" />

        <!--[if gte IE 6]>
        <link rel="stylesheet" type="text/css" href="<?php echo $PROJECT_PATH;?>css/viewUserProfile_ie.css" />
        <![endif]-->

    </head>
    <body>
        <?php
            include("../headSection.inc.php");
        ?>

            <div id="middleSection">

                <?php
                    if(!isset($_GET['UserName']))
                    {
//                         var_dump($_GET);
                ?>
                    <div id="bigHeading">
                        There is a problem with directing this page.<br/>
                        This user is either missing or you are trying to access the page illegally.<br/>
                    </div>
                <?php
                    }
                    else
                    {
                        //set up the left side control panel
                ?>      <ul id="sideBar">
                            <li><img src="<?php echo $PROJECT_PATH;?>webImages/myprofile.png" alt="myProfileIcon"/> <a href="<?php echo $PROJECT_PATH."user/".$user['UserName']."/";?>">Profile</a></li>
                            <?php
                                //if the current user is viewing their own profile, don't display the contact function
                                if($user['UserID'] == $_SESSION['userID'])
                                {
                            ?>
                                    
                                    <li><img src="<?php echo $PROJECT_PATH;?>webImages/mysell.png" alt="mysellingIcon"/> <a href="<?php echo $PROJECT_PATH;?>myAccountPage.php?page=Sell">Listing items</a></li>
                            <?php
                                }
                                else
                                {
                            ?>
                                    <li><img src="<?php echo $PROJECT_PATH;?>webImages/emaildownload.png" alt="contactMeIcon"/> <a href="<?php echo $PROJECT_PATH."user/".$user['UserName']."/contact";?>">Contact this user</a></li>
                                    <li><img src="<?php echo $PROJECT_PATH;?>webImages/mysell.png" alt="mysellingIcon"/> <a href="<?php echo $PROJECT_PATH."user/".$user['UserName']."/sellingList";?>">Listing items</a></li>
                            <?php
                                }
                            ?>
                        </ul>
                        <div id="rightDiv">
                            <div id="bigHeading" style="position: relative; left:35px; top:10px"><?php echo $user['UserName'];?> <label style="font-weight:normal; font-size: 18px;">( <?php echo $user['feedbackPoint']; include_once 'showMemberIcon.inc.php'; showIcon($feedback); ?> )</label></div>


                            <table id="ratingTable" >
                                <!--tr>
                                    <td>Rating score:</td>
                                    <td style="padding-top:5px;"></td>
                                </tr-->
                                <tr>
                                    <td><img src="<?php echo $PROJECT_PATH;?>webImages/smileicon.png" alt="smileIcon" class="emotionIcon"/> Positive feedback:</td>
                                    <td style="padding-top:5px;"><?php echo ($positiveBuy + $positiveSell);?></td>
                                </tr>
                                <tr>
                                    <td><img src="<?php echo $PROJECT_PATH;?>webImages/neutralicon.png" alt="neutralIcon" class="emotionIcon"/> Neutral feedback:</td>
                                    <td style="padding-top:5px;"><?php echo ($neutralBuy + $neutralSell);?></td>
                                </tr>
                                <tr>
                                    <td><img src="<?php echo $PROJECT_PATH;?>webImages/negativeicon.png" alt="negativeIcon" class="emotionIcon"/> Negative feedback:</td>
                                    <td style="padding-top:5px;"><?php echo ($negativeBuy + $negativeSell);?></td>
                                </tr>
                            </table>
                            <div id="profileInfo">
                            <!--div><div style="font-weight: bold; width: 110px; float: left;">Full Name: </div><label><?php //echo $user['FirstName']." ".$user['LastName'];?></label></div>
                            <div><div style="font-weight: bold; width: 110px; float: left;">State: </div><label><?php //echo $user['State_CountryName'];?></label></div-->
                            <div><div style="font-weight: bold; width: 110px; float: left;">Member since: </div><label><?php echo date('d-M-Y',strtotime($user['registerDate']));?></label></div>
                            </div>

                            
                            <?php
                            if($imported)
                            {
                                echo "<div style='margin: 2px; font-size: 10px;'>&nbsp;&nbsp;&nbsp;This user has ".$imported['FeedbackPoint']." points imported from his/her eBay feedback history on ".$imported['Date'].".</div>";
                            }
                            else
                            {
                                echo "<br>";
                            }

                            if(isset($_GET['contact']))
                            {
                                if(!isset($_SESSION['userID']))
                                {
                                    echo "<div id='bigHeading'>You have to log in before be able to send message to this member.</div>";
                                }
                                else
                                {
                            ?>
                                    <div id="blackHeading" style="margin-left:20px;">Send a message to <?php echo $user['UserName'];?>:</div>
                                    <form id="sendMessageForm" method="POST" action="sendMessage.php">                                       
                                        <input type="hidden" name="submitSendMessage" value="true"/>
                                        <input type="hidden" name="senderID" value="<?php echo $_SESSION['userID'];?>"/>
                                        <input type="hidden" name="receiverName" value="<?php echo $user['UserName'];?>"/>
                                        <input type="hidden" name="receiverID" value="<?php echo $user['UserID'];?>"/>
                                        

                                        <label style="font-weight:bold;">Subject:</label><br/>
                                        <input type="text" size="80" maxLength="80" id="subjectInput" name="subject" style=" margin-top: 5px; width: 420px;"/>
                                        <br/><br/>
                                        <label style="font-weight:bold;">Message content:</label><br/>
                                        <textarea rows="8" cols="50" name="mesgContent" id="mesgContent" style=" margin-top: 5px; width: 420px;" onKeyDown="limitText(this.form.mesgContent,1000);" onKeyUp="limitText(this.form.mesgContent,1000);"></textarea>
                                        <br/>
                                        <label id="wordCount" style="font-size:12px; color:blue; font-style: italic; margin-left: 310px;">1000 characters left</label>
                                        <br/>
                                        <!input id="button2" name="sendMessage" type="button" value="Send" onclick="submitMessageForm(this.form)" style="margin-left:50px;"/>
                                        <img id="buttonImage" name="sendMessage" src="<?php echo $PROJECT_PATH;?>webImages/sendbutton.png" alt="SendButton" onclick="submitMessageForm(document.getElementById('sendMessageForm'))" style="margin-left:50px;"/>
                                        <!input id="button" name="resolveSubmit" type="button" value="Clear" style="margin-left:50px;" onclick="clearMessageForm()"/>
                                        <img id="buttonImage" name="resolveSubmit" src="<?php echo $PROJECT_PATH;?>webImages/clearbutton.png" alt="ClearButton" style="margin-left:50px;" onclick="clearMessageForm()"/>
                                        <br/><br/>
                                        <label id="warningPanel"><?php if(isset($_GET['message'])) echo $_GET['message'];?></label>
                                    </form>
                                    <div style="position:absolute; bottom: 25px; width: 700px; margin-left: 30px;">
                                    - Do not use the Twizla member-to-member message facility to bypass the auction or buying process or send SPAM to other members. Any attempts to do so may result in your account being suspended.<br><br>
                                    - All member-to-member messages are recorded by the Twizla system.
                                    </div>
                                    

                                    <script language="javascript" type="text/javascript">
                                        //if editing the item, set the remaining number of characters.
                                        var mesgContent = document.getElementById("mesgContent");
                                        limitText(mesgContent,1000);

                                    </script>
                            <?php
                                }
                            }
                            else if(isset($_GET['sellingList']))
                            {

                                echo "<br/><label id='bigHeading' style='margin-left:10px;'>Selling Items:</label>";
                                //display the unsold list
                                include_once '../displayItemList.inc.php';
                                $link = $PROJECT_PATH."user/".$user['UserName']."/sellingList";
//                                for($count = 0; $count < 15; $count++)
//                                {
//                                    $sellingList[] =$sellingList[0];
//                                }
                                echo "<div id='sellingList'>";
                                displayItemList($sellingList,12,"", 'sellingList','searchItemContainer',true,$link,"");
                                echo "</div>";

                            }
                            else
                            {
                            ?>
                                <br/>
                                <div class="TabView" id="TabView">
                                    

                                    <!-- ***** Tabs ************************************************************ -->

                                    <div class="Tabs" style="width: 769px;">
                                      <a class="Current" onclick="window.location = 'viewUserProfilePage.php?UserName=<?php echo $user['UserName'];?>&tab=1';">All</a>
                                      <a  onclick="window.location = 'viewUserProfilePage.php?UserName=<?php echo $user['UserName'];?>&tab=2';">Buy</a>
                                      <a onclick="window.location = 'viewUserProfilePage.php?UserName=<?php echo $user['UserName'];?>&tab=3';">Sell</a>
                                    </div>


                                    <!-- ***** Pages *********************************************************** -->

                                    <div class="Pages" style="width: 768px; height: 440px;">
                                      <div class="Page" style="display:  none;">
                                          <div class="Pad">
                                          <!All feedbacks>
                                          <div id="feedbackTabPanel">
                                            <?php
                                                echo "<div style='font-size:12px;'>Total ".count($allFeedbackList). " feedback(s).</div><br>";
//                                                $pageLink = 'viewUserProfilePage.php?UserName='.$user['UserName'].'&tab=2';
//                                                    for($count = 0; $count < 10; $count ++)
//                                                    {
//                                                        $allFeedbackList[] = $allFeedbackList[0];
//                                                    }
                                                displayFeedbackList($allFeedbackList, $user);
                                            ?>
                                          </div>
                                          </div>
                                      </div>

                                      <div class="Page" style="display: block;">
                                          <div class="Pad">
                                              <!Buy feedbacks>
                                            <div style=" height: 415px; width: 720px; padding-left: 25px; padding-top: 5px; padding-bottom: 5px; ">
                                                <?php
                                                    echo "<div style='font-size:12px;'>Total ".count($buyerFeedbackList). " buying feedback(s).</div><br>";
//                                                    $pageLink = 'viewUserProfilePage.php?UserName='.$user['UserName'].'&tab=2';
//                                                    for($count = 0; $count < 10; $count ++)
//                                                    {
//                                                        $buyerFeedbackList[] = $buyerFeedbackList[0];
//                                                    }

                                                    displayFeedbackList($buyerFeedbackList, $user);
                                                ?>
                                            </div>
                                          </div>

                                      </div>

                                      <div class="Page" style="display:  none;">
                                          <div class="Pad">
                                            <!Sell feedbacks>
                                            <div style=" height: 415px; width: 720px; padding-left: 25px; padding-top: 5px; padding-bottom: 5px; ">
                                                <?php
                                                    echo "<div style='font-size:12px;'>Total ".count($sellerFeedbackList). " selling feedback(s).</div><br>";
//                                                    $pageLink = 'viewUserProfilePage.php?UserName='.$user['UserName'].'&tab=3';
                                                    displayFeedbackList($sellerFeedbackList, $user);
                                                ?>
                                            </div>
                                          </div>
                                          </div>

                                      </div>
                                    </div>

                                    <script type="text/javascript">
                                        tabview_initialize('TabView', <?php if(!isset($_GET['tab'])){ echo "1";} else{ echo $_GET['tab'];} ?>);
                                    </script>
                                

                            <?php
                            }
                            ?>
                        </div>
                    <?php
                    }
                    ?>
            </div>

            <?php
                include("../footerSection.inc.php");
            ?>
    </body>
</html>
