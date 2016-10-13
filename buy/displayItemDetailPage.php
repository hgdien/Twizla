<?php
    session_start();
    include("../mySQL_connection.inc.php");
    include("../login.php");

    include("../loadHome.php");
    require('_drawrating.php');

    include ("getItemDetail.inc.php");

    $conn = dbConnect();

    //check if the item is tagged by the user
    if(isset($_SESSION['username']))
    {


        $selectSQL = "SELECT TagID FROM itemtag
                           WHERE ItemID =".$item['ItemID']." AND UserID=".$_SESSION['userID'];


        $result = mysql_query($selectSQL) or die(mysql_error());
        $numRows = mysql_num_rows($result);
        $tagged = false;
        // if $numRows is positive, the item is tagged
        if ($numRows)
        {
            $tagged = true;
        }

        //check to see if the item has been paid or not yet
       if(isset($_GET['sold']))
       {
           //for seller to review sold item
            if(isset($_GET['view']) AND $item['SellerID'] == $_SESSION['userID'])
            {
                $selectSQL = "SELECT * FROM user
                                   WHERE UserID =".$_GET['BuyerID'];


                $result = mysql_query($selectSQL) or die(mysql_error());
                $buyer = mysql_fetch_array($result);

                //get the state of the user
                if($buyer['State_CountryName'] != null)
                {
                    $displayItemSQL = "SELECT * FROM state_country WHERE state_country.State_CountryID = ".$buyer['State_Country'];

                    $result = mysql_query($displayItemSQL) or die(mysql_error());;

                    $row = mysql_fetch_array($result);
                    $buyer['State_CountryName'] = $row['State_CountryName'];
                }
                else
                {
                    $buyer['State_CountryName'] = "";
                }

            }


            $selectSQL = "SELECT * FROM sale
                           WHERE ItemID =".$item['ItemID'];

            $result = mysql_query($selectSQL) or die(mysql_error());
            $row = mysql_fetch_array($result);
            $paid = $row['Paid'];

            if($paid)
            {
                $usedMethod = $row['PaymentMethod'];
            }
       }




    }
    mysql_close($conn);

    //include the functions to get the bidIncrement
    include_once 'bidFunctions.inc.php';


?>

<!--
    Document   : displayItemDetailPage.php
    Created on : Jan 27, 2010, 12:36:45 PM
    Author     : Peter
    Description:
        The item listing detail page.

    Updated: 27/6/2010


-->

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">


<html  xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml" xmlns:og="http://opengraph.org/schema/">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

        <meta property="og:title" content="<?php echo $item['ItemTitle'];?>"/>
        <meta property="og:type" content="movie"/>
        <meta property="og:url" content="<?php echo $PROJECT_PATH."listing/".$item['ItemID']."/".formatItemTitle($item['ItemTitle']);?>">
        <meta property="og:image" content="<?php echo PROJECT_PATH.$pictureList[0];?>"/>
        <meta property="og:site_name" content="Twizla Online Auction"/>
        <meta property="fb:app_id" content="107886915933327"/>
        <meta property="og:description"
              content="<?php echo $item['Description'];?>"/>

        <link rel="stylesheet" type="text/css" href="<?php echo $PROJECT_PATH;?>css/rating.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo $PROJECT_PATH;?>css/viewUserProfile.css" />

        <script type="text/javascript" src="<?php echo $PROJECT_PATH;?>javascripts/main.js"></script>

        <!include the css and scripts for rating bar>
        <script type="text/javascript" language="javascript" src="<?php echo $PROJECT_PATH;?>javascripts/behavior.js"></script>
        <script type="text/javascript" language="javascript" src="<?php echo $PROJECT_PATH;?>javascripts/rating.js"></script>

        <?php
            include("../stylesheet.inc.php");
        ?>

        <!code for the share this button>
        <script type="text/javascript" src="http://w.sharethis.com/button/sharethis.js#publisher=4343c4c8-3b79-430e-8217-3cbce3bcbc34&amp;type=website&amp;post_services=facebook%2Ctwitter%2Cmyspace%2Cdigg%2Cdelicious%2Cemail%2Csms%2Cwindows_live%2Cstumbleupon%2Creddit%2Cgoogle_bmarks%2Clinkedin%2Cbebo%2Cybuzz%2Cblogger%2Cyahoo_bmarks%2Cmixx%2Ctechnorati%2Cfriendfeed%2Cpropeller%2Cwordpress%2Cnewsvine%2Cxanga&amp;headerbg=%23213155&amp;headerTitle=Share%20this%20Twizla%20Item&amp;button=false"></script>
        <style type="text/css">

        a.stbar.chicklet img {border:0;height:16px;width:16px;margin-right:3px;vertical-align:middle;}
        a.stbar.chicklet {height:16px;line-height:16px;}
        </style>

        <!script to insert javascript for jquery tooltip>
        <script type="text/javascript">
            $(document).ready(function() {
                $("#itemPicture").tooltip('#enlargeTip');
            });
        </script>

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
                        if((count($item) == 0 OR $timeRemain < 0) AND !isset($_GET['view']) AND !isset($_GET['recent']))
                        {
                            echo "<label id='bigHeading'>This item is no longer available.<br/>You can check out
                                <a href='".$PROJECT_PATH."searchProductPage.php?searchSubmit=true&searchString=&searchCategory=".urlencode($item['CategoryName'])."'/>other products</a>
                                that belong to the same category.
                                </label>";
                            echo "";
                        }
                        else
                        {
                    ?>
                        <!Firework to display to the user when an auction ended.>
                        <div id="fireWork" style="border: 1px solid;position: absolute; left: 50%; top: 12%; width: 540px; height: 500px; z-index: 3; display:none;" >
                            <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="540" height="500"
                                    codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,16,0">
                                <param name="movie" value="webVideos/fireWorks.swf">
                                <param name="quality" value="high">
                                <!param name="wmode" value="opaque">
                                <!param name="wmode" value="transparent">
                                <param name="bgcolor" value="#000">
                                <embed src="webVideos/fireWorks.swf"  width="540" height="500" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer"
                                type="application/x-shockwave-flash" bgcolor="#000">
                                </embed>
                            </object>
                        </div>
                        <div id="categoryDetailString" ><?php echo $categoryString; ?></div>
                        <br>
                        <label id="bigHeading" style="font-weight: bold; width: 1000px;"><?php echo $item['ItemTitle']; ?></label><br>
                        <div id="itemNumber" ><b>Item Number:</b> <?php echo $item['ItemID']; ?></div>


                        <div id="bigHeading" ><?php echo $item['CatchPhrase']; ?></div>
                        <?php
                            //check if the item is listed during the last 3 day
                            //if it is, display the new tag picture
                            $isNew = $item['listedDate'] >= date("Y-m-d", strtotime("-3 days"));
    //                        echo $item['listedDate']." ".date("Y-m-d", strtotime("-3 days"))." ".$isNew;
                            if($isNew)
                            {
                                echo "<img id='newTag' src='".$PROJECT_PATH."webImages/newtag.png' alt='newTag'/>";
                            }
                        ?>

                        <div id="itemDetailBox">
                            <table id="itemProperties">
                                <tr>
                                    <td rowspan="3">
                                        <?php
                                                include_once '../imageResize.inc.php';
                                                $imageSize = getimagesize("../".$pictureList[0]);
                                        ?>
                                        <div id="enlargeTip">Click on the inner picture to view the enlarge version.</div>

                                        <div id="itemPicture" >
                                            <input type="hidden" id="picMode" value="small" />
                                            <img id="picture" src="<?php echo $PROJECT_PATH.$pictureList[0];?>" alt="<?php echo $pictureList[0]?>" <?php echo imageResize($imageSize[0],$imageSize[1],  200, 325);?>
                                                 onClick="displayBigPic(1);"/>

                                        </div>
                                        <!img id="enlargeButton" src="webImages/imagezoomglass.png" alt="imagezoomglass" onclick="displayEnlargePic()"/>
                                        <ul id="smallPictureList">
                                            <!Shall be replace later with dynamic php to list all item pictures>
                                            <?php
                                                $count = 0;
                                                foreach( $pictureList as $picture)
                                                {
                                                    $count ++;
                                                    $imageSize = getimagesize("../".$picture);
                                                    echo "<input type='hidden' id='resize_smallPic$count' value='".imageResize($imageSize[0],$imageSize[1],  200, 325)."' />";

                                                    $useragent = $_SERVER['HTTP_USER_AGENT'];

                                                    if (preg_match('|MSIE ([0-9].[0-9]{1,2})|',$useragent,$matched))
                                                    {
                                                        echo "<input type='hidden' id='resizeBig_smallPic$count' value='".imageResize($imageSize[0],$imageSize[1],  595, 685)."' />";
                                                    }
//                                                    elseif (preg_match( ‘|Opera ([0-9].[0-9]{1,2})|’,$useragent,$matched)) {
//                                                        $browser_version=$matched[1];
//                                                        $browser = ‘Opera’;
//                                                    }
                                                    else if(preg_match('|Firefox/([0-9\.]+)|',$useragent,$matched))
                                                    {
                                                            echo "<input type='hidden' id='resizeBig_smallPic$count' value='".imageResize($imageSize[0],$imageSize[1],  595, 680)."' />";
                                                    }
                                                    else
                                                    {
                                                            echo "<input type='hidden' id='resizeBig_smallPic$count' value='".imageResize($imageSize[0],$imageSize[1],  595, 680)."' />";
                                                    }
//                                                    elseif(preg_match('|Safari/([0-9\.]+)|',$useragent,$matched)) {
//                                                            $browser_version=$matched[1];
//                                                            $browser = ‘Safari’;
//                                                    } else {
//                                                            // browser not recognized!
//                                                        $browser_version = 0;
//                                                        $browser= ‘other’;
//                                                    }

//                                                    echo "<input type='hidden' id='resizeBig_smallPic$count' value='".imageResize($imageSize[0],$imageSize[1],  595, 685)."' />";
                                            ?>
                                                    <li  onclick='setItemPicture(<?php echo $count?>)'>
                                                        <img id="smallPic<?php echo $count?>" src="<?php echo $PROJECT_PATH.$picture;?>" <?php echo imageResize($imageSize[0],$imageSize[1],  30, 50);?> alt="<?php echo $picture?>"/>
                                                    </li>
                                            <?php
                                                }
                                            ?>

                                        </ul>
                                    </td>
                                    <td>
                                       <?php
                                       if(isset($_GET['sold']))
                                       {
                                           if(isset($_GET['recent']))
                                           {
                                               ?>
                                                <!--table id="grayBox" style="padding: 15px; width: 330px; font-size:14px;">
                                                <tr>
                                                    <td style="text-align: center;">
                                                    <div class='colorLabel'>SOLD</div>
                                                    </td>

                                                </tr>
                                                </table-->
                                                <img id="soldTag" alt="SoldTagImage" src="<?php echo $PROJECT_PATH;?>webImages/soldTag.png" style="margin-left: 55px;"/>
                                                <?php
                                           }
                                           else if($paid)
                                           {
                                               if($item['SellerID'] != $_SESSION['userID'])
                                               {
                                               ?>
                                                <table id="grayBox" style="padding: 15px; width: 330px; font-size:14px;">
                                                <tr>
                                                    <td style="text-align: center;">
                                                    <div class='colorLabel'>PAID</div>
                                                    </td>

                                                </tr>
                                                </table>
                                               <?php
                                               }
                                               else
                                               {
                                               ?>

                                                <table id="grayBox" style="padding: 15px; width: 330px; font-size:14px;">
                                                <tr>
                                                    <td style="text-align: center;">
                                                    <div class='colorLabel'>This item has been paid using <?php echo $usedMethod?>.</div>
                                                    </td>

                                                </tr>
                                                </table>
                                                <?php
                                               }
                                           }
                                           else
                                           {
                                               if($item['SellerID'] != $_SESSION['userID'])
                                               {
                                       ?>
                                                    <table id="grayBox" style="padding: 15px; width: 330px; font-size:14px;">
                                                        <tr>
                                                            <td style="text-align: center;" colspan="3">
                                                                <a href="<?php echo $PROJECT_PATH;?>paymentPage.php?ItemID=<?php echo $item['ItemID'];?>" style='text-decoration:none;'><img id="buttonImage" src="<?php echo $PROJECT_PATH;?>webImages/paynowbutton.png" alt="payNowButton"/></a>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="3"><br></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="3">or check out <a href='<?php echo $PROJECT_PATH;?>searchProductPage.php?searchSubmit=true&SellerID=<?php echo $item['SellerID'];?>'>other items listed by this seller</a></td>
                                                        </tr>
                                                    </table>
                                           <?php
                                                }
                                               else
                                               {
                                           ?>
                                                    <table id="grayBox" style="padding: 15px; width: 330px; font-size:14px;">
                                                    <tr>
                                                        <td style="text-align: center;">
                                                        <div class='colorLabel'>This item has not been paid.</div>
                                                        </td>

                                                    </tr>
                                                    </table>
                                            <?php
                                               }
                                           }
                                       }
                                       else
                                       {
                                       ?>
                                            <table id="grayBox" width="335px;">
                                               <tr>
                                                   <td class="bigLabel">Current Bid:</td>
                                                    <td></td>
                                                    <td>
                                                        <?php
                                                        if($item['startingBid'] == 0)
                                                        {
                                                            echo "N/A";
                                                        }
                                                        else
                                                        {
                                                        ?>
                                                            <label style="color:#506881; font-size: 18px; font-weight: bold; ">
                                                                $<?php
                                                                    setlocale(LC_MONETARY, 'en_AU');

                                                                    echo number_format($item['currentBid'],2);
                                                               ?>
                                                            </label>
                                                        <label style="font-size: 14px; ">  with <a href="<?php echo $PROJECT_PATH;?>viewBidListPage.php?ItemID=<?php echo $item['ItemID'];?><?php if(isset($_GET['view'])) {echo "&view=true";}?>"><?php echo $item['numberOfBid'];?> bids</a></label>
                                                        <?php
                                                        }
                                                        ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="bigLabel">Your Bid:</td>
                                                    <td></td>
                                                    <td>
                                                            <?php
                                                                if($item['startingBid'] != 0)
                                                                {
                                                                    echo "<label style='font-size: 14px;'>";
    //                                                                var_dump($bidList);
                                                                    //display the next possible bid by increase the current bid according to the set rules
                                                                    echo "(Enter AU $".number_format(($item['currentBid'] + getIncrement($item['currentBid'])),2)." or more)";

                                                                    echo "<input type='hidden' id='minBid' value='".($item['currentBid'] + getIncrement($item['currentBid']))."' />";
                                                                }
                                                                else
                                                                {
                                                                    echo "<label style='font-size: 16px;'>";
                                                                    echo "N/A";
                                                                }

                                                                echo "</label>";
                                                           ?>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="bigLabel">AU$</td>
                                                    <td></td>
                                                    <td>
                                                        <?php
                                                        if($item['startingBid'] == 0)
                                                        {
                                                            echo "<div style='width:213px;'> N/A</div>";
                                                        }
                                                        else
                                                        {
                                                        ?>

                                                            <input type="text" id="bidAmount" name="bidAmount" size="20" value="" />
                                                            <!input id="button" type="button" value="Bid It!" onclick="goToConfirmPurchase('bid',<?php echo $item['ItemID'];?>)" <?php if($item['SellerID'] == $_SESSION['userID'] OR isset($_GET['view'])) echo "disabled";?>  />
                                                            <img id="buttonImage" src="<?php echo $PROJECT_PATH;?>webImages/biditbutton.png" <?php $useragent = $_SERVER['HTTP_USER_AGENT'];
                                                                                                            if(preg_match('|Firefox/([0-9\.]+)|',$useragent,$matched))
                                                                                                            {
                                                                                                                echo "style='margin-bottom: -10px;'";
                                                                                                            }
                                                                                                            ?>
                                                                 alt="biditbutton" <?php if(!($item['SellerID'] == $_SESSION['userID'] OR isset($_GET['view']))) {?> onclick="goToConfirmPurchase('bid',<?php echo $item['ItemID'];?>)" <?php } ?> />
                                                        <?php
                                                        }
                                                        ?>
                                                    </td>
                                                </tr>
                                            </table>
                                        <?php
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                       <?php
                                       if(!isset($_GET['sold']) AND !hasBid($item['ItemID']))
                                       {
                                       ?>
                                        <table id="grayBox" width="335px;">
                                             <tr>
                                                <td class="bigLabel" style="width:103px;">Price:</td>
                                                <td></td>
                                                <td style="width:124px;">
                                                    <?php
                                                        if($item['Price'] == 0)
                                                        {
                                                            echo "<div style='width:213px;'> N/A</div>";
                                                            echo "</td>";
                                                            echo "<td></td>";
                                                        }
                                                        else
                                                        {
                                                    ?>
                                                    <label style="color:#ff0069; font-family: arial; font-weight:bold; font-size:18px;">AU$<?php echo number_format($item['Price'],2);?></label>
                                                </td>
                                                <td>
                                                    <img id="buttonImage" src="<?php echo $PROJECT_PATH;?>webImages/buynowbutton.png" alt="buynowbutton"  <?php if(!($item['SellerID'] == $_SESSION['userID'] OR isset($_GET['view']))) {?> onclick="goToConfirmPurchase('buy',<?php echo $item['ItemID'];?>)" <?php }?> />
                                                </td>
                                                <?php
                                                }
                                                ?>
                                             </tr>
                                        </table>
                                    <?php
                                       }
                                    ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <table width="350px" style="font-family:arial; font-size:11px; position: relative; left:2px; top: 0px;" >
                                            <tr>
                                                <td class="smallLabel">Time Remaining:</td>
                                                <td></td>
                                                <td>
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

                                                </td>
                                            </tr>
                                            <?php
                                            if(!isset($_GET['recent']))
                                            {
                                            ?>

                                            <tr>
                                                <td class="smallLabel">Quantity:</td>
                                                <td></td>
                                                <td><?php echo $item['Quantity'];?>
                                                </td>
                                            </tr>
                                            <?php
                                            }
                                            ?>
                                            <tr>
                                                <td class="smallLabel">Condition:</td>
                                                <td></td>
                                                <td><?php echo $item['ItemCondition'];?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="smallLabel">Postage:</td>
                                                <td></td>
                                                <td><?php echo $item['Postage'];?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="smallLabel">Payment Method:</td>
                                                <td></td>
                                                <td>
                                                 <?php
                                                    $methodString = "";
                                                    foreach($itemPayment as $method)
                                                    {
                                                        $methodString .= $method['MethodName'].", ";
                                                    }
                                                    $methodString = substr($methodString, 0, strlen($methodString) - 2);
                                                     echo $methodString;
                                                  ?>


                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="smallLabel"></td>
                                                <td></td>
                                                <td>
                                                </td>
                                            </tr>

                                        </table>
                                    </td>
                                </tr>
                            </table>

                            <div class="TabView" id="TabView">


                                <!-- ***** Tabs ************************************************************ -->

                                <div class="Tabs">
                                  <a class="Current">Detailed Information</a>
                                  <a>Comments</a>
                                  <a>
                                      <?php
                                      //display buyer / seller information depend on wherether the item has been sold of still selling
                                      if(isset($_GET['view']) AND $item['SellerID'] == $_SESSION['userID'] AND isset($_GET['sold']))
                                      {
                                            echo "Buyer Information";
                                      }
                                      else
                                      {
                                            echo "Seller Information";
                                      }

                                      ?>
                                  </a>
                                  <!--a>Item Video</a-->
                                </div>


                                <!-- ***** Pages *********************************************************** -->

                                <div class="Pages">
                                  <div class="Page" style="display: block;">
                                      <div class="Pad">

                                          <div id='itemDesc'>
                                          <?php
                                          //display the breaks by replacing /n with break tag for html format


                                          echo str_replace("\n", "<br/>", $item['Description']);
                                          ?>
                                          </div>


                                      </div>

                                  </div>

                                  <div class="Page" style="display:  none;">
                                      <div class="Pad">

                                          <?php
                                          if(isset($_SESSION['userID']))
                                          {
                                          ?>
                                          <form id="commentForm" action="insertItemComment.php" method="POST" target="">
                                              <input type="hidden" name="submitComment" value="true" />
                                              <input type="hidden" name="ItemID" value="<?php echo $item['ItemID']?>" />
                                              <input type="hidden" name="ItemName" value="<?php echo $item['ItemTitle']?>" />
                                              <input type="hidden" name="UserID" value="<?php echo $_SESSION['userID'] ?>" />
                                              <input type="text" id="comment" name="comment" value="Write your comment here" maxlength="100" size="50" onclick="this.value=''; this.style.color='black'" style="color: gray;"/>&nbsp;&nbsp;&nbsp;
                                              <img id="buttonImage" src="<?php echo $PROJECT_PATH;?>webImages/commentbutton.png" alt="CommentButton" onclick="submitComment()" style="margin-bottom: -10px;"/>
                                          </form>
                                          <?php
                                          }
                                          ?>

                                          <div id="commentBox" <?php if(!isset($_SESSION['userID'])) echo "style='height: 285px;'";?>>
                                          <?php

                                            include_once 'displayCommentList.inc.php';
                                            displayCommentList($item['ItemID']);


                                          ?>
                                          </div>

                                      </div>
                                  </div>

                                  <div class="Page" style="display:  none;">
                                      <div class="Pad">
                                      <?php
                                      //display buyer / seller information depend on wherether the item has been sold of still selling
                                      if(isset($_GET['view']) AND $item['SellerID'] == $_SESSION['userID'] AND isset($_GET['sold']))
                                      {
                                      ?>
                                          <b>Buyer: </b>
                                          <a href="<?php echo $PROJECT_PATH;?>user/<?php echo $buyer['UserName'];?>/"><?php echo $buyer['UserName'];?></a>
                                          <?php
                                            echo "  ( ".$buyer['feedbackPoint'];

                                            include_once '../account/showMemberIcon.inc.php';
                                            showIcon($buyer);

                                            echo " )";

                                          ?>
                                          <br>
                                        <div id="profileInfo" style="position:relative; top:10px;left:0px;">
                                            <div><label style="font-weight: bold; width: 150px;">Full Name: </label><label><?php echo $buyer['FirstName']." ".$buyer['LastName'];?></label></div>
                                            <div><label style="font-weight: bold; width: 150px; ">State: </label><label><?php if($buyer['State_CountryName'] != "") {echo $buyer['State_CountryName'];} else { echo "N/A";}?></label></div>
                                            <div><label style="font-weight: bold; width: 150px;">Member since: </label><label><?php echo date('d-M-Y',strtotime($buyer['registerDate']));?></label></div>
                                        </div>
                                        <?php
                                      }
                                      else
                                      {
                                      ?>
                                          <b>Seller: </b>
                                          <a href="<?php echo $PROJECT_PATH;?>user/<?php echo $item['UserName'];?>/"><?php echo $item['UserName'];?></a>
                                          <?php
                                            echo "  ( ".$item['feedbackPoint'];

                                            include_once '../account/showMemberIcon.inc.php';
                                            showIcon($item);

                                            echo " )";

                                          ?>
                                            <br>
                                            <div id="profileInfo" style="position:relative; top:10px;left:0px;">
                                                <div><label style="font-weight: bold; width: 150px;">Full Name: </label><label><?php echo $item['FirstName']." ".$item['LastName'];?></label></div>
                                                <div><label style="font-weight: bold; width: 150px; ">State: </label><label><?php if($item['State_CountryName'] != "") {echo $item['State_CountryName'];} else { echo "N/A";}?></label></div>
                                                <div><label style="font-weight: bold; width: 150px;">Member since: </label><label><?php echo date('d-M-Y',strtotime($item['registerDate']));?></label></div>
                                            </div>
                                      <?php
                                      }

                                      ?>

                                      </div>

                                  </div>
                                  <!--div class="Page" style="display:  none;">
                                      <div class="Pad">
//                                        <?php
//                                        if($item['VideoLink'] == "")
//                                        {
//                                            echo "<div id='bigHeading'>This item has no uploaded video</div>";
//                                        }
//                                        else
//                                        {
                                        ?>
                                            <OBJECT ID='MediaPlayer' width='370' height='250' CLASSID='CLSID:22D6F312-B0F6-11D0-94AB-0080C74C7E95'
                                            STANDBY='Loading Windows Media Player components...' TYPE='application/x-oleobject' style="float:right;">
                                            <PARAM NAME='FileName' VALUE='<?php echo $item['VideoLink'];?>'>
                                            <PARAM name='autostart' VALUE='false'>
                                            <PARAM name='ShowControls' VALUE='true'>
                                            <param name='ShowStatusBar' value='false'>
                                            <PARAM name='ShowDisplay' VALUE='true'>
                                            <embed  name='MediaPlayer' src='<?php echo $item['VideoLink'];?>' type='application/x-mplayer2'
                                                    width='370' height='250' ShowControls='1' ShowStatusBar='0' loop='false' EnableContextMenu='0' DisplaySize='0' Autostart='0'
                                                    pluginspage='http://www.microsoft.com/Windows/Downloads/Contents/Products/MediaPlayer/'>

                                            </OBJECT>
                                              <div id="bigHeading" style="float:left;">
                                                  Item Video
                                              </div>
                                        <?php
//                                        }
                                        ?>
                                      </div>
                                  </div-->


                                </div>

                                <script type="text/javascript">
                                    tabview_initialize('TabView', <?php if(isset($_GET['commentInserted'])) { echo '2';} else { echo "1";}?> );
                                </script>
                            </div>

                            <div id="toolBox">
                                <?php
                                //display gadget boxes if user login
                                if(isset($_SESSION['userID']))
                                {

                                    //insert the bid status if the item have bid option and the user is bidding on this item
//                                    if($item['startingBid'] != 0 AND isBiddingOnItem($item['ItemID'], $_SESSION['userID']))
//                                    {
                                        echo "<div id='bidStatusBox'>";

                                        if(isset($_GET['sold']))
                                        {

                                        }
                                        else if(isMaxBidder($item['ItemID'], $_SESSION['userID']))
                                        {
                                            echo "<img src='".$PROJECT_PATH."webImages/highestbidder.png' alt='highestBidderImage' id='highestBidder'/>";
                                        }
                                        else
                                        {
                                            echo "<img src='".$PROJECT_PATH."webImages/outbidded.png' alt='outBiddedImage'/>";
                                        }

                                        echo "</div>";
//                                    }

                                    //insert the rating bar
                                    if(!($item['SellerID'] == $_SESSION['userID']) AND !isset($_GET['sold']))
                                    {
                                        echo rating_bar($item['ItemID'],5);
                                    }


                                    //insert the tag box
                                    if(!isset($_GET['view']))
                                    {

                                        echo "<div id='tagBox' style='font-weight: bold; color: purple;'>Tag this item<br/>";


                                        if(!$tagged)
                                        {
                                            echo "<a href='".$PROJECT_PATH."tagItem.php?ItemID=".$item['ItemID']."&UserID=".$_SESSION['userID']."'>
                                                    <img src='".$PROJECT_PATH."webImages/tag_add.png' alt='TagImage' border='0'/>
                                                </a>";
                                        }
                                        else
                                        {
                                            echo "<img src='".$PROJECT_PATH."webImages/tag_complete.png' alt='TagImage' border='0'/>";
                                            echo "<div style='font-weight:normal; font-size:12px; font-style:italic; color:black'>This item is tagged.</div>";
                                        }
                                        echo "</div>";
                                    }

                                }
                              ?>
                                    <!insert the share item button>
                                    <div id="shareBox">
                                        <a id="ck_email" class="stbar chicklet" href="javascript:void(0);"><img src="http://w.sharethis.com/chicklets/email.gif" /></a>
                                        <a id="ck_facebook" class="stbar chicklet" href="javascript:void(0);"><img src="http://w.sharethis.com/chicklets/facebook.gif" /></a>
                                        <a id="ck_twitter" class="stbar chicklet" href="javascript:void(0);"><img src="http://w.sharethis.com/chicklets/twitter.gif" /></a>
                                        <a id="ck_sharethis" class="stbar chicklet" href="javascript:void(0);"><img src="http://w.sharethis.com/chicklets/sharethis.gif" /></a>
                                        <script type="text/javascript">
                                                var shared_object = SHARETHIS.addEntry({
                                                title: document.title,
                                                url: document.location.href
                                        });

                                        shared_object.attachButton(document.getElementById("ck_sharethis"));
                                        shared_object.attachChicklet("email", document.getElementById("ck_email"));
                                        shared_object.attachChicklet("facebook", document.getElementById("ck_facebook"));
                                        shared_object.attachChicklet("twitter", document.getElementById("ck_twitter"));
                                        </script>
                                    </div>
                                    <!--fb:like  layout="button_count" show_faces="false" font="arial"></fb:like-->

                                </div>
                            
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
