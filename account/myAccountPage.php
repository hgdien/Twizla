<?php
    session_start();
    include("../mySQL_connection.inc.php");
//    Include php files for login, sign up function
    include("../login.php");

    include("../loadHome.php");

    //clear any warning left over from previous actions
    $warning ="";
    if(isset($_SESSION['username']))
    {

        if(!isset($_GET['page']) OR $_GET['page'] == "Buy" OR $_GET['page'] =='Sell')
        {
            //this file contains functions to get the item lists base on request type
            include_once 'getItemList.inc.php';
            //this file contains functions to display the item lists in gallery format
            //with pop up information
            include_once '../displayItemList.inc.php';
        }
        else if($_GET['page'] == "Mail")
        {
            include_once 'getMessageList.inc.php';
            include_once 'displayMessageList.inc.php';
            include_once 'displayMessageContent.inc.php';
        }
        else if($_GET['page'] == "Account")
        {
            include_once 'getAccountInfo.inc.php';
            include_once 'getMAList.inc.php';
            include_once '../displayItemList.inc.php';
        }


    }
?>

<!--
    Document   : myAccountPage.php
    Created on : Dec 22, 2009, 12:36:45 PM
    Author     : Peter
    Description:
        The main page.

    Updated: 23/1/2010
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

        <link rel="stylesheet" type="text/css" href="<?php echo $PROJECT_PATH;?>css/myAccount_firefox.css" />

        <!--[if gte IE 6]>
        <link rel="stylesheet" type="text/css" href="css/myAccount_ie.css" />
        <![endif]-->

    </head>
    <body>
        <?php
            include("../headSection.inc.php");
        ?>

            <div id="middleSection">

                <?php
                    if(!$_SESSION['username'])
                    {
//                         var_dump($_GET);
                ?>
                    <div id="bigHeading" style="margin: 10px;">
                        Please login to access your personal Twizla account.<br/>
                        Don't have a Twizla account? <a href="<?php echo $SECURE_PATH;?>registration/"><br/>
                        Register</a> in 30 seconds and start listing and checking products.
                    </div>
                <?php
                    include('../middleRightSection.inc.php');
                    }
                    else
                    {
                        //set up the left side control panel
                ?>
                        <label id="bigHeading" style="position: relative; left:35px; top:20px; font-weight: bold;">Account Summary</label>
                        <label id="bigHeading" style="position: relative; left:180px; top:20px; font-weight: bold;">
                            <?php
                                if(!isset($_GET['page']))
                                {
                                    echo "Buy";
                                }
                                else
                                {
                                    echo $_GET['page'];
                                }
                            ?>ing Options
                        </label>
                        <div id="sideBar">
                            <a href="<?php echo $PROJECT_PATH;?>account/"><img src="<?php echo $PROJECT_PATH;?>webImages/myaccountbuy.png" alt="buyMenuImage" border="0"/></a>
                            <a href="<?php echo $PROJECT_PATH;?>account/sell/"><img src="<?php echo $PROJECT_PATH;?>webImages/myaccountsell.png" alt="sellMenuImage" border="0"/></a>
                            <a href="<?php echo $SECURE_PATH;?>account/personalinfo/"><img src="<?php echo $PROJECT_PATH;?>webImages/myaccountaccount.png" alt="myAccountMenuImage" border="0"/></a>
                            <a href="<?php echo $PROJECT_PATH;?>account/mail/"><img src="<?php echo $PROJECT_PATH;?>webImages/myaccountmail.png" alt="messageMenuImage" border="0"/></a>
                        </div>

                    <?php
                        if(!isset($_GET['page']) OR $_GET['page'] == "Buy")
                        {
                    ?>

                            <div class="MyAccountTabView" id="TabView">
                            <!-- ***** Tabs ************************************************************ -->

                            <div class="Tabs" style="width: 681px;">
                              <a class="Current">Tag List</a>
                              <a>Bidding</a>
                              <a>Won</a>
                              <a>Didn't Win</a>
                              <a>Delete</a>
                            </div>


                            <!-- ***** Pages *********************************************************** -->

                            <div class="Pages" style="width: 780px; height: 610px;">
                              <div class="Page" style="display: block;">
                                  <div class="Pad">
                                      <div id="itemListBox">
                                        <?php

                                            $link = "myAccountPage.php?page=Buy&tab=1";
                                            displayItemList($tagList,15,"",'tagList','myAccountItemContainer',true,$link, "moveToDelete");
                                            //get the string ItemList
                                            if(count($tagList) >0)
                                            {
                                                foreach($tagList as $item)
                                                {
                                                    $ItemIDList .= $item['ItemID']."|";
                                                }
                                            }
                                        ?>
                                      </div>
                                    <?php
                                        if(count($tagList) >0)
                                        {
                                    ?>
                                        <a id="deleteAllButton" href="<?php echo $PROJECT_PATH;?>account/deleteMyAccountItem.php?ItemIDList=<?php echo $ItemIDList;?>&UserID=<?php echo $_SESSION['userID'];?>&Type=tagList" ><img id="buttonImage" src="<?php echo $PROJECT_PATH;?>webImages/deleteallbutton.png" alt="DeleteAllAllButton"/></a>

                                    <?php
                                        }
                                    ?>
                                  </div>

                              </div>
                              <div class="Page" style="display:  none;">
                                  <div class="Pad">
                                      <div id="itemListBox">
                                        <?php
                                            $link = "myAccountPage.php?page=Buy&tab=2";
                                            displayItemList($bidList,15,"",'bidList','myAccountItemContainer',true,$link, "");
                                        ?>
                                      </div>
                                  </div>
                              </div>
                              <div class="Page" style="display:  none;">
                                  <div class="Pad">
                                    <div id="itemListBox">
                                        <?php
                                            $link = "myAccountPage.php?page=Buy&tab=3";
                                            $itemLink = "/view/sold";



                                            displayItemList($wonList,15,$itemLink,'wonList','myAccountItemContainer',false,$link, "");

                                        ?>
                                    </div>
                                  </div>
                              </div>
                              <div class="Page" style="display:  none;">
                                  <div class="Pad">
                                      <div id="itemListBox">
                                        <?php
                                            $link = "myAccountPage.php?page=Buy&tab=4";
                                            $itemLink = "/view";
                                            displayItemList($notWinList,15,$itemLink,'notWinList','myAccountItemContainer',false,$link, "moveToDelete");
                                            //get the string ItemList
                                            if(count($notWinList) >0)
                                            {
                                                foreach($notWinList as $item)
                                                {
                                                    $ItemIDList .= $item['ItemID']."|";
                                                }
                                            }

                                        ?>
                                    </div>
                                    <?php
                                        if(count($notWinList) >0)
                                        {
                                    ?>
                                        <a id="deleteAllButton" href="<?php echo $PROJECT_PATH;?>account/deleteMyAccountItem.php?ItemIDList=<?php echo $ItemIDList;?>&UserID=<?php echo $_SESSION['userID'];?>&Type=notWinList" ><img id="buttonImage" src="<?php echo $PROJECT_PATH;?>webImages/deleteallbutton.png" alt="DeleteAllButton"/></a>

                                    <?php
                                        }
                                    ?>
                                  </div>
                              </div>
                              <div class="Page" style="display:  none;">
                                    <div class="Pad">
                                        <div id="itemListBox">
                                        <?php
                                            $link = "myAccountPage.php?page=Buy&tab=5";
                                            displayItemList($buyDeleteList,15,"",'buyDeleteList','myAccountItemContainer',true,$link, "");
                                        ?>
                                        </div>
                                  </div>
                              </div>
                            </div>

                            <script type="text/javascript">
                                tabview_initialize('TabView',<?php if(!isset($_GET['tab'])){ echo "1";} else{ echo $_GET['tab'];} ?>);
                                //set the current tab accordingly

                            </script>
                        </div>
                    <?php
                        }
                        else if($_GET['page'] == "Sell")
                        {
                    ?>

                            <div class="MyAccountTabView" id="TabView">
                            <!-- ***** Tabs ************************************************************ -->

                            <div class="Tabs" style="width: 681px;">
                              <a class="Current">Selling</a>
                              <a>Sold</a>
                              <a>UnSold</a>

                            </div>


                            <!-- ***** Pages *********************************************************** -->

                            <div class="Pages" style="width: 780px; height: 610px;">
                              <div class="Page" style="display: block;">
                                  <div class="Pad">
                                      <div id="itemListBox">
                                        <?php
                                            $link = "myAccountPage.php?page=Sell&tab=1";
                                            displayItemList($sellList,15,"",'sellList','myAccountItemContainer',false,$link, "");
                                        ?>
                                      </div>
                                  </div>

                              </div>

                              <div class="Page" style="display: none;">
                                  <div class="Pad">
                                      <div id="itemListBox">
                                        <?php

                                            $link = "myAccountPage.php?page=Sell&tab=2";
                                            $itemLink = "/view/sold";
                                            displayItemList($soldList,15,$itemLink,'soldList','myAccountItemContainer',false,$link, "");
                                        ?>
                                      </div>
                                  </div>

                              </div>

                              <div class="Page" style="display:  none;">
                                  <div class="Pad">
                                    <div id="itemListBox">
                                        <?php
                                            //display the unsold list
                                            $link = "myAccountPage.php?page=Sell&tab=2";
                                            $itemLink = "listItemPage2.php?reList=yes&";
                                            displayItemList($unsoldList,15,$itemLink, 'unsoldList','myAccountItemContainer',false,$link,"unsoldDelete");

                                            //get the string ItemIDList
                                            if(count($unsoldList) >0)
                                            {
                                                foreach($unsoldList as $item)
                                                {
                                                    $ItemIDList .= $item['ItemID']."|";
                                                }
                                            }
                                        ?>
                                    </div>
                                    <?php
                                        if(count($unsoldList) >0)
                                        {
                                    ?>
                                        <!set up the delete all and re-list all buttons>
                                        <a id="reListAllButton" href="<?php echo $PROJECT_PATH;?>account/reListItemList.php?ItemIDList=<?php echo $ItemIDList;?>" style="text-decoration: none;"><img id="buttonImage" src="<?php echo $PROJECT_PATH;?>webImages/relistallbutton.png" alt="reListAllButton"/></a>
                                        <a id="deleteAllButton" href="<?php echo $PROJECT_PATH;?>account/removeItem.php?ItemIDList=<?php echo $ItemIDList;?>" style="text-decoration: none;"><img id="buttonImage" src="<?php echo $PROJECT_PATH;?>webImages/deleteallbutton.png" alt="DeleteAllButton"/></a>

                                    <?php
                                        }
                                    ?>
                                  </div>
                              </div>
                            </div>

                            <script type="text/javascript">
                                tabview_initialize('TabView',<?php if(!isset($_GET['tab'])){ echo "1";} else{ echo $_GET['tab'];} ?>);
                                //set the current tab accordingly

                            </script>
                        </div>
                <?php
                    }
                    elseif($_GET['page'] == "Account")
                    {
                ?>

                            <div class="MyAccountTabView" id="TabView">
                            <!-- ***** Tabs ************************************************************ -->

                            <div class="Tabs" style="width: 681px;">
                                <a class="Current" style="height: 33px; padding-top: 2px;" onclick="window.location = '<?php echo $SECURE_PATH;?>account/personalinfo/1/<?php if(isset($_GET['listing'])) echo "listing";?>';">Personal Information</a>
                                <!--a style="height: 33px; padding-top: 2px;">Site Preferences</a-->
                                <a onclick="window.location = '<?php echo $SECURE_PATH;?>account/personalinfo/2/';">Feed Back</a>
                                <a onclick="window.location = '<?php echo $SECURE_PATH;?>account/personalinfo/3/<?php if(isset($_GET['listing'])) echo "listing";?>';" style="height: 33px; padding-top: 2px;">Payment<br>Account</a>
                                <a onclick="window.location = '<?php echo $SECURE_PATH;?>account/personalinfo/4/';" style="height: 33px; padding-top: 2px;">Resolution<br>Centre</a>

                            <?php
                            //check the verify status of the user
                            //display the member verification tab only if user is not verified
                            if(!($userInfo['verifyStatus'] == 'yes'))
                            {

                            ?>

                                <a style="height: 33px; padding-top: 2px;" onclick="window.location = '<?php echo $SECURE_PATH;?>account/personalinfo/5/';">Member Verification</a>
                            <?php
                            }
                            ?>
                            </div>


                            <!-- ***** Pages *********************************************************** -->

                            <div class="Pages" style="width: 780px; height: 610px;">
                              <div class="Page" style="display: block;">
                                  <div class="Pad">
                                    <label class="warningWindow"><?php if(isset($_GET['warning'])) echo $_GET['warning'];?></label>
                                    <form id="personalDetailBox" action="updateAccountInfo.php" method="POST">
                                        <input type="hidden" id="userID" name="userID" value="<?php echo $userInfo['UserID'];?>"/>
                                        <input type="hidden" id="updatePassword" name="updatePassword" value=""/>
                                        <input type="hidden" id="listing" name="listing" value="<?php if(isset($_GET['listing'])) {echo "true";} else {echo "false";}?>"/>
                                        <input type="hidden" name="signUpSubmit" value="true"  />
                                        <table>
                                            <tr>

                                                <td class="label">First Name:</td>
                                                <td></td>
                                                <td><input type="text" class="inputtext" id="firstName" name="firstName" size="40" value="<?php echo $userInfo['FirstName'];?>" />
                                                </td>
                                            </tr>

                                            <tr>
                                                <td class="label">Last Name:</td>
                                                <td></td>
                                                <td><input type="text" class="inputtext" id="lastName" name="lastName" size="40" value="<?php echo $userInfo['LastName'];?>" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><br/></td>
                                            </tr>
                                            <tr>
                                                <td class="label">UserName:</td>
                                                <td></td>
                                                <td><input type="text" class="inputtext" id="username" name="username" size="40" maxlength="40" value="<?php echo $userInfo['UserName'];?>" disabled/>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="label">Your Email:</td>
                                                <td></td>
                                                <td><input type="text" class="inputtext" id="reg_email" name="reg_email" size="40" value="<?php echo $userInfo['Email'];?>" disabled/>
                                                </td>
                                            </tr>

                                            <tr style="border:1px solid;">
                                                <td class="label">Password:</td>
                                                <td></td>
                                                <td><!input type="password" class="inputpassword" id="reg_password" name="reg_password" size="40" value=""/>
                                                    <input type="button" value="Change password" onclick="displayChangePasswordForm();"/>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="label"></td>
                                                <td></td>
                                                <td>
                                                    <div id="changePasswordForm" style="border:1px solid; border-color: #c4c4c4; padding: 5px; display:none;">
                                                        <table>
                                                            <tr>
                                                                <td class="label">Curernt Password:</td>
                                                                <td></td>
                                                                <td><input type="password" class="inputtext" id="pw" name="oldPw" size="40" maxlength="40" value="<?php echo $_GET['pw'];?>" />
                                                                </td>
                                                            </tr>

                                                            <tr><td colspan="3"></td></tr>
                                                            <tr>
                                                                <td class="label">New Password:</td>
                                                                <td></td>
                                                                <td><input type="password" class="inputtext" id="newPw" name="newPw" size="40" maxlength="40" value="" />
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="label">Re-type new Password:</td>
                                                                <td></td>
                                                                <td><input type="password" class="inputtext" id="reTypePw" name="reTypePw" size="40" maxlength="40" value="" />
                                                                </td>
                                                            </tr>

                                                        </table>
                                                    </div>
                                                </td>
                                            </tr>
                                            <script type="text/javascript">
                                                var changePassword = document.getElementById("changePasswordForm");
                                                var updatePassword = document.getElementById("updatePassword");
                                                var display = <?php echo $_GET['updatePassword'];?>;
                                                if(display == 1)
                                                {
                                                    changePassword.style.display = "";
                                                    updatePassword.value = "true";
                                                }
                                                else
                                                {
                                                    changePassword.style.display = "none";
                                                    updatePassword.value = "";
                                                }


                                            </script>
                                            <tr>
                                                <td class="label">Address:</td>
                                                <td></td>
                                                <td><input type="text" class="inputtext" id="addressLine1" name="addressLine1" size="40" value="<?php echo $userInfo['AddressLine1'];?>"/>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="label"></td>
                                                <td></td>
                                                <td><input type="text" class="inputtext" id="addressLine2" name="addressLine2" size="40" value="<?php echo $userInfo['AddressLine2'];?>"/>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="label">Town / City:</td>
                                                <td></td>
                                                <td>
                                                    <input type="text" class="inputtext" id="suburb" name="suburb" size="40" value="<?php echo $userInfo['Suburb_City'];?>"/>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="label">State:</td>
                                                <td></td>
                                                <td>
                                                    <select id="stateSelectBox" name="state" onchange="setSuburbList(this.options[this.selectedIndex].value)">

                                                        <?php

                                                            foreach($stateList as $location)
                                                            {
                                                                echo "<option>".$location['State_CountryName']."</option>";
                                                            }
                                                        ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <?php
                                                if($userInfo['State_Country'] != null)
                                                {

                                            ?>
                                                    <input type='hidden' id='existState' value='<?php echo $userInfo['stateName'];?>'/>
                                                    <script type="text/javascript">
                                                        var stateSelectBox = document.getElementById("stateSelectBox");

                                                        var existState = document.getElementById("existState");


                                                        for( i = 0;i < stateSelectBox.length ; i++)
                                                        {
                                                            if(stateSelectBox.options[i].value==existState.value)
                                                            {
                                                                stateSelectBox.selectedIndex = i;

                                                            }
                                                        }

                                                    </script>
                                            <?php
                                                }
                                            ?>
                                            <tr>
                                                <td class="label">Postcode:</td>
                                                <td></td>
                                                <td><input type="text" class="inputtext" id="postcode" name="postcode" size="10" maxlength="4" value="<?php echo $userInfo['Postcode'];?>"/>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="label">Contact Number:</td>
                                                <td></td>
                                                <td><input type="text" class="inputtext" id="contactNumber" name="contactNumber" size="10" maxlength="10" value="<?php echo $userInfo['ContactNumber'];?>"/>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="label">Auto-Relist Unsold Item:</td>
                                                <td></td>
                                                <td><input type="checkbox" name="autoReList" <?php if($userInfo['autoRelist']) echo "checked";?>/>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td>
                                                    <!input id="button2" name="signUpSubmit" type="submit" value="Save"/>
                                                    <img id="buttonImage" src="<?php echo $PROJECT_PATH;?>webImages/savebutton.png" alt="SaveButton" onclick="document.getElementById('personalDetailBox').submit()"/>
                                                </td>
                                            </tr>
                                        </table>
                                    </form>

                                      <?php
                                        if(isset($_GET['listing']))
                                        {
                                            echo "<a href='".$PROJECT_PATH."/sell/listItem/' style='position: absolute; bottom: 50px; left: 20px; font-size: 12px;'>>> Back to Item Listing Page</a>";
                                        }
                                      ?>
                                  </div>
                              </div>
                              <!--div class="Page" style="display:  none;">
                                  <div class="Pad">
                                    <div id="itemListBox">
                                        <!Site Preference page>
                                    </div>
                                  </div>
                              </div-->


                              <div class="Page"  style="display:  none;">
                                  <div class="Pad">
                                    <!Feed back page>
                                    <label id="feedbackWarningWindow" class="warningWindow"><?php if(isset($_GET['resolveWarning'])) echo $_GET['resolveWarning'];?></label>
                                    <div id="feedbackListBox">
                                        <?php
                                        if(isset($_GET['feedBackItemID']))
                                        {
                                        ?>
                                            <div id='bigHeading'><?php echo $currentFeedBackItem['ItemTitle'];?></div>
                                            <img src="<?php echo $PROJECT_PATH.$currentFeedBackItem['PictureLink'];?>" alt='itemPicture' width='140' height='140' style='margin:5px;'/><br/><br/>
                                            <div>How satisfied you are with this sale:</div>
                                            <br/>
                                            <!border-style: solid; border-width:1px;>
                                            <form id="feedbackForm" style='height:60px; ' action='submitFeedBack.php' method='POST'>
                                                <input type="hidden" name="submitFeedBack" value ="true"/>
                                                <input type="hidden" name="feedbackID" value="<?php echo $currentFeedBackItem['FeedbackID'];?>"/>
                                                <input type="hidden" name ="feedbackType" value="<?php echo $_GET['feedbackType']?>"/>
                                                <input type="hidden" name="dealingUser" value="<?php echo $_GET['dealingUser']?>"/>
                                                <input type='radio' name='rating' value="1" checked /> <img src="<?php echo $PROJECT_PATH;?>webImages/smileicon.png" alt="smileIcon" class="emotionIcon"/> Positive
                                                <input type='radio' name='rating' value="0" style="margin-left: 20px;"/> <img src="<?php echo $PROJECT_PATH;?>webImages/neutralicon.png" alt="neutralIcon" class="emotionIcon"/> Neutral
                                                <input type='radio' name='rating' value="-1" style="margin-left: 20px;"/> <img src="<?php echo $PROJECT_PATH;?>webImages/negativeicon.png" alt="negativeIcon" class="emotionIcon"/> Negative
                                                <!--input type='radio' name='rating' style="margin-left: 20px;" checked/> Leave feedback later-->
                                                <br/><br/>
                                                <label>Reason: </label><label id="charLeft" style="margin-left: 320px; font-size: 14px; color:blue;">(100 characters left)</label><br/>
                                                <input type="text" id="reasonInput" name="reason" size="100" maxlength="100" onKeyDown="checkChar(this)"
                                                      onKeyUp="checkChar(this)"/>
                                                <br/><br/>
                                                <!input id='button'  type='button' name='feedbackButton' value='Submit' style='margin-left:100px;' onclick="submitFeedback(this.form)" />
                                                <!input id='button' type='button' value='Close' style='margin-left:50px;' onclick="window.location='myAccountPage.php?page=Account&tab=2'"/>
                                               <img id='buttonImage' name='feedbackButton' src="<?php echo $PROJECT_PATH;?>webImages/submitbutton.png" alt="SubmitButton" style='margin-left:100px;' onclick="submitFeedback(document.getElementById('feedbackForm'))" />
                                                <img id='buttonImage' style='margin-left:50px;' src="<?php echo $PROJECT_PATH;?>webImages/closebutton.png" alt="CloseButton" onclick="window.location='<?php echo $SECURE_PATH;?>account/personalinfo/2/'"/>
                                            </form>
                                            <script type="text/javascript">

                                                function checkChar(inputField)
                                                {

                                                    var charLeftLabel = document.getElementById("charLeft");
                                                    var charLeft =  (100 - inputField.value.length);
                                                    charLeftLabel.innerHTML =charLeft + " characters left.";

                                                }
                                            </script>
                                        <?php
                                        }
                                        else
                                        {
                                        ?>

                                        <div id="feedbackLegend">
                                            <label style=" font-weight: bold;">Legend: </label>
                                            &nbsp&nbsp
                                            <img src='<?php echo $PROJECT_PATH;?>webImages/feedbackbuyer.png' alt='hasBuyerFeedbackIcon' style="margin-bottom: -10px;"> Buyer Feedback
                                            &nbsp&nbsp&nbsp&nbsp
                                            <img src='<?php echo $PROJECT_PATH;?>webImages/feedbackseller.png' alt='hasSellerFeedbackIcon' style="margin-bottom: -10px;"> Seller Feedback
                                            &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                                            <?php
                                            if(!$userInfo['imported'])
                                            {
                                            ?>
                                            <img src='<?php echo $PROJECT_PATH;?>webImages/importerarrow.png' alt='ImportEBayFeedbackIcon' style="margin-bottom: -20px; cursor: pointer;" onclick="window.location='importFeedback.php'"> Import your eBay Feedback Points
                                            <?php
                                            }
                                            ?>
                                        </div>
                                        <label class="colorLabel">Items Awaiting Feedback: </label><label style='font-size:14px;'><?php if(count($waitFeedBackList) >  0){echo "(".count($waitFeedBackList)." item(s) )";}?></label>

                                        <div style="margin-left: -3px; margin-top: 5px; margin-bottom: 10px; width:710px; height:230px; overflow:auto; border: 1px solid; border-color: #c4c4c4; ">
                                        <?php
                                            if(count($waitFeedBackList) >  0)
                                            {
//                                                //code for testing multi feedback
//                                                for($count = 0; $count < 15; $count++)
//                                                {
//                                                    $waitFeedBackList[] =$waitFeedBackList[0];
//                                                }
//                                                //code for testing multi feedback

//                                                echo "<div style=''>";
                                                echo "<table width='680'>";

                                                //display the headings
                                                echo "<tr id='waitingFeedbackHeading'>";
                                                    echo "<td>Item Title</td>";
                                                    echo "<td>Deal Party</td>";
                                                    echo "<td>Transaction Date</td>";
                                                    echo "<td>Leave Feedback</td>";
                                                echo"</tr>";

                                                foreach ($waitFeedBackList as $item)
                                                {
//                                                    var_dump($waitFeedBackList);

                                                    echo "<tr style='height:60px;'>";
//
                                                    echo "<td><div style='width:220px; font-size:14px;'><a target='_blank' href='".$PROJECT_PATH."listing/".$item['ItemID']."/".formatItemTitle($item['ItemTitle'])."/view' >";
                                                    if(strlen($item['ItemTitle']) > 30)
                                                    {
                                                        echo substr($item['ItemTitle'], 0, 26)."...";
                                                    }
                                                    else
                                                    {
                                                        echo $item['ItemTitle'];
                                                    }
                                                    echo "</a></div>";


                                                    //display the status of the feedback (wherether it has buyer feedback and seller feeback or not)
                                                    echo "<div style='float:left; font-size: 14px; margin-top:8px;'>Status:&nbsp&nbsp</div>";
                                                    echo "<div style='margin-top:5px;'>";

                                                    if($item['buyerRating'] != null)
                                                    {
                                                        echo "<img src='<?php echo $PROJECT_PATH;?>webImages/feedbackbuyer.png' alt='hasBuyerFeedbackIcon'>";
                                                    }
                                                    else
                                                    {
                                                        echo "<img src='<?php echo $PROJECT_PATH;?>webImages/feedbackbuyergrey.png' alt='noBuyerFeedbackIcon'>";
                                                    }
                                                    echo "&nbsp&nbsp&nbsp&nbsp";
                                                    if($item['sellerRating'] != null)
                                                    {
                                                        echo "<img src='<?php echo $PROJECT_PATH;?>webImages/feedbackseller.png' alt='hasSellerFeedbackIcon'>";
                                                    }
                                                    else
                                                    {
                                                        echo "<img src='<?php echo $PROJECT_PATH;?>webImages/feedbacksellergrey.png' alt='noSellerFeedbackIcon'>";
                                                    }
                                                    echo "</div>";
                                                    echo "</td>";

                                                    echo "<td><div style='width:140px; font-size:14px; text-align: center'><a href='".$PROJECT_PATH."user/".$item['UserName']."/' style='text-decoration:none;'>";
                                                    if($item['SellerID'] == $_SESSION['userID'])
                                                    {
                                                        //the current user is a seller for this item, display the username get from DB as a buyer
                                                        echo "Buyer: ";
                                                    }
                                                    else
                                                    {
                                                        //the current user is a buyer for this item, display the username get from DB as a seller
                                                        echo "Seller: ";
                                                    }

                                                    echo $item['UserName']." (".$item['feedbackPoint'];

                                                    include_once 'showMemberIcon.inc.php';
                                                    showIcon($item);

                                                    echo " )</a></div></td>";

                                                    echo "<td><div style='width:170px; font-size:14px; text-align: center;'>".date('d-M-Y h:i:s',strtotime($item['SaleTime']))."</div></td>";

                                                    echo "<td><div style='width:120px;' >";
                                                    if($item['SellerID'] == $_SESSION['userID'])
                                                    {
                                                        echo "<a href='".$SECURE_PATH."account/personalinfo/2/".$item['UserID']."/".$item['ItemID']."/seller/'>";
                                                    }
                                                    else
                                                    {
                                                        echo "<a href='".$SECURE_PATH."account/personalinfo/2/".$item['UserID']."/".$item['ItemID']."/buyer/'>";
                                                    }

                                                    echo "<img src='<?php echo $PROJECT_PATH;?>webImages/feedbackspeech.png' alt='feedbackicon' border='0' style='margin-left: 40px; '/></a></div></td>";
//
                                                    echo "</tr>";
                                                    echo "<tr><td colspan='4' bgcolor='#c4c4c4' width='0.5'></td></tr>";
                                                }

                                                echo "</table>";

                                            }
                                            else
                                            {
                                                echo "<div style='margin-left: 10px; margin-top: 10px;'>There is no item that awaiting feedback.</div>";
                                            }
                                            ?>
                                            </div>

                                        <label class="colorLabel">Recent Feedbacks:</label>

                                        <div style="margin-top: 5px; margin-bottom: 5px; width:722px; margin-left: -7px; height:222px; overflow:auto;">

                                        <?php
                                            if(count($recentFeedbackList) >  0)
                                            {
                                                //code for testing multi feedback
//                                                for($count = 0; $count < 15; $count++)
//                                                {
//                                                    $recentFeedbackList[] =$recentFeedbackList[0];
//                                                }
                                                //code for testing multi feedback

                                                //include the function to display the feedbackList
                                                include_once 'displayFeedbackList.inc.php';
                                                displayFeedbackList($recentFeedbackList, $userInfo);

                                            }
                                            else
                                            {
                                                echo "<div style='margin-left: 10px; margin-top: 10px;'>There is no recent feedback.</div>";
                                            }
                                            ?>
                                            </div>

                                        <?php
                                        }
                                        ?>
                                    </div>
                                  </div>
                              </div>

                              <div class="Page" style="display:  none;">
                                  <div class="Pad">
                                      <!Payment page>
                                    <label class="warningWindow"><?php if(isset($_GET['warning'])) echo $_GET['warning'];?></label>
                                    <div id="feedbackListBox">

                                        <form method="POST" action="updatePaymentOption.php" id="updatePaymentForm">
                                            <input type="hidden" name="submitUpdatePayment" value="true" />
                                            <input type="hidden" id="listing" name="listing" value="<?php if(isset($_GET['listing'])) {echo "true";} else {echo "false";}?>"/>
                                            <input type="hidden" name="userID" value="<?php echo $_SESSION[userID];?>" />
                                            <div class="colorLabel">Paypal</div>
                                            <br>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label class="label">Paypal Email: </label>
                                            <input type="text" name="paypalEmail" size="20" class="inputtext" value="<?php echo $userInfo['PaypalEmail']; ?>" />
                                            <br>
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <label class="smallComment">Don't have a Paypal Account? Visit <a target="blank" href="http://www.paypal.com.au/au">Paypal site</a> to create a new account</label>
                                            <br><br>
                                            <!Leave Paymate method for later>
                                            <!--div class="colorLabel">Paymate</div>
                                            <br>
                                            &nbsp;&nbsp;&nbsp;<label class="label">Paymate Email:</label>&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="paymateEmail" size="40" value="<?php //echo $userInfo['PaymateEmail']; ?>"/>
                                            <br><br-->
                                            <div class="colorLabel">Bank Detail</div>
                                            <br>
                                            <table>
                                                <tr>
                                                    <td class="label">Account Holder:</td>
                                                    <td></td>
                                                    <td><input type="text" class="inputtext" id="accountHolder" name="accountHolder" size="40" maxlength="20" value="<?php echo $userInfo['AccountHolder']; ?>" />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="label"></td>
                                                    <td></td>
                                                    <td><div class="smallComment">Australian bank accounts only</div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="label">Bank Name:</td>
                                                    <td></td>
                                                    <td><input type="text" class="inputtext" id="bankName" name="bankName" size="40" maxlength="20" value="<?php echo $userInfo['BankName']; ?>" />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="label"></td>
                                                    <td></td>
                                                    <td><div class="smallComment">Australian bank accounts only</div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="label">BSB Number:</td>
                                                    <td></td>
                                                    <td><input type="text" class="inputtext" id="BSB1" name="BSB1" size="3" maxlength="3" style="width: 30px;" value="<?php echo $userInfo['BSB1'];?>" />
                                                    &nbsp;-&nbsp;<input type="text" class="inputtext" id="BSB2" name="BSB2" size="3" maxlength="3" style="width: 30px;" value="<?php echo $userInfo['BSB2']; ?>" />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="label"></td>
                                                    <td></td>
                                                    <td><div class="smallComment">Up to 3 digits each</div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="label">Account Number:</td>
                                                    <td></td>
                                                    <td><input type="text" class="inputtext" id="accountNo" name="accountNo" size="9" maxlength="9" value="<?php echo $userInfo['AccountNo']; ?>" />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="label"></td>
                                                    <td></td>
                                                    <td><div class="smallComment">Up to 9 digits</div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="label"></td>
                                                    <td></td>
                                                    <td>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="label"></td>
                                                    <td></td>
                                                    <td><img id="buttonImage" src="<?php echo $PROJECT_PATH;?>webImages/savebutton.png" alt="SaveButton" onclick="document.getElementById('updatePaymentForm').submit()"/>
                                                    </td>
                                                </tr>
                                            </table>

                                        </form>

                                      <?php
                                        if(isset($_GET['listing']))
                                        {
                                            echo "<a href='".$PROJECT_PATH."sell/listItem/' style='position: absolute; bottom: 50px; left: 20px; font-size: 12px;'>>> Back to Item Listing Page</a>";
                                        }
                                      ?>
                                    </div>
                                  </div>
                              </div>

                              <div class="Page" style="display:  none;">
                                  <div class="Pad">
                                      <!Resolution centre page>
                                    <label id="resolveWarningWindow" class="warningWindow"><?php if(isset($_GET['resolveWarning'])) echo $_GET['resolveWarning'];?></label>
                                    <div id="feedbackListBox">
                                        <div id="resolutionText">
                                            In this resolution centre, we can help you resolve any problem that can not be solved
                                            even after communication between members. <br><br>
                                            Please note that there is a 10 days waiting period from the
                                            transaction date before the problem can be reported.<br><br>
                                            Please select your situation:
                                        </div>
                                        <form id="resolveForm" action="submitResolveCase.php" method="POST">
                                            <input type="hidden" name="userID" value="<?php echo $_SESSION['userID'];?>"/>
                                            <input type="hidden" name="resolveSubmit" value="true"/>
                                            <table>
                                                <tr>
                                                    <td class="label" style="font-size:14px; font-weight: bold">I am a: </td>
                                                    <td></td>
                                                    <td><input type="radio" id="buyerRadio" name="type" value="Buyer" style="margin-left:20px" onclick="enableItemChooserButton()">Buyer
                                                    <input type="radio" id="sellerRadio" name="type" value="Seller" style="margin-left:20px" onclick="enableItemChooserButton()">Seller</td>
                                                </tr>
                                                <tr>
                                                    <td class="label" style="font-size:14px; font-weight: bold; width:200px;">Concerning Item Number:</td>
                                                    <td></td>
                                                    <td>
                                                        <input type="text" id="itemNumberInput" name="itemNumberInput" value="" size="22" style="margin-left:20px; font-size:14px;"/>
                                                        <input type="button" id="chooseItemButton" value="Choose an item" onclick="displayItemChooser()" disabled />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="label" style="font-size:14px; font-weight: bold">Describe the situation:</td>
                                                    <td></td>
                                                    <td><textarea rows="8" cols="55" name="caseDesc" id="caseText" style="margin-left:20px; font-family: arial; font-size: 14px;" onKeyDown="limitText(this.form.caseText,1000);"
                                                      onKeyUp="limitText(this.form.caseText,1000);"></textarea>
                                                    <label id="wordCount" style="font-size:12px; color:blue; font-style: italic; margin-left: 280px;">1000 characters left</label>
                                                    </td>

                                                </tr>
                                                   <script language="javascript" type="text/javascript">
                                                        //if editing the item, set the remaining number of characters.
                                                        var caseText = document.getElementById("caseText");

                                                        limitText(caseText,1000);

                                                    </script>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td>
                                                        <!input id="button2" name="resolveSubmit" type="button" value="Submit" onclick="submitResolveForm(this.form)" style="margin-left:19px;"/>
                                                        <img id="buttonImage" src="<?php echo $PROJECT_PATH;?>webImages/submitbutton.png" alt="SubmitButton" onclick="submitResolveForm(document.getElementById('resolveForm'))" style="margin-left:19px;"/>

                                                        <!input id="button" name="resolveSubmit" type="button" value="Clear" style="margin-left:50px;" onclick="clearResolveForm()"/>
                                                        <img id="buttonImage" src="<?php echo $PROJECT_PATH;?>webImages/clearbutton.png" alt="ClearButton" onclick="clearResolveForm()" style="margin-left:50px;"/>
                                                    </td>
                                                </tr>
                                            </table>
                                        </form>
                                        <div id="buyerItemChooser" class="chooseItemWindow">
                                            <div style="font-weight: bold;">
                                                Choose the item:
                                            </div>
                                            <br>
                                            <div id="chooseItemHeader">

                                                <label style="left:25px;">Item</label>
                                                <label style="left:227px;">Seller</label>
                                                <label style="left:260px;">Transaction Date</label>
                                                <label style="left:340px;">Notes</label>
                                            </div>
                                            <div style="margin-bottom: 10px; width:650px; height:300px; border: 1px solid #c4c4c4; overflow: auto;">
                                                <table style="font-size:12px;">

                                                    <?php
//                                                        for($count = 0; $count < 15; $count++)
//                                                        {
//                                                            $buyerItemList[] = $buyerItemList[0];
//                                                        }

                                                        if(count($buyerItemList))
                                                        {
                                                            foreach($buyerItemList as $item)
                                                            {
                                                                echo "<tr>";
                                                                $TEN_DAYS_TIMESTAMP = 10*24*60*60;

                                                                ?>
                                                                <td style='margin-right:10px;'>
                                                                    <input type='radio' name="id" id="radioBuyer" onclick="setCurrentItemID(<?php echo $item['ItemID'];?>,'buyer')" <?php if(time() < (strtotime($item['SaleTime']) + $TEN_DAYS_TIMESTAMP)) {echo "disabled";}?>>
                                                                </td>
                                                                <?php
                                                                echo "<td><div style='width:215px;'>";
                                                                echo "Item Number: ".$item['ItemID']."<br/>";
                                                                if(strlen($item['ItemTitle']) > 30)
                                                                {
                                                                    echo substr($item['ItemTitle'], 0, 26)."...<br/>";
                                                                }
                                                                else
                                                                {
                                                                    echo $item['ItemTitle']."<br/>";
                                                                }

                                                                echo "<a target='_blank' href='".$PROJECT_PATH."listing/".$item['ItemID']."/".formatItemTitle($item['ItemTitle'])."/view'>View the item </a>";
                                                                echo "</div></td>";
                                                                echo "<td><div style='width:100px; text-align:center;'>";
                                                                echo "<a target='_blank' href='".$PROJECT_PATH."user/".$item['UserName']."/'>";
                                                                if(strlen($item['UserName']) > 8)
                                                                {
                                                                    echo substr($item['UserName'], 0, 5)."...<br/>";
                                                                }
                                                                else
                                                                {
                                                                    echo $item['UserName']."<br/>";
                                                                }
                                                                echo "</a> (".$item['feedbackPoint'];

                                                                include_once 'showMemberIcon.inc.php';
                                                                showIcon($item);

                                                                echo " )";
                                                                echo "</div></td>";
                                                                echo "<td style='width:100px;'>".date('d-M-Y',strtotime($item['SaleTime']))."</td>";

                                                                if(time() < (strtotime($item['SaleTime']) + $TEN_DAYS_TIMESTAMP))
                                                                {
                                                                    echo "<td style='padding-left:50px;'>This item can be reported on ".date('d-M-Y',strtotime($item['SaleTime']) + $TEN_DAYS_TIMESTAMP)."</td>";
                                                                }
                                                                else
                                                                {
                                                                    echo "<td style='padding-left:120px;'>None.</td>";
                                                                }
                                                                echo "</tr>";
                                                                echo "<tr><td colspan='4'></td></tr>";
                                                            }
                                                        }
                                                        else
                                                        {
                                                            echo "There were no items buy during the last 30 days.";
                                                        }
                                                    ?>
                                                </table>
                                            </div>
                                            <input type="hidden" id="buyerCurrentItemID" value=""/>
                                            <!input id="button"  type="button" name="buyerSelectButton" value="Select" style="margin-left:200px;" onclick="selectItem('buyer')" disabled/>
                                            <img id="buttonImage" name="buyerSelectButton" style="margin-left:200px; display: none;" src="<?php echo $PROJECT_PATH;?>webImages/selectbutton.png" alt="SelectButton"  onclick="selectItem('buyer')"/>
                                            <!input id="button" type="button" value="Close" style="margin-left:50px;" onclick="closeItemChooser('buyer')"/>
                                            <img id="buttonImage" src="<?php echo $PROJECT_PATH;?>webImages/closebutton.png" alt="CloseButton" class="chooserCloseButton" onclick="closeItemChooser('buyer')"/>
                                        </div>

                                        <div id="sellerItemChooser" class="chooseItemWindow">
                                            <div style="font-weight: bold;">
                                                Choose the item:
                                            </div>
                                            <br>
                                            <div id="chooseItemHeader">

                                                <label style="left:25px;">Item</label>
                                                <label style="left:227px;">Buyer</label>
                                                <label style="left:260px;">Transaction Date</label>
                                                <label style="left:340px;">Notes</label>
                                            </div>
                                            <div style="margin-bottom: 10px; width:650px; height:300px; border: 1px solid #c4c4c4; overflow: auto;">
                                                <table style="font-size:12px;" >

                                                    <?php
//                                                        for($count = 0; $count < 15; $count++)
//                                                        {
//                                                            $sellerItemList[] = $sellerItemList[0];
//                                                        }

                                                        if(count($sellerItemList))
                                                        {
                                                            foreach($sellerItemList as $item)
                                                            {
                                                                echo "<tr>";
                                                                $TEN_DAYS_TIMESTAMP = 10*24*60*60;

                                                                ?>
                                                                <td style='margin-right:10px;'>
                                                                    <input type='radio' name="id" id="radioSeller" onclick="setCurrentItemID(<?php echo $item['ItemID'];?>,'seller');" <?php if(time() < (strtotime($item['SaleTime']) + $TEN_DAYS_TIMESTAMP)) {echo "disabled";}?>>
                                                                </td>
                                                                <?php
                                                                echo "<td><div style='width:215px;'>";
                                                                echo "Item Number: ".$item['ItemID']."<br/>";
                                                                if(strlen($item['ItemTitle']) > 30)
                                                                {
                                                                    echo substr($item['ItemTitle'], 0, 26)."...<br/>";
                                                                }
                                                                else
                                                                {
                                                                    echo $item['ItemTitle']."<br/>";
                                                                }

                                                                echo "<a target='_blank' href='".$PROJECT_PATH."listing/".$item['ItemID']."/".formatItemTitle($item['ItemTitle'])."/view'>View the item </a>";
                                                                echo "</div></td>";
                                                                echo "<td><div style='width:100px; text-align:center;'>";
                                                                echo "<a target='_blank' href='".$PROJECT_PATH."user/".$item['UserName']."/'>";
                                                                if(strlen($item['UserName']) > 8)
                                                                {
                                                                    echo substr($item['UserName'], 0, 5)."...<br/>";
                                                                }
                                                                else
                                                                {
                                                                    echo $item['UserName']."<br/>";
                                                                }
                                                                echo " (".$item['feedbackPoint'];

                                                                include_once 'showMemberIcon.inc.php';
                                                                showIcon($item);


                                                                echo " )</a>";
                                                                echo "</div></td>";
                                                                echo "<td style='width: 100px; text-align: center;'>".date('d-M-Y',strtotime($item['SaleTime']))."</td>";

                                                                if(time() < (strtotime($item['SaleTime']) + $TEN_DAYS_TIMESTAMP))
                                                                {
                                                                    echo "<td style='padding-left:50px;'>This item can be reported on ".date('d-M-Y',strtotime($item['SaleTime']) + $TEN_DAYS_TIMESTAMP)."</td>";
                                                                }
                                                                else
                                                                {
                                                                    echo "<td style='padding-left:120px;'>None.</td>";
                                                                }
                                                                echo "</tr>";
                                                                echo "<tr><td colspan='4'></td></tr>";
                                                            }
                                                        }
                                                        else
                                                        {
                                                            echo "There were no items sold during the last 30 days.";
                                                        }
                                                    ?>
                                                </table>
                                            </div>
                                            <input type="hidden" id="sellerCurrentItemID" value=""/>
                                            <!input id="button"  type="button" name="sellerSelectButton" value="Select" style="margin-left:200px;" onclick="selectItem('seller')" disabled/>
                                            <!input id="button" type="button" value="Close" style="margin-left:50px;" onclick="closeItemChooser('seller')"/>
                                            <img id="buttonImage" src="<?php echo $PROJECT_PATH;?>webImages/selectbutton.png" alt="SelectButton"  name="sellerSelectButton" style="margin-left:200px; display:none;" onclick="selectItem('seller')"/>
                                            <img id="buttonImage" src="<?php echo $PROJECT_PATH;?>webImages/closebutton.png" alt="CloseButton" class="chooserCloseButton" onclick="closeItemChooser('seller')"/>
                                        </div>

                                        <div id="resolveFooter">Have a different problem? <a href="<?php echo $PROJECT_PATH;?>help/">Contact us</a> for further information.</div>
                                    </div>
                                  </div>
                              </div>

                            <?php
                            //check the verify status of the user
                            //display the member verification tab only if user is not verified
                            if(!($userInfo['verifyStatus'] == 'yes'))
                            {
                            ?>

                              <div class="Page" style="display:  none;">
                                  <div class="Pad">
                                    <!Member verification page>
                                    <label class="warningWindow"><?php if(isset($_GET['warning'])) echo $_GET['warning'];?></label>
                                    <div id="itemListBox" style="font-size:14px;">
                                        <?php
                                        //check the verify status of the user
                                        //if user is waiting for verification response
                                        if($userInfo['verifyStatus'] == 'waiting')
                                        {
                                        ?>
                                            <img src="<?php echo $PROJECT_PATH;?>webImages/authenticationbanner.jpg" alt="authenticationbanner" style="position:relative; left: 5px; "/>
                                            <div id="resolutionText" style="width: 700px; text-align: justify; text-size:16px; margin-top: 20px;">
                                                Verification is processing...<br><br>
                                                Please be patient.<br><br>
                                                You will be notified of the verification result within the next 24 hours .<br><br>
                                                Kind regard,<br><br>
                                                <b>Twizla</b>
                                            </div>



                                        <?php
                                        }
                                        //if user haven't verified the status
                                        else
                                        {
                                        ?>
                                            <div id="resolutionText" style="width: 700px; text-align: justify;">
                                                By going through member verification, you can increase the trust of other sellers and buyers.<br>
                                                This will also allow Twizla to prevent frauds and solve other transactions problems that may occur in the future.<br>
                                                At Twizla, we prioritize member's security in return of their trust.<br>
                                                All member information shall be keep privated and protected by Twizla and will not be utilized for any purpose other than the ones mentioned above.<br><br>

                                                To verify your membership, please upload a copy of your <b>Driver Licence / Passport</b> using the form bellow:
                                                <br><br>
                                            </div>
                                            <div style="position:relative; top:80px;">
                                                <form id="verifyForm" style='' enctype="multipart/form-data" action='uploadMemberInfo.php' method='POST'>
                                                    <input type="hidden" name="verifySubmit" value ="true"/>
                                                    <input type="hidden" name="userID" value="<?php echo $_SESSION['userID'];?>"/>
                                                    <br/>
                                                    <label style="margin-right: 30px;">Identification document: </label>
                                                    <input type="file" id="verifyInput" name="uploadFile" size="40"/>
                                                    <br/><br/>
                                                    <!input id='button'  type='submit' name='verifyButton' value='Submit' style='margin-left:182px;' />
                                                    <img id='buttonImage'  name='verifyButton' src="<?php echo $PROJECT_PATH;?>webImages/submitbutton.png" alt="SubmitButton" onclick="document.getElementById('verifyForm').submit()" style='margin-left:182px;' />
                                                </form>
                                            </div>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                  </div>
                              </div>
                            <?php
                            }
                            ?>


                            </div>

                            <script type="text/javascript">
                                tabview_initialize('TabView',<?php if(!isset($_GET['tab'])){ echo "1";} else{ echo $_GET['tab'];} ?>);
                                //set the current tab accordingly

                            </script>
                        </div>

                <?php
                    }
                    else if($_GET['page'] == "Mail")
                    {


                ?>

                            <div class="MyAccountTabView" id="TabView">
                            <!-- ***** Tabs ************************************************************ -->

                            <div class="Tabs" style="width: 681px;">
                                <a class="Current" onclick="window.location = '<?php echo $PROJECT_PATH;?>account/mail/1/';">Inbox <?php if($_SESSION['$unreadAmountList'][0] > 0){echo " (".$_SESSION['$unreadAmountList'][0].")";}?></a>
                              <a onclick="window.location = '<?php echo $PROJECT_PATH;?>account/mail/2/';">Sent</a>
                              <a onclick="window.location = '<?php echo $PROJECT_PATH;?>account/mail/3/';">Flagged <?php if($_SESSION['$unreadAmountList'][2] > 0){echo " (".$_SESSION['$unreadAmountList'][2].")";}?></a>
                              <!--a>My Folders </a-->
                                  <?php
//
//                                    foreach($_SESSION['$folderList'] as $folder)
//                                    {
//                                        echo "<a>
//                                                <img src='webImages/folderclosed.gif' alt='FolderImage' border='0'/>  ".$folder['FolderName'];
//                                        if($_SESSION['$unreadAmountList'][2 + $count] >0)
//                                        {
//                                            echo " (".$_SESSION['$unreadAmountList'][2 + $count].")";
//
//                                        }
//                                        echo "</a></li>";
//                                    }
//                                ?>
                            </div>

                            <!-- ***** Pages *********************************************************** -->

                            <div class="Pages" style="width: 745px; height: 610px; word-wrap: break-word ; overflow:hidden;">
                              <div class="Page" style="display: block;">
                                <div class="Pad">
                                   <?php
                                    //either display the list of message or the message content based
                                    //on wherether a current message data is set
                                    if(isset($_SESSION['currentMessage']))
                                    {
                                        $message = $_SESSION['currentMessage'];
//                                        echo $message['Flagged'];
                                        displayMessageContent($message, 1, true);
                                    }
                                    elseif(count($inboxList) > 0)
                                    {
                                   ?>
                                    <div id="itemListBox">
                                        <form id="deleteMessageForm" action='deleteMessage.php' method='POST'>
                                            <input type='hidden' name='userID' value='<?php //echo $_SESSION['userID'];?>' />
                                            <input type='hidden' id="deleteAllMesg" name='deleteAll' value='' />
                                            <input type="hidden" id="tab" name="tab" value="1" />
                                            <div id="deleteMailButton"><img id="buttonImage" src="<?php echo $PROJECT_PATH;?>webImages/deletebutton.png" alt="DeleteButton" onclick="document.getElementById('deleteMessageForm').submit();"/></div>
                                            &nbsp;&nbsp;&nbsp;
                                            <div id="deleteAllMailButton"><img id="buttonImage" src="<?php echo $PROJECT_PATH;?>webImages/deleteallbutton.png" alt="DeleteAllButton" onclick="submitDeleteAllMesg(document.getElementById('deleteMessageForm'))"/></div>
                                            <label id="warningWindow" class="warningWindow"><?php if(isset($_GET['warning'])) echo $_GET['warning'];?></label>
                                            <!div style="border-style:solid; border-width: 1px; height: 520px;">
                                            <div id="header">
                                                <input type="checkbox" id="selectAll" name ="selectAll" value="checkAll" onclick="setAllCheckBox(this.form)"/>
                                                <label style="left:30px;">Flag</label>
                                                <label style="left:58px;">From</label>
                                                <label style="left:155px;">Subject</label>
                                                <label style="left:430px;">Date</label>
                                            </div>

                                            <?php
//                                                for($count = 0 ;$count < 135; $count++)
//                                                {
//                                                    $inboxList[] = $inboxList[0];
//                                                }
                                                displayMessageList($inboxList, 1, "");
                                            ?>

                                        </form>
                                    </div>
                                    <?php
                                    }
                                    else
                                    {

                                        echo "<div id='itemListBox'>You have no message.</div>";
                                    }
                                    ?>
                                </div>
                              </div>
                              <div class="Page" style="display:  none;">
                                  <div class="Pad">
                                   <?php
                                    //either display the list of message or the message content based
                                    //on wherether a current message data is set
                                    if(isset($_SESSION['currentMessage']))
                                    {
                                        $message = $_SESSION['currentMessage'];

                                        displayMessageContent($message, 2, false);
                                    }
                                    elseif(count($inboxList) > 0)
                                    {
                                   ?>
                                    <div id="itemListBox">
                                        <form id="deleteSentForm" action='deleteMessage.php' method='POST'>
                                            <input type='hidden' name='userID' value='<?php //echo $_SESSION['userID'];?>' />
                                            <input type='hidden' id="deleteAllMesg" name='deleteAll' value='' />
                                            <input type="hidden" id="tab" name="tab" value="2" />
                                            <div id="deleteMailButton"><img id="buttonImage" src="<?php echo $PROJECT_PATH;?>webImages/deletebutton.png" alt="DeleteButton" onclick="document.getElementById('deleteSentForm').submit();"/></div>
                                            &nbsp;&nbsp;&nbsp;
                                            <div id="deleteAllMailButton"><img id="buttonImage" src="<?php echo $PROJECT_PATH;?>webImages/deleteallbutton.png" alt="DeleteAllButton" onclick="submitDeleteAllMesg(document.getElementById('deleteSentForm'))"/></div>
                                            <label id="warningWindow" class="warningWindow"><?php if(isset($_GET['warning'])) echo $_GET['warning'];?></label>
                                            <!div style="border-style:solid; border-width: 1px; height: 520px;">
                                        <div id="header">
                                            <input type="checkbox" id="selectAll" name ="selectAll" value="checkAll" onclick="setAllCheckBox(this.form)"/>
                                                <label style="left:93px;">To</label>
                                                <label style="left:225px;">Subject</label>
                                                <label style="left:480px;">Date</label>
                                        </div>

                                        <?php
//                                                for($count = 0 ;$count < 135; $count++)
//                                                {
//                                                    $inboxList[] = $inboxList[0];
//                                                }
                                            displayMessageList($sentList, 2, "noUnread");
                                        ?>
                                        </form>
                                    </div>
                                    <?php
                                    }
                                    else
                                    {

                                        echo "<div id='itemListBox'>You have no message.</div>";
                                    }
                                    ?>
                                  </div>
                              </div>
                             <div class="Page" style="display:  none;">
                                  <div class="Pad">
                                   <?php
                                    //either display the list of message or the message content based
                                    //on wherether a current message data is set
                                    if(isset($_SESSION['currentMessage']))
                                    {
                                        $message = $_SESSION['currentMessage'];

                                        displayMessageContent($message, 1, true);
                                    }
                                    elseif(count($inboxList) > 0)
                                    {
                                   ?>
                                    <div id="itemListBox">
                                        <form action='deleteMessage.php' method='POST'>
                                            <div id="header" style="margin-top: -5px;">
                                                <input type="checkbox" id="selectAll" name ="selectAll" value="checkAll" onclick="setAllCheckBox(this.form)"/>
                                                <label style="left:30px;">Flag</label>
                                                <label style="left:60px;">To</label>
                                                <label style="left:175px;">Subject</label>
                                                <label style="left:440px;">Date</label>
                                            </div>
                                            <?php
//                                                for($count = 0 ;$count < 135; $count++)
//                                                {
//                                                    $inboxList[] = $inboxList[0];
//                                                }
                                                displayMessageList($flaggedList, 3, "");
                                            ?>
                                        </form>
                                    </div>
                                    <?php
                                    }
                                    else
                                    {

                                        echo "<div id='itemListBox'>You have no message.</div>";
                                    }
                                    ?>

                                </div>
                            </div>
                        </div>

                            <script type="text/javascript">
                                tabview_initialize('TabView',<?php if(!isset($_GET['tab'])){ echo "1";} else{ echo $_GET['tab'];} ?>);
                                //set the current tab accordingly

                            </script>
                        </div>

                <?php
                    }

                }
                ?>
            </div>

            <?php
                include("../footerSection.inc.php");
            ?>

    </body>
</html>
