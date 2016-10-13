<?php

    if(isset($_POST['purchaseSubmit']))
    {
        include("../mySQL_connection.inc.php");

        $userID = $_POST['userID'];
        $itemID = $_POST['itemID'];
        $purchaseType = $_POST['purchaseType'];
        
        $conn = dbConnect();

        //check if the item have already been purchased in the past and the item quantity < 1
        $sql = "SELECT * FROM item WHERE ItemID = $itemID";
        $result = mysql_query($sql) or die(mysql_error());
        $row = mysql_fetch_array($result);
        $currentQuantity = $row['Quantity'];

        $sql = "SELECT * FROM sale WHERE ItemID = $itemID";
        $result = mysql_query($sql) or die(mysql_error());

        mysql_close($conn);
        if(mysql_num_rows($result) AND $currentQuantity < 1)
        {
            header("HTTP/1.1 301 Moved Permanently");
            header("Location:".$PROJECT_PATH."buy/confirmPurchasePage.php?closeAuction=true&ItemID=$itemID&SellerID=".$_POST['sellerID']);
        }
        else
        {
            //process the item purchase depend on the type
            if($purchaseType == 'buy')
            {
                $conn = dbConnect();
                //insert a new sale record
                //for buy now bid amount will be set to null
                $sql = "INSERT INTO sale (ItemID, BuyerID, SaleTime, BidAmount, Paid, PaymentMethod) VALUES ($itemID, $userID, '".date('Y-m-d H:i:s')."', null, 0, '')";
                
                mysql_query($sql) or die(mysql_error());

                //get the return saleID and insert a feedback record for this sale
                $saleID = mysql_insert_id();
                $sql = "INSERT INTO feedback (SaleID, buyerRating, buyerComment, buyerFeedbackDate, sellerRating, sellerComment, sellerFeedbackDate) VALUES ($saleID, null, null, null, null, null, null)";
                mysql_query($sql) or die(mysql_error());

                //update the item finish time or item quantity
                if($currentQuantity == 1)
                {
                    $sql = "UPDATE item SET timeFinish = '".date('Y-m-d H:i:s')."', Quantity = 0 WHERE item.ItemID = $itemID";
    //                echo $sql;
                    mysql_query($sql) or die(mysql_error());
                }
                else
                {
                    $sql = "UPDATE item SET Quantity = ".($currentQuantity - 1)." WHERE item.ItemID = $itemID";
    //                echo $sql;
                    mysql_query($sql) or die(mysql_error());
                }

                //send the emails notificaton to both seller and buyers to inform about the purchase.
                $sql = "SELECT * FROM user WHERE UserID = $userID";
                $result = mysql_query($sql) or die(mysql_error());
                $buyer = mysql_fetch_array($result);

                $sql = "SELECT * FROM user WHERE UserID = (SELECT SellerID FROM item WHERE ItemID = $itemID)";
                $result = mysql_query($sql) or die(mysql_error());
                $seller = mysql_fetch_array($result);

                $sql = "SELECT * FROM item WHERE ItemID = $itemID";
                $result = mysql_query($sql) or die(mysql_error());
                $item = mysql_fetch_array($result);

                $subject = "Twizla Item Purchase Notify";

                $sellerContent = "<img src='".$PROJECT_PATH."webImages/logo.png' alt='Twizla Logo'/>
                                    <br><br><br>
                                Dear ".$seller['FirstName'].",<br>
                                This email is sent by <b>Twizla</b> to inform that Item Number ".$item['ItemID']." ( ".$item['ItemTitle'].") has been purchased by ".$buyer['FirstName']." at ".date('H:i:s d-M-Y').".<br>
                                Please <a href='".$PROJECT_PATH."user/".$buyer['UserName']."/contact'>contact the buyer</a> for any further question regarding the transaction.
                                <br><br>
                                Sincerely,<br>
                                <b>The Twizla Team</b> ";


                $buyerContent = "<img src='".$PROJECT_PATH."webImages/logo.png' alt='Twizla Logo'/>
                                    <br><br><br>
                                    Dear ".$buyer['FirstName'].",<br>
                                    This email is sent by <b>Twizla</b> to inform that you have purchased the Item Number ".$item['ItemID']." ( ".$item['ItemTitle'].") at ".date('H:i:s d-M-Y').".<br>
                                    Please <a href='".$PROJECT_PATH."user/".$seller['UserName']."/contact'>contact the seller</a> for any further question regarding the transaction.
                                    <br><br>
                                    Sincerely,<br>
                                    <b>The Twizla Team</b> ";

                include_once '../sendEmail.inc.php';
                sendEmail($seller['Email'], $subject, $sellerContent);
                sendEmail($buyer['Email'], $subject, $buyerContent);

                mysql_close();
                header("HTTP/1.1 301 Moved Permanently");
                header("Location:".$PROJECT_PATH."buy/confirmPurchasePage.php?confirm=true&ItemID=$itemID&SellerID=".$_POST['sellerID']);
            }
            else if($purchaseType == 'bid')
            {
                
                $bidAmount = $_POST['bidAmount'];
                $minBid = $_POST['minBid'];
                $message = "";

                //check bidAmount format
                if($bidAmount == "")
                {
                    $message = "Please enter your bid.";
                }
                else if(!is_numeric($bidAmount))
                {
                    $message = "Bid amount must be in positive format.";
                }
                else if($bidAmount < $minBid)
                {
                    $message = "Bid amount must be greater than the minimum allowed bid.";
                }

                if($message == "")
                {
                    $conn = dbConnect();
                    
                    //insert a new bid record
                    $sql = "INSERT INTO bid (ItemID, BidderID, BidAmount, BidTime) VALUES ($itemID, $userID, $bidAmount, '".date('Y-m-d H:i:s')."')";
                    mysql_query($sql) or die(mysql_error());
                    mysql_close();
                    
                    include_once 'bidFunctions.inc.php';
                    $currentBid = getCurrentBid($itemID);

                    $conn = dbConnect();
                    //update the number of bid in item table as well as the current bid of the item
                    $sql = "UPDATE item SET numberOfBid = (numberOfBid + 1), currentBid = ".$currentBid." WHERE ItemID = $itemID";
                    mysql_query($sql) or die(mysql_error());

                    mysql_close();

                    //get the maximum bid for this item and see if it belong to the current user, if not then
                    //display the message inform the user have been outbidded.
                    include_once 'bidFunctions.inc.php';
                    
                    if(!isMaxBidder($itemID, $userID))
                    {
                        header("HTTP/1.1 301 Moved Permanently");
                        header("Location:".$PROJECT_PATH."buy/confirmPurchasePage.php?type=bid&bidAmount=".$bidAmount."&ItemID=".$itemID."&bidResult=outbidded");
                    }
                    else if(isMaxBidder($itemID, $userID))
                    {
                        $conn = dbConnect();
                        //get the second highest bid and check if it belongs to another user
                        //if it is then send the user an email to inform about the outbidded.
                        $sql = "SELECT * FROM bid, user WHERE ItemID = $itemID AND BidderID = user.UserID ORDER BY BidAmount DESC";
                        $result = mysql_query($sql) or die(mysql_error());
                        while($row = mysql_fetch_array($result))
                        {
                            $bidList[] = $row;
                        }

                        if(count($bidList) > 1)
                        {
                            //with the bidlist order by bidAmount descending, the sencond highest bid is in bidList[1]
                            $secondBid = $bidList[1];
                            if($secondBid['BidderID'] != $userID)
                            {

                                $sql = "SELECT * FROM item WHERE ItemID = $itemID";
                                $result = mysql_query($sql) or die(mysql_error());
                                $item = mysql_fetch_array($result);

                                include_once '../sendEmail.inc.php';

                                $email = $secondBid['Email'];

                                $subject = "Twizla - Auction Outbidded Notification";

                                $content = "<a href='".$PROJECT_PATH."'><img src='".$PROJECT_PATH."webImages/logo.png' alt='Twizla Logo' style='border: 0;'/></a>
                                        <br><br><br>
                                        Dear ".$secondBid['FirstName'].",<br>
                                        This email is sent by Twizla to inform that you have been outbidded in the auction of Item Number ".$item['ItemID']." ( ".$item['ItemTitle'].") at ".date('H:i:s d-M-Y', strtotime($bidList[0]['BidTime'])).".<br>
                                        Please <a href='".$PROJECT_PATH."listing/".$item['ItemID']."/".formatItemTitle($item['ItemTitle'])."'>bid again</a> as soon as possible to win this auction.<br><br>

                                        Sincerely,<br>
                                        <b>The Twizla Team</b> ";

                                sendEmail($email, $subject, $content);
                            }

                            mysql_close();
                        }
                        header("HTTP/1.1 301 Moved Permanently");
                        header("Location:".$PROJECT_PATH."buy/confirmPurchasePage.php?type=bid&bidAmount=".$bidAmount."&ItemID=".$itemID."&bidResult=winning");
                    }

                }
                else
                {
                    header("HTTP/1.1 301 Moved Permanently");
                    header("Location:".$PROJECT_PATH."buy/confirmPurchasePage.php?type=bid&bidAmount=".$bidAmount."&minBid=".$minBid."&ItemID=".$itemID."&message=".$message);
                }


            }
        }
        
    }


?>
