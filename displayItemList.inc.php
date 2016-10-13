<?php
    //this function display the item list in gallery format, including a popup panel
    //allow bidding and buy now on the spot.
    //$itemLink: the link that will be called when an item picture is clicked, is by defaul link to the displayItemDetail Page
    ////$listName: name of the itemList, used to add into popUp panels ids when display multilists in same page.
    //$cssContainer: name of the css format container(eg: searchItemContainer, myAccountItemContainer)
    // $hasPopup : determine whether to display the popup item info panel when mouse hover over the item picture,either true or false
    //$pageLink: the href link to be call when there is more than one page and user select the page bar
    //$deleteFunction: this parameter decides the deleteFunction: - "moveToDelete" : Move to deleted box of MyAccount
//                                                                - "unsoldDelete" : Completely delete the item out of the database (For Unsold Item)
//                                                                - ""             : Do not display the deletebutton on the item picture.
    
    function displayItemList($itemList,$itemPerPage,$itemLink, $listName, $cssContainer, $hasPopup, $pageLink, $deleteFunction)
    {
        $PROJECT_PATH = "http://www.twizla.com.au/";
//        $PROJECT_PATH = "http://www.twizla.com.au/twizlaFolderStructure/";
//        $PROJECT_PATH = "http://localhost/Twizla/";
        if(count($itemList) > 0)
        {
            $ITEM_PER_PAGE = $itemPerPage;
            $numberOfPage = ceil(count($itemList) / $ITEM_PER_PAGE);
            //set the number of start item to display
            //if there is no current page set by user, the start item number is 0
            $startItemNumber = 0;
            if(isset($_GET['pageNumber']))
            {
                $startItemNumber = ($_GET['pageNumber'] - 1) * $ITEM_PER_PAGE;
            }

            //record the original link to prevent over added of item buyer ID
            $originalLink = $itemLink;
            for($count = $startItemNumber; $count < count($itemList); $count ++)
            {
                //break when reach the set number of items displayed on the page
                if($count == ($startItemNumber + $ITEM_PER_PAGE))
                {
                    break;
                }

                $item = $itemList[$count];

                //check the itemLink, if not specified then set to default link: displayItemDetailPage.php
//                if($itemLink == "")
//                {
//                    $itemLink = "displayItemDetailPage.php?";
//                }
                //check if is soldList, if is then added the BuyerID into the item link for displayItemDetailPage.php
                if($listName == "soldList")
                {
                    $itemLink = $originalLink."/".$item['BuyerID'];
                }
                //List item information including: Picture, price, title, description
                ?>
                
                <div id="<?php echo $cssContainer;?>" onmouseover="displayInfoPopUp('<?php echo $listName;?>',<?php echo $item['ItemID'];?>,this)" onmouseout="hideInfoPopUp(<?php echo $item['ItemID'];?>,'<?php echo $listName;?>')">
                    <?php

                        $hidingURL = $PROJECT_PATH."listing/".$item['ItemID']."/".formatItemTitle($item['ItemTitle']);
//                        $hidingURL = $itemLink."ItemID=".$item['ItemID']."&ItemName=".$item['ItemTitle'];
                        echo "<a href='$hidingURL' style='text-decoration:none; font-size:12px;'>";

                        //if is displaying the won item list, then display the not paid tag for item haven't been paid

                        if($listName == 'wonList' AND !$item['Paid'])
                        {
                            echo "<img id='notPaidTag' src='".$PROJECT_PATH."webImages/notPaidTag.png' alt='notPaidTag' />";

                           //set the position of the item information text to just bellow the item image

                        }
                        else if ($listName == 'soldList' AND $item['Paid'])
                        {
                            echo "<img id='notPaidTag' src='".$PROJECT_PATH."webImages/paidTag.png' alt='paidTag' />";
                        }

                        echo "<div  style='border: 1px solid #c4c4c4; width: 110px; height: 110px; text-align: center;'>";
                        include_once 'imageResize.inc.php';

                        $imageSize = getimagesize($PROJECT_PATH.$item['PictureLink']);
//                        echo imageResize($imageSize[0],$imageSize[1],  110, 110);
                        
                        echo "<a href='$hidingURL' ><img src='".$PROJECT_PATH.$item['PictureLink']."' ".imageResize($imageSize[0],$imageSize[1],  110, 110)." border='0'/></a>";

                        //if is set to have item deletion, display the cross image
                        if($deleteFunction == "moveToDelete")
                        {
                            echo "<a href='deleteMyAccountItem.php?ItemID=".$item['ItemID']."&UserID=".$_SESSION['userID']."&Type=".$listName."'><img class='myAccountRemoveButton' src='".$PROJECT_PATH."webImages/cross.png' border='0' alt='cross'/></a>";
                        }
                        else if($deleteFunction == "unsoldDelete")
                        {
                            echo "<a href='removeItem.php?ItemID=".$item['ItemID']."'><img class='myAccountRemoveButton' src='".$PROJECT_PATH."webImages/cross.png' border='0' alt='cross'/></a>";
                        }

                        echo "</div>";



                        //put a new tag for new listing items
                        //check if the item is listed during the last 3 day
                        //if it is, display the new tag picture
                        $isNew = $item['listedDate'] >= date("Y-m-d", strtotime("-3 days"));

                        if($isNew)
                        {
                            echo "<div id='smallNewTag'>NEW!</div>";
                            //set the position of the item information text up to just bellow the item image
                            echo "<div style='margin-top:-16px;'>";
                        }

                        
                        echo "<div style='color:#213155; font-size:12px; position: absolute; width: 110px; word-wrap: break-word;'>";
                        if(strlen($item['ItemTitle']) > 12)
                        {
                            echo "<b>".substr($item['ItemTitle'],0,12)."...</b><br>";
                        }
                        else
                        {
                            echo "<b>".$item['ItemTitle']."</b><br>";
                        }
                        
                        if(strlen($item['CatchPhrase']) > 18)
                        {
                            echo substr($item['CatchPhrase'],0,17)."...<br>";
                        }
                        else
                        {
                            echo $item['CatchPhrase']."<br>";
                        }
                        echo "</div>";

                        if($isNew)
                        {
                            echo "</div>";
                        }

                        echo "</a>";
                        ?>
                </div>

                <!if posX and posY is set, set up the popup panel>
                <?php
                if($hasPopup)
                {
                ?>
                    <!--set up the pop up panel for each item here 
                    //in this popup window, we shall display item description, prices, and
                    //allow user to buy & bid on the spot-->
                    <div class='popUpItemInfo' id="<?php echo $listName;?>popUp<?php echo $item['ItemID'];?>" onmouseover="reservePopUp(this)" onmouseout="hideInfoPopUp(<?php echo $item['ItemID'].",'".$listName."'"?>)">
                    <?php
                        echo "<div id='popUpDesc'>";
                        if(strlen($item['Description']) > 90)
                        {
                            echo "<b>".substr($item['Description'],0,87)."...</b><br/>";
                        }
                        else
                        {
                            echo "<b>".$item['Description']."</b><br/>";
                        }
                        echo "</div>";
                        echo "<label id='popUpLabel'>Time Remaining:</label>";
                        //if there is less than 24 hours left before the item listing finished, change the time remain to red
                        $A_DAY_TIMESTAMP = 24*60*60;
                        $A_HOUR_TIMESTAMP = 60*60;
                        $timeRemain = strtotime($item['timeFinish']) - time();
                        $dayRemain = floor($timeRemain/$A_DAY_TIMESTAMP);
                        $hourRemain = floor(($timeRemain - ($dayRemain * 24*60*60))/$A_HOUR_TIMESTAMP) ;
                        if($timeRemain <= 0)
                        {
                            echo " Ended.";
                        }
                        else if($dayRemain == 0 AND $hourRemain == 0)
                        {
                            echo "<label style='color:red;'>  Less than an hour. </label>";
                        }
                        else if($dayRemain == 0 AND $hourRemain < 24)
                        {
                            echo "<label style='color:red;'>".$dayRemain ." days ".$hourRemain." hours (".date("d M, Y H:i:s",strtotime($item['timeFinish'])).")</label>";
                        }
                        else
                        {
                            echo $dayRemain ." days ".$hourRemain." hours (".date("d M, Y H:i:s",strtotime($item['timeFinish'])).")";
                        }
                        echo "<br/>";

                        //if the item has not ended, allow user to buy / bid

                        if($timeRemain > 0)
                        {
                            //only display the buy if the price is set
                            echo "<div  style='margin-top:8px; margin-bottom:4px;'>";
                            //include the functions to check if item has been bidded
                            include_once 'buy/bidFunctions.inc.php';
                            if($item['Price'] != null AND $item['Price'] > 0 AND !hasBid($item['ItemID']))
                            {
                                echo "<label id='popUpLabel' >Buy Now Price:</label>";
                                setlocale(LC_MONETARY, 'en_AU');
                                echo "<label id='price' width='20'>$";

                                if($item['Price'] < 9999999)
                                {
                                    echo number_format($item['Price'],2);

                                }
                                else
                                {
                                    echo substr(number_format($item['Price'],2),0, 8)."...";
                                }

                                echo "</label>";

                                ?>
                                <!input id='button2' type='submit' class='popUpButton' value='Buy Now' style="<?php //if($item['SellerID'] == $_SESSION['userID'] OR isset($_GET['view'])) echo "display: none;";?>" onclick="goToConfirmPurchase('buy',<?php //echo $item['ItemID'];?>)" />
                                <img id="imageButton" class="popUpButton" alt="buynowbutton" src="<?php echo $PROJECT_PATH;?>webImages/buynowbutton.png" style="<?php if($item['SellerID'] == $_SESSION['userID'] OR isset($_GET['view'])) echo "display: none;";?>" onclick="goToConfirmPurchase('buy',<?php echo $item['ItemID'];?>)" />
                                <?php
                                echo "<br>";
                            }
                            echo "</div>";

                            //only display the bid if the starting bid price is set
                            echo "<div  style='margin-top:4px; margin-bottom:4px;'>";
                            if($item['startingBid'] != null AND $item['startingBid'] > 0)
                            {
                                echo "<label id='popUpLabel'>Current Bid:</label>";
                                echo "<label id='price' width='20'>$".number_format($item['currentBid'],2)."</label>";
                                echo "<br>";
                                if($item['SellerID'] != $_SESSION['userID'] AND !isset($_GET['view']))
                                {
                                    echo "<input id='bidAmount".$item['ItemID']."' type='text' size='25' style='width: 140px;'/>";
                                ?>
                                    <!input id='button' type='submit' class='popUpButton' value='Bid It!' onclick="goToConfirmPurchase('bid',<?php echo $item['ItemID'];?>)" />
                                    <img id='imageButton' class='popUpButton' src="<?php echo $PROJECT_PATH;?>webImages/biditbutton.png" alt="biditbutton" onclick="goToConfirmPurchase('bid',<?php echo $item['ItemID'];?>)" />
                                <?php
                                }
                            }
                            echo "</div>";
                        }
                        ?>
                    </div>
                <?php
                }
            }
        }
        else
        {
            if($listName =="searchList" ) echo "You search return 0 item";
            else echo "<br/>&nbsp;&nbsp;&nbsp;&nbsp;There is no item available.";

        }

         //Show the page bar if there is more items to display on the screen.

        if($numberOfPage > 1)
        {
            echo "<ul id='pageBar'>";
            echo "<li style='border:0'><b>Page</b></li>";
            //set the pageBar depend on the current page
            //increase the pageBar numbers when the current page > 5
            if(isset($_GET['pageNumber']))
            {
                if($_GET['pageNumber'] > 5)
                {
                    //add 3 page links on the left of the current page
                    $pageBarStart = $_GET['pageNumber'] - 3;

                    echo "<li><a href='".$pageLink."&pageNumber=1' style='text-decoration: none; color:#213155;'>1</a></li>";
                    echo "<li>...</a></li>";
                }
                else
                {
                    $pageBarStart = 1;
                }
            }
            else
            {
                echo "<li style='text-decoration:underline;'>
                    <a href='".$pageLink."&pageNumber=1' style=' color:#F52887;'>1</a>
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
                                <a href='".$pageLink."&pageNumber=$numberOfPage' style='text-decoration: none; color:#213155;'> $numberOfPage</a>
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
                        echo "<li style='border: 0;'><a href='".$pageLink."&pageNumber=".($currentPage + 1)."'><img  id='nextPageButton' src='".$PROJECT_PATH."webImages/pageBarButton.png' border='0'/></a></li>";
                    }
                    break;
                }
                //bold format the current page
                if($count == $_GET['pageNumber'])
                {
                    echo "<li style='text-decoration:underline;'>
                            <a href='".$pageLink."&pageNumber=$count' style=' color:#F52887;'>$count</a>
                        </li>";
                }
                else
                {
                    echo "<li>
                            <a href='".$pageLink."&pageNumber=$count' style='text-decoration: none; color:#213155;'>$count</a>
                        </li>";
                }

            }
            echo "</ul>";
        }

    }

?>
