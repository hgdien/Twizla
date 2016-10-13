<?php
    session_start();
    include("../mySQL_connection.inc.php");
    include("../login.php");

    include("../loadHome.php");

?>

<!--
    Document   : listItemPage2.php
    Created on : Jan 27, 2010, 12:36:45 PM
    Author     : Peter
    Description:
        The item listing page.

    Updated: 27/6/2010


-->
<?php

    include("../buy/getItemDetail.inc.php");

//     process the script only if the user is logged in
    if(isset($_SESSION['userID']))
    {
        $conn = dbConnect();

        $sql = "SELECT * FROM user, userpayment WHERE user.UserID = userpayment.UserID AND user.UserID = ".$_SESSION['userID'];
        $result = mysql_query($sql) or die(mysql_error());
        $currentUser = mysql_fetch_array($result);
//        if($currentUser['verifyStatus'] == "yes")
//        {
//            $userVerified = true;
//        }
//        else
//        {
//            $userVerified = false;
//        }


        $sql = "SELECT * FROM payment_method";
        $result = mysql_query($sql) or die(mysql_error());
        while($row = mysql_fetch_array($result))
        {
            $paymentList[] = $row;
        }

        mysql_close($conn);

        if(($currentUser['PaypalEmail'] == "" OR $currentUser['PaypalEmail'] == null) AND ($currentUser['AccountHolder'] == "" OR $currentUser['AccountHolder'] == null)
                AND ($currentUser['AddressLine1'] == "" OR $currentUser['AddressLine1'] == null AND ($currentUser['AddressLine2'] == "" OR $currentUser['AddressLine2'] == null)))
        {
           ?>
           <script type="text/javascript">
               window.location = 'warningPaymentPage.php';
               </script>
           <?php
        }

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
                                <form id="listItemForm" action="saveNewItem.php" method="POST">
                                    <input type="hidden" name="listItemSubmit" id="listItemSubmit" value="true"/>
                                    <input type="hidden" name="submitType" id="submitType" value=""/>
                                    <input type="hidden" name="editID" id="edit" value="<?php echo $_GET['ItemID'];?>"/>
                                    <input type="hidden" name="sellerID" id="sellerID" value="<?php echo $_SESSION['userID']?>"/>
                                    <input type="hidden" name="videoLink" id="videoLink" value=""/>
                                    <input type="hidden" id="itemCategoryID" name="itemCategoryID" value=""/>
                                    <input type="hidden" id="categoryType" name="categoryType" value=""/>
                                    <?php
                                        //insert 6 input hidden field here to submit maximum 6 item image link
                                        for($count = 1; $count < 7; $count++)
                                        {
                                            echo "<input type='hidden' id='pictureLink$count' name='pictureLink$count' value=''/>";
                                        }
                                    ?>

                                    <table id="listItemDetailTable">
                                        <tr>
                                            <td class="boldLabel">Item Title:</td>
                                        </tr>
                                        <tr>
                                            <td><input type="text" class="longInputText" id="itemTitle" name="itemTitle" size="40" maxlength="50" value="<?php echo $item['ItemTitle'];?>" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="boldLabel">Catchy Phrase:</td>
                                        </tr>
                                        <tr>
                                            <td><input type="text" class="longInputText" id="catchPhrase" name="catchPhrase" size="40" maxlength="50" value="<?php echo $item['CatchPhrase'];?>" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="boldLabel">Category: <input id="itemCategory" type="text" size="15"  disabled/></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div  style="word-wrap: break-word; width: 275px;">

                                                    <select id="categoryList" name="categoryList" onchange="getSubCategory()">
                                                        <option style="font-weight: bold; color:black;" disabled="disabled" selected="selected">Please choose a category</option>
                                                    <?php
                                                        foreach($categoryList as $category)
                                                        {
                                                            echo "<option value='".$category['CategoryName']."'>".$category['CategoryName']."</option>";
                                                        }
                                                    ?>
                                                    </select>

                                                    <div id="categorySelection">
                                                    </div>
                                                    <?php
                                                        //set a hidden field for category to apply javascript in the case of edit existing item
                                                        if(isset($_GET['ItemID']))
                                                        {

                                                    ?>

                                                            <script type="text/javascript">

                                                                var itemCategoryID = document.getElementById("itemCategoryID");
                                                                itemCategoryID.value = <?php echo $item['ItemCategoryID']?>;
                                                                var itemCategory = document.getElementById("itemCategory");
                                                                var categoryType = document.getElementById("categoryType");
                                                                var category = document.getElementById("categoryList");

                                                                for( i = 0;i < category.length ; i++)
                                                                {
                                                                    if(category.options[i].value== "<?php echo $itemCategory['CategoryName'];?>")
                                                                    {
                                                                        category.selectedIndex = i;

                                                                    }
                                                                }

                                                                <?php
                                                                if($item['CategoryType'] == 'sub')
                                                                {
                                                                ?>
                                                                    itemCategory.value = "<?php echo $itemCategory['subCategoryName']?>";
                                                                    categoryType.value = 'sub';
                                                                    getSubCategory();
                                                                    var subCategory = document.getElementById("subCategory");

                                                                    for( i = 0;i < subCategory.length ; i++)
                                                                    {
                                                                        if(covertHTMLToString(subCategory.options[i].innerHTML) == "<?php echo $itemCategory['subCategoryName'];?>")
                                                                        {
                                                                            subCategory.selectedIndex = i;
                                                                        }
                                                                    }
                                                                    getSubSubCategory();

                                                                <?php
                                                                }
                                                                else if($item['CategoryType'] == 'subSub')
                                                                {
                                                                ?>

                                                                    itemCategory.value = "<?php echo $itemCategory['subSubCategoryName']?>";
                                                                    categoryType.value = 'subSub';
                                                                    getSubCategory();

                                                                    var subCategory = document.getElementById("subCategory");

                                                                    for( i = 0;i < subCategory.length ; i++)
                                                                    {

                                                                        if(covertHTMLToString(subCategory.options[i].innerHTML) == "<?php echo $itemCategory['subCategoryName'];?>")
                                                                        {
                                                                            subCategory.selectedIndex = i;
                                                                        }
                                                                    }
//
                                                                    getSubSubCategory();
//
                                                                    var subSubCategory = document.getElementById("subSubCategory");

                                                                    for( i = 0;i < subSubCategory.length ; i++)
                                                                    {

                                                                        if(covertHTMLToString(subSubCategory.options[i].innerHTML) == "<?php echo $itemCategory['subSubCategoryName'];?>")
                                                                        {
                                                                            subSubCategory.selectedIndex = i;

                                                                        }
                                                                    }

                                                                    getSubSubSubCategory();

                                                                <?php
                                                                }
                                                                else if($item['CategoryType'] == 'subSubSub')
                                                                {
                                                                ?>
                                                                    itemCategory.value = "<?php echo $itemCategory['subSubSubCategoryName']?>";
                                                                    categoryType.value = 'subSubSub';

                                                                    getSubCategory();
                                                                    var subCategory = document.getElementById("subCategory");
                                                                    for( i = 0;i < subCategory.length ; i++)
                                                                    {
                                                                        if(covertHTMLToString(subCategory.options[i].innerHTML) == "<?php echo $itemCategory['subCategoryName'];?>")
                                                                        {
                                                                            subCategory.selectedIndex = i;

                                                                        }
                                                                    }
                                                                    getSubSubCategory();
                                                                    var subSubCategory = document.getElementById("subSubCategory");
                                                                    for( i = 0;i < subSubCategory.length ; i++)
                                                                    {

                                                                        if(covertHTMLToString(subSubCategory.options[i].innerHTML) == "<?php echo $itemCategory['subSubCategoryName'];?>")
                                                                        {

                                                                            subSubCategory.selectedIndex = i;

                                                                        }
                                                                    }

                                                                    getSubSubSubCategory();

                                                                    var subSubSubCategory = document.getElementById("subSubSubCategory");

                                                                    for( i = 0;i < subSubSubCategory.length ; i++)
                                                                    {
                                                                        if(covertHTMLToString(subSubSubCategory.options[i].innerHTML) == "<?php echo $itemCategory['subSubSubCategoryName'];?>")
                                                                        {

                                                                            subSubSubCategory.selectedIndex = i;

                                                                        }
                                                                    }
//
                                                                    setItemCategory(subSubSubCategory, 'subSubSub');
                                                                <?php
                                                                }
                                                                ?>
                                                            </script>
                                                    <?php
                                                        }
                                                   ?>

                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><label class="boldLabel">Description:</label> </td>
                                        </tr>
                                        <tr>
                                            <td><textarea rows="5" cols="32" id="itemDesc" name="itemDesc"  style="width: 275px;"><?php echo $item['Description']?></textarea>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td ></td>
                                        </tr>
                                            <!--onKeyDown="limitText(this.form.itemDesc,500);" onKeyUp="limitText(this.form.itemDesc,500);"
                                            <label id="wordCount" style="font-size:12px; color:blue; font-style: italic; margin-left: 170px;">500 characters left</label>
                                             script language="javascript" type="text/javascript">
                                                //if editing the item, set the remaining number of characters.
                                                var itemDesc = document.getElementById("itemDesc");
                                                limitText(itemDesc,500);

                                            </script-->
                                        <tr>
                                            <td>
                                                <table>
                                                    <tr>
                                                        <td class="boldLabel">Bid It! price</td>
                                                        <td></td>
                                                        <td class="boldLabel">Buy It! price</td>
                                                    </tr>
                                                    <tr>
                                                        <td><input type="text" class="inputText" id="bidPrice" name="bidPrice" size="14" value="<?php echo $item['currentBid'];?>" style="margin-top:0; width: 130px;" onchange="displayQuantity()"/></td>
                                                        <td></td>
                                                        <td><input type="text" class="inputText" id="buyPrice" name="buyPrice" size="14" value="<?php echo $item['Price'];?>" style="margin-top:0; width: 130px;" onchange="displayQuantity()"/></td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                               <table>
                                                    <tr>
                                                        <td class="boldLabel" style="margin-top:0;">Duration</td>
                                                        <td></td>
                                                        <td class="boldLabel"><label id="qtyLabel" <?php if(!(isset($_GET['ItemID'])  AND $item['startingBid'] == null)) echo "style='visibility: hidden;'" ?>>Quantity</label></td>
                                                    </tr>
                                                    <tr>
                                                        <td><select id="listDuration" name="listDuration" name="listDuration" style="width:135px;">
                                                                <option>3 days</option>
                                                                <option>5 days</option>
                                                                <option>7 days</option>
                                                                <option>10 days</option>
                                                                <option>30 days</option>
                                                        </select>
                                                           <?php
                                                                //set a hidden field for category to apply javascript in the case of edit existing item
                                                                if(isset($_GET['ItemID']))
                                                                {
                                                            ?>
                                                                    <input type='hidden' id='existDuration' value='<?php echo $item['listDuration']." days";?>'/>
                                                                    <script type="text/javascript">
                                                                        var duration = document.getElementById("listDuration");
                                                                        var exist = document.getElementById("existDuration");

                                                                        for( i = 0;i < duration.length ; i++)
                                                                        {
                                                                            if(duration.options[i].value==exist.value)
                                                                            {
                                                                                duration.selectedIndex = i;
                                                                            }
                                                                        }
                                                                    </script>
                                                            <?php
                                                                }
                                                           ?>
                                                        </td>
                                                        <td></td>
                                                        <td><input type="text" class="inputText" id="quantity" name="quantity" size="14" value="<?php     if(isset($_GET['ItemID'])) { echo $item['Quantity'];} else {echo "1";}?>"
                                                                   style="margin-top:0; width: 130px; <?php if(!(isset($_GET['ItemID'])  AND $item['startingBid'] == null)) echo "visibility: hidden;" ?>"/></td>
                                                    </tr>
                                                </table>

                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="boldLabel">Item Condition</td>
                                        </tr>
                                        <tr>
                                            <td><div  style="margin-top:0"><input type="text" class="longInputText" id="itemCondition" name="itemCondition" size="40" value="<?php echo $item['ItemCondition'];?>" /></div></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <table>
                                                    <tr>
                                                        <td class="boldLabel">Shipping Methods</td>
                                                        <td></td>
                                                        <td class="boldLabel" id="postagePriceLabel">AUD $</td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <select id="itemPostage" name="itemPostage" style="width:135px;" onchange="displayPostagePrice(this[this.selectedIndex].value)">
                                                                <option>Fixed Price</option>
                                                                <option >Free shipping</option>
                                                                <option>Self Pick Up</option>
                                                            </select>
                                                        </td>
                                                        <td></td>
                                                        <td><input type="text" class="inputtext" id="postagePrice" name="postagePrice" size="9" value="" style="margin-top:0; width: 125px;" /></td>
                                                    </tr>
                                                </table>
                                                 <?php
                                                //set a hidden field for category to apply javascript in the case of edit existing item
                                                if(isset($_GET['ItemID']))
                                                    {
                                                ?>
                                                    <input type='hidden' id='existPostage' value='<?php echo $item['Postage'];?>'/>
                                                        <script type="text/javascript">
                                                            var postage = document.getElementById("itemPostage");
                                                            var exist = document.getElementById("existPostage");

                                                            if(exist.value.substring(0,11) == "Fixed Price")
                                                            {
                                                                var postagePrice = document.getElementById("postagePrice");
                                                                postagePrice.value = exist.value.substring(17);
                                                            }
                                                            else
                                                            {
                                                                for(i=0;i<postage.length;i++)
                                                                {
                                                                    if(postage.options[i].value==exist.value)
                                                                    {
                                                                        postage.selectedIndex=i;

                                                                    }

                                                                }
                                                                displayPostagePrice(exist.value);
                                                            }
                                                        </script>

                                                <?php
                                                    }

                                               ?>
                                            </td>
                                        </tr>
                                    </table>
                                    <div style="position:absolute; top:320px; left: 350px; font-size: 14px; text-align: left;">
                                            <div class="boldLabel">Payment Methods</div>

                                            <?php

                                                foreach($paymentList as $method)
                                                {
                                                    echo "<input type ='checkbox' name='paymentMethod[]' value='".$method['MethodID']."' ";

                                                    if($method['MethodName'] == "PayPal")
                                                    {
                                                        if($currentUser['PaypalEmail'] == "" OR $currentUser['PaypalEmail'] == null)
                                                        echo "disabled";
                                                    }
                                                    else if($method['MethodName'] == "Paymate")
                                                    {
                                                        if($currentUser['PaymateEmail'] == "" OR $currentUser['PaymateEmail'] == null)
                                                        echo "disabled";
                                                    }
                                                    else if($method['MethodName'] == "Bank Deposit")
                                                    {
                                                        if($currentUser['AccountHolder'] == "" OR $currentUser['AccountHolder'] == null)
                                                        echo "disabled";
                                                    }
                                                    else if($currentUser['AddressLine1'] == "" OR $currentUser['AddressLine1'] == null AND ($currentUser['AddressLine2'] == "" OR $currentUser['AddressLine2'] == null))
                                                    {
                                                        echo "disabled";
                                                    }

                                                    if(isset($_GET['ItemID']))
                                                    {

                                                        $hasPayment = false;

                                                        foreach ($itemPayment as $existingPayment)
                                                        {
                                                            if($method['MethodID'] == $existingPayment['MethodID'])
                                                            {
                                                                $hasPayment = true;
                                                            }
                                                        }

                                                        if($hasPayment)
                                                        {
                                                            echo "checked";
                                                        }
                                                    }

                                                    echo " /> ".$method['MethodName']."<br/>";
                                                }


                                            ?>
                                            <div id="paymentMessage">
                                            want access to more payment options? Update your account <a href="<?php echo $SECURE_PATH;?>account/personalinfo/1/listing">postal address</a> and
                                            <a href="<?php echo $SECURE_PATH;?>account/personalinfo/3/listing">payment options</a>
                                            </div>
                                    </div>

                                </form>

                                <div id="uploadForm">
                                    <div class="boldLabel">Add Images</div>
                                    <form  id="uploadImageForm" name="uploadImageForm" style="margin-bottom: 0px; margin-top: 0px;" enctype="multipart/form-data" action="<?php echo $PROJECT_PATH;?>sell/uploadImages.php" method="POST">
                                        <input type="hidden" name="maxSize" value="99999999" />
                                        <input type="hidden" name="maxW" value="3000" />
                                        <input type="hidden" name="fullPath" value="<?php echo $PROJECT_PATH; ?>uploads/" />
                                        <input type="hidden" name="relPath" value="../uploads/" />
                                        <input type="hidden" name="colorR" value="255" />
                                        <input type="hidden" name="colorG" value="255" />
                                        <input type="hidden" name="colorB" value="255" />
                                        <input type="hidden" name="maxH" value="3000" />
                                        <input type="hidden" name="filename" value="filename" />
                                        <input type="hidden" id="uploadedList" name="uploadedList" value="" />
                                        <div id="uploadPictureBox">
                                            <div id="bigPictureBox">
                                            <?php
                                            if(isset($_GET['ItemID']) AND $pictureList[0] != "")
                                            {
                                                echo "<input type='hidden' id='imageLink' name='imageLink' value='$pictureList[0]'/>";
                                                include_once '../imageResize.inc.php';
                                                $imageSize = getimagesize($pictureList[0]);
                                                echo "<img id='picture' src='".$PROJECT_PATH."$pictureList[0]' alt='picture' ".imageResize($imageSize[0],$imageSize[1],  160, 275)."/>";
                                            }
                                            ?>
                                            </div>
                                             <!Set up the small picture panels, maximum 6 panels
                                                 if is editing the fill up panels with existing pictures >

                                            <ul id="smallListingPics">
                                                <?php
                                                    if(isset($_GET['ItemID']) AND $pictureList[0] != "")
                                                    {
                                                        $pictureNumber = 0;
                                                        foreach($pictureList as $picture)
                                                        {
                                                            $pictureNumber  ++;
                                                            $imageSize = getimagesize($picture);
//                                                            echo "";
                                                            echo "<li>
                                                                    <input type='hidden' id='resize_smallPic".$pictureNumber."' value='".imageResize($imageSize[0],$imageSize[1],  160, 275)."' />
                                                                    <img id='smallPic".$pictureNumber."' class='smallPic' src='".$PROJECT_PATH.$picture."' ".imageResize($imageSize[0],$imageSize[1],  44, 41)." alt='smallpic' onclick='setBigPicture(this)' onmousemove='displayMiniCross($pictureNumber)' onmouseout='hideMiniCross($pictureNumber)' />
                                                                    <img id='removePictureButton".$pictureNumber."' class='removePictureButton' src='".$PROJECT_PATH."webImages/miniMinus.png' onclick='removePicture($pictureNumber)'  onmousemove='displayMiniCross($pictureNumber)' />
                                                                    </li>";
                                                        }

                                                        //fill up the remaining panels with smallpicture background
                                                        for($count = (1 + $pictureNumber); $count < 7; $count++)
                                                        {
                                                            echo "<li><img id='smallPic".$count."' class='smallPic'  style='width: 41px; height: 44px;'  src='".$PROJECT_PATH."webImages/smallPicBG.jpg' alt=''/></li>";

                                                        }

                                                    }
                                                    else
                                                    {
                                                        for($count = 1; $count < 7; $count++)
                                                        {
                                                            ?>
                                                            <li><img id='smallPic<?php echo $count;?>' class='smallPic' src='<?php echo $PROJECT_PATH;?>webImages/smallPicBG.jpg' style='width: 41px; height: 44px;' alt='smallPic' /></li>
                                                            <?php
                                                        }
                                                    }
                                                ?>
                                            </ul>
                                        </div>

                                        <div id="addFileButton" onmouseover="cursor:pointer;">
                                            <input type="file" id="addImageButton" name="filename" size="1"  onchange="ajaxUploadImage(this.form,'image','<?php echo $PROJECT_PATH;?>sell/uploadImage.php?filename=name&amp;maxSize=999999999&amp;maxW=1000&amp;fullPath=<?php echo $PROJECT_PATH; ?>uploads/&amp;relPath=../uploads/&amp;colorR=255&amp;colorG=255&amp;colorB=255&amp;maxH=1000','uploadPictureBox','File Uploading Please Wait...&lt;br /&gt;&lt;img src=\'<?php echo $PROJECT_PATH;?>webImages/loader_light_blue.gif\' width=\'128\' height=\'15\' border=\'0\' /&gt;',''); return false;"/>
                                        </div>
                                        <br>



                                    </form>
                                    <!--div style="margin-top: 0;"class="boldLabel">Add Video</div>
                                    <form id="uploadVideoForm" name="uploadVideoForm" enctype="multipart/form-data" action="uploadVideo.php" method="POST">
                                        <input type="hidden" name="maxSize" value="99999999" />
                                        <input type="hidden" name="maxW" value="200" />
                                        <input type="hidden" name="fullPath" value="<?php //echo $PROJECT_PATH; ?>uploads/" />
                                        <input type="hidden" name="relPath" value="uploads/" />
                                        <input type="hidden" name="maxH" value="300" />
                                        <input type="hidden" name="filename" value="filename" />


                                        <div id="bigVideoBox">
                                            <?php
    //                                        if(isset($_GET['ItemID']))
    //                                        {
    //                                            if($item['VideoLink'] != "")
    //                                            {
    //                                                echo "<input type='hidden' id='uploadedVideo' value='".$item['VideoLink']."'/>";
    //                                                echo "<OBJECT ID='MediaPlayer' width='275' height='160' CLASSID='CLSID:22D6F312-B0F6-11D0-94AB-0080C74C7E95'
    //                                                    STANDBY='Loading Windows Media Player components...' TYPE='application/x-oleobject'>
    //                                                    <PARAM NAME='FileName' VALUE='".$item['VideoLink']."'>
    //                                                    <PARAM name='autostart' VALUE='false'>
    //                                                    <PARAM name='ShowControls' VALUE='true'>
    //                                                    <param name='ShowStatusBar' value='false'>
    //                                                    <PARAM name='ShowDisplay' VALUE='true'>
    //                                                    <embed  name='MediaPlayer' src='".$item['VideoLink']."' type='application/x-mplayer2'
    //                                                            width='275' height='160' ShowControls='1' ShowStatusBar='0' loop='false' EnableContextMenu='0' DisplaySize='0' Autostart='0'
    //                                                            pluginspage='http://www.microsoft.com/Windows/Downloads/Contents/Products/MediaPlayer/'>";
    //                                            }
    //                                        }
                                            ?>
                                        </div>

                                        <div id="addFileButton" style="position:absolute; top:52%;"onmouseover="cursor:pointer;">
                                            <input type="file" name="filename" size="1"  onchange="ajaxUpload(this.form,'video','uploadVideo.php?filename=name&amp;maxSize=999999999&amp;maxW=200&amp;fullPath=<?php echo $PROJECT_PATH; ?>uploads/&amp;relPath=uploads/&amp;maxH=300','bigVideoBox','File Uploading Please Wait...&lt;br /&gt;&lt;img src=\'webImages/loader_light_blue.gif\' width=\'128\' height=\'15\' border=\'0\' /&gt;',''); return false;"/>
                                        </div>
                                    </form>
                                        <!Set up the remove video button>
                                        <div id="removeVideoButton" name="removeVideoButton" onclick="removeVideo()"></div-->

                                    <!--div id="addFileButton" style="position:absolute; top:52%;"onmouseover="cursor:pointer;">
                                            <input type="file" name="filename" size="1"  onchange="return ajaxUploadVideo(this.value)"/>
                                    </div-->
                             <?php
                                //if is relisting, display the relist button
                                if(isset($_GET['reList']))
                                {
                             ?>
                                <div style="position:absolute; left:19%; top:513px;"><img id="buttonImage" name="reListButton" src="<?php echo $PROJECT_PATH;?>webImages/relistitembutton.png" alt="ReListButton" onclick="submitItemListForm('reList')" style="width:140px; height: 30px;"/></div>

                                <div style="position:absolute; left:88%; top:513px;"><a href="<?php echo $PROJECT_PATH;?>account/sell/2/" ><img src="<?php echo $PROJECT_PATH;?>webImages/cross.png" alt="cross" border="0"/></a></div>
                            <?php
                                }
                                else
                                {
                            ?>
                                    <!Set up 2 save button>
                                    <div style="position:absolute; left:-25px; top:513px;"><img id="buttonImage" name="saveItemButton" src="<?php echo $PROJECT_PATH;?>webImages/saveitembutton.png" alt="SaveItemButton" onclick="submitItemListForm('saveItem')"/></div>
                                    <div style="position:absolute; left:31%; top:513px;" ><img id="buttonImage" name="saveItemAndContinueButton" src="<?php echo $PROJECT_PATH;?>webImages/saveaddanotherbutton.png" alt="SaveAddAnotherButton"  onclick="submitItemListForm('saveItemAndContinue')"/></div>
                                    <!Set up the cross pic for cancel listing >
                                    <div style="position:absolute; left:90%; top:513px;"><a href="<?php echo $PROJECT_PATH;?>sell/" ><img src="<?php echo $PROJECT_PATH;?>webImages/cross.png" alt="cross" border="0"/></a></div>

                            <?php
                                }
                            ?>
                            </div>

                            <br/>
                            <div id="message" class="listFormMessage">
                            <?php
    //                            echo $insertSQL;
                //              Display any available error message
                                if(isset($_GET['message']))
                                {
                                    echo "--> ".$_GET['message']."<br/>";
                                }
                            ?>
                            </div>
                        </div>
                <?php
                }
                ?>

                </div>
                <?php
                    include_once '../middleRightSection.inc.php';
                ?>
            </div>

            <?php
                include("../footerSection.inc.php");
            ?>

            <?php
                if(isset($_GET['height']))
                {
                    ?>
                        <script type="text/javascript">
                            var helpContent = document.getElementById('helpContent');
                            var middleSession = document.getElementById("middleSection");
                            helpContent.style.width = 1080 + "px";


                            var addedHeight = <?php echo $_GET['height'];?>;

                            //case IE, set grassfooter position and increase addedHeight
                            if (/MSIE (\d+\.\d+);/.test(navigator.userAgent)) //test for MSIE x.x;
                            {
                                addedHeight = addedHeight - 20;
                                if(addedHeight > 6000)
                                {
                                    addedHeight += 450;
                                }
                                document.getElementById("footer").style.top =  addedHeight - 80   + "px";
                                var grassFooter = document.getElementById("grassFooter");
                                grassFooter.style.top = addedHeight +  "px";

                            }

                            window.document.body.style.height = addedHeight  + "px";
                            middleSession.style.height = addedHeight - 520  + "px";


                        </script>

                    <?php
                }
            ?>
    </body>
</html>
