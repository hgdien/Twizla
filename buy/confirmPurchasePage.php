<?php
    session_start();
    include("../mySQL_connection.inc.php");
    include("../login.php");
    include('../loadHome.php');
    include ("getItemDetail.inc.php");

    //include the functions to get the bidIncrement
    include_once 'bidFunctions.inc.php';
    
//    //if the item have a bidding option
//    if($item['startingBid'] != 0)
//    {
//        $currentBid = getCurrentBid($item);
//
//    }


?>

<!--
    Document   : confirmPurchasePage.php
    Created on : Feb 8, 2010, 12:36:45 PM
    Author     : Peter
    Description:
        The main page.

    Updated: 8/2/2010
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
                        if(!isset($_SESSION['username']))
                        {
                        ?>
                            <div id="bigHeading">
                                You must login to buy this item.<br/>
                                Don't have a Twizla account? <br/>
                               <a href="<?php echo $SECURE_PATH?>registration/">Register</a> in 30 seconds and start listing and checking products.
                            </div>
                        <?php
                        }
                        else if(isset($_GET['confirm']))
                        {
                            echo "<div id='bigHeading'>Thank you for purchase this item.</div><br>";
                            echo "<a href='paymentPage.php?ItemID=".$item['ItemID']."' style='text-decoration:none;'>
                                <img id='buttonImage' src='".$PROJECT_PATH."webImages/paynowbutton.png' alt='PaynowButton' style='margin-bottom: -10px;'/></a> or check out <a href='searchProductPage.php?searchSubmit=true&SellerID=".$_GET['SellerID']."'>other items listed by this seller</a>";
                            echo "<br><br><br><br>";
                            echo "<div style='font-size: 12px; color: gray;'>&nbsp;&nbsp;If you have any questions, please <a href='".$PROJECT_PATH."user/".$item['UserName']."/contact'>send a message</a> to the seller for more information.</div>";
                        }
                        else if(isset($_GET['closeAuction']) OR $timeRemain <=0)
                        {
                            echo "<div id='bigHeading'>The auction for this item has finished.</div><br>";
                            echo "You can check out <a href='searchProductPage.php?searchSubmit=true&SellerID=".$_GET['SellerID']."'>other items listed by this seller</a>";
                        }
                        else if((count($item) == 0 OR $timeRemain < 0) AND !isset($_GET['view']))
                        {
                            echo "<label id='bigHeading'>This item is no longer available.<br/>You can check out
                                <a href='searchProductPage.php?searchSubmit=true&searchString=&searchCategory=".urlencode($item['CategoryName'])."'/>other products</a>
                                that belong to the same category.
                                </label>";
                        }
                        else
                        {
                    ?>
                            <label id="bigHeading">Review and Confirmation</label>
                            <label style="font-size:14px; position: relative; left: 325px;"><a href="<?php echo $PROJECT_PATH."listing/".$_GET['ItemID']."/".formatItemTitle($item['ItemTitle']);?>"> >> Back to Item Detail </a></label>
                            <br>
                                <?php
                                        include_once '../imageResize.inc.php';
                                        $imageSize = getimagesize($PROJECT_PATH.$pictureList[0]);
                                ?>
                                <div id="itemPicture" >
                                    <input type="hidden" id="picMode" value="small" />
                                    <img id="picture" src="<?php echo $PROJECT_PATH.$pictureList[0];?>" alt="<?php echo $pictureList[0]?>" <?php echo imageResize($imageSize[0],$imageSize[1],  200, 325);?>/>

                                </div>
                                <?php
                                if(isset($_GET['bidResult']))
                                {
                                    if($_GET['bidResult'] == 'outbidded')
                                    {
                                ?>
                                        <div id="bidResult">
                                            <img src="<?php echo $PROJECT_PATH?>webImages/outbiddedsticker.png" alt="outbiddedPicture" style="float:left;"/>
                                            <div style="width:230px; float: right;" >
                                            <label class="colorLabel">You've just been outbid. Do you want to bid again?</label><br>
                                            - Another bidder placed a higher maximum bid or placed the same maximum bid before you did. Learn more.<br>
                                            - Increase your maximum bid to have a chance to win this item.
                                            </div>
                                        </div>
                                <?php
                                    }
                                    else if($_GET['bidResult'] == 'winning')
                                    {
                                ?>
                                        <div id="bidResult">
                                            <img src="<?php echo $PROJECT_PATH?>webImages/highestbiddersticker.png" alt="winningPicture" style="float:left;"/>
                                            <div style="width:230px; float: right;">
                                            <label class="colorLabel">Congragulation, you are now the highest bidder.</label><br>
                                            - Twizla will send a email inform you if you are outbidded.<br>
                                            - Please re-check the auction right before the item finished for higher chance of winning.
                                            </div>
                                        </div>
                                <?php
                                    }
                                }
                                ?>

                                <form id="purchaseItemForm" action="processPurchaseItem.php" method="POST" style="position:relative; top:10px;">
                                <table style=" margin-top:10px;  font-size:14px;  ">
                                    <tr>
                                        <td><b>Item to <?php echo $_GET['type'];?>:</b></td>
                                        <td>&nbsp;&nbsp;&nbsp;</td>
                                        <td><?php echo $item['ItemTitle'];?></td>
                                    </tr>
                                    <tr>
                                        <td><b>Item Number: </b></td>
                                        <td>&nbsp;&nbsp;&nbsp;</td>
                                        <td><?php echo $item['ItemID'];?></td>
                                    </tr>

                                    <?php

                                    if($_GET['type'] == 'buy')
                                    {
                                    ?>
                                    <tr>
                                        <td><b>Buy Now Price: </b></td>
                                        <td>&nbsp;&nbsp;&nbsp;</td>
                                        <td>$<?php setlocale(LC_MONETARY, 'en_AU'); echo number_format($item['Price'],2);?></td>
                                    </tr>
                                     <tr>
                                        <td><b>Seller: </b></td>
                                        <td>&nbsp;&nbsp;&nbsp;</td>
                                        <td>
                                            <a href="<?php echo $PROJECT_PATH."user/".$item['UserName']."/";?>"><?php echo $item['UserName'];?></a>
                                              <?php
                                                echo "  ( ".$item['feedbackPoint'];

                                                include_once '../account/showMemberIcon.inc.php';
                                                showIcon($item);

                                                echo " )";
                                              ?>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td><b>Postage:</b></td>
                                        <td>&nbsp;&nbsp;&nbsp;</td>
                                        <td><?php echo $item['Postage'];?></td>
                                    </tr>
                                    <tr>
                                        <td><b>Payment:</b></td>
                                        <td>&nbsp;&nbsp;&nbsp;</td>
                                        <td></td>
                                    </tr>
                                    <?php
                                    }
                                    else
                                    {
                                    ?>
                                    <tr>
                                        <td><b>Current Bid:</b></td>
                                        <td>&nbsp;&nbsp;&nbsp;</td>
                                        <td>$<?php setlocale(LC_MONETARY, 'en_AU'); echo number_format($item['currentBid'], 2);?> <label style="font-size: 14px; ">  with <a href="viewBidListPage.php?ItemID=<?php echo $item['ItemID'];?>"><?php echo $item['numberOfBid'];?> bids</a></label>
                                    </tr>
                                    <?php
                                    if(isset($_GET['bidResult']))
                                    {
                                    ?>
                                        <tr>
                                            <td><b>Your Maximum bid:</b></td>
                                            <td>&nbsp;&nbsp;&nbsp;</td>
                                            <td>
                                                AU $<?php
                                                    if(isset($_GET['bidAmount']))
                                                    {
                                                        echo $_GET['bidAmount'];
                                                    }
                                                    else
                                                    {
                                                        echo getMaxBid($item['ItemID']);
                                                    }
                                                    ?>
                                            </td>
                                        </tr>

                                    <?php
                                    }
                                    ?>
                                    <tr>
                                        <td><b>Bid Amount: </b></td>
                                        <td>&nbsp;&nbsp;&nbsp;</td>
                                        <td>
                                            AU $<input type="text" name="bidAmount" size="10" value="<?php if(!isset($_GET['bidResult'])) {echo $_GET['bidAmount'];}?>"/>
                                            <label>(Enter AU $
                                                <?php
                                                if(isMaxBidder($item['ItemID'], $_SESSION['userID']))
                                                {
                                                    echo number_format(getMaxBid($item['ItemID']) + getIncrement(getMaxBid($item['ItemID']),2));
                                                }
                                                else
                                                {
                                                    echo number_format(($item['currentBid'] + getIncrement($item['currentBid'])),2);
                                                }
                                                    ?> or more)</label>
                                        </td>
                                    </tr>

                                    <?php
                                    }
                                    ?>
                                </table>
                            
                                <input type="hidden" name="purchaseSubmit" value="true"/>
                                <input type="hidden" name="userID" value="<?php echo $_SESSION['userID'];?>"/>
                                <input type="hidden" name="itemID" value="<?php echo $item['ItemID'];?>"/>
                                <input type="hidden" name="sellerID" value="<?php echo $item['SellerID'];?>"/>
                                <input type="hidden" id="purchaseType" name="purchaseType" value="<?php echo $_GET['type'];?>"/>
                                <input type="hidden" id="minBid" name="minBid" value="<?php
                                                if(isMaxBidder($item['ItemID'], $_SESSION['userID']))
                                                {
                                                    echo number_format(getMaxBid($item['ItemID']) + getIncrement(getMaxBid($item['ItemID']),2));
                                                }
                                                else
                                                {
                                                    echo number_format(($item['currentBid'] + getIncrement($item['currentBid'])),2);
                                                }
                                                ?>"/>
                                
                                <!input id="bigButton2" type="submit" style ="margin-top: 10px; margin-left: 50px; " value="<?php //if($_GET['type'] == 'buy'){ echo "Confirm Purchase";} else {echo 'Confirm to bid';};?>" />

                                <?php
                                if($_GET['type'] == 'buy')
                                    {
                                       ?>
                                <img id="buttonImage" src="<?php echo $PROJECT_PATH?>webImages/confirmpurchasebutton.png" alt="ConfirmPurchaseButton" style ="margin-top: 10px; margin-left: 50px; " onclick="document.getElementById('purchaseItemForm').submit()" />
                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <img id="buttonImage" src="<?php echo $PROJECT_PATH?>webImages/confirmbidbutton.png" alt="ConfirmBidButton" style ="margin-top: 10px; margin-left: 50px; " onclick="document.getElementById('purchaseItemForm').submit()" />
                                        <?php
                                    }
                                ?>
                            </form>
                            <br>
                            <div id="message" style="margin-left: 80px;"><?php if(isset($_GET['message'])) echo $_GET['message']; ?></div>
                            
                            <div id="helpContent" style="position: absolute; bottom:60px; width: 665px;">
                                <div class="colorLabel">Reminder</div>
                                <br>
                                • Check the seller's feedback score and make sure you have carefully reviewed the item description (including postage and payment).<br><br>

                                • Always ignore offers to trade off the Twizla website. Such transactions are not eligible for buyer protection. Find out more about <a target="_blank" href="<?php echo $PROJECT_PATH?>help/11/1380/">trading safely online</a>.
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
