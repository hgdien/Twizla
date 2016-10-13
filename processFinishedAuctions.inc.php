<?php
    include_once 'mySQL_connection.inc.php';

    //this file will process all auction that finished, including:
//        - Update DB (Insert a sale record for item sold and update unsold status for item unsold)
//        - Update DB (Delete All items that is older than 1 month as well as all records associate with that item)
//        - Send email notification to buyer (if exist)
//        - Send email notification to seller

    $conn = dbConnect();

    //get all finished item information
    $selectSQL = "SELECT * FROM item WHERE item.Quantity > 0 AND
                                            item.timeFinish <= '".date("Y-m-d H:i:s",time())."' AND
                                            item.Unsold = 0";

    $result = mysql_query($selectSQL) or die(mysql_error());

    while($row = mysql_fetch_array($result))
    {
        $finishList[] = $row;
    }

    if(count($finishList) > 0)
    {
        //check to see if there is any bid for each item in finish list
        foreach($finishList as $item)
        {
            $selectSQL = "SELECT * FROM bid WHERE ItemID = ".$item['ItemID']." ORDER BY BidTime DESC";

            $result = mysql_query($selectSQL) or die(mysql_error());

            //check if the auction is won or become unsold (no bidder at all)
            if(mysql_num_rows($result))
            {
                while($row = mysql_fetch_array($result))
                {
                    $bidList[] = $row;
                }
                processSoldAuction($item,$bidList);
            }
            else
            {
                processUnsoldAuction($item);
            }

        }
    }


    //check & delete item older than 1 month
    deleteOldItems();

    mysql_close($conn);

    function processSoldAuction($item,$bidList)
    {
            //if there is bid, get the winner id and insert a new sale record & feedback record
            $sql = "SELECT * FROM bid WHERE BidAmount IN (SELECT MAX(BidAmount) FROM bid WHERE ItemID = ".$item['ItemID'].") ORDER BY bidTime ASC";
            $result = mysql_query($sql) or die(mysql_error());
            while($row = mysql_fetch_array($result))
            {
                $maxBidList[] = $row;
            }
            $maxBid = $maxBidList[0];

            $sql = "INSERT INTO sale (ItemID, BuyerID, SaleTime, BidAmount, Paid, PaymentMethod) VALUES(".$item['ItemID'].",".$maxBid['BidderID'].",'".$item['timeFinish']."',".$maxBid['BidAmount'].", 0, '')";
            mysql_query($sql) or die(mysql_error());

            $saleID = mysql_insert_id();
            $sql = "INSERT INTO feedback (SaleID, buyerRating, buyerComment, buyerFeedbackDate, sellerRating, sellerComment, sellerFeedbackDate) VALUES($saleID, null, null, null, null, null, null)";
            mysql_query($sql) or die(mysql_error());

            //update the quantity of the item
            $sql = "UPDATE item SET Quantity = 0 WHERE ItemID = ".$item['ItemID'];
            mysql_query($sql) or die(mysql_error());

            //send email notification to both winner and seller to inform about the finish auction.
            
            $sql = "SELECT * FROM user WHERE UserID = ".$maxBid['BidderID'];
            $result = mysql_query($sql) or die(mysql_error());
            $buyer = mysql_fetch_array($result);

            $sql = "SELECT * FROM user WHERE UserID = (SELECT SellerID FROM item WHERE ItemID = ".$item['ItemID'].")";
            $result = mysql_query($sql) or die(mysql_error());
            $seller = mysql_fetch_array($result);

            $subject = "Twizla Auction Finish Notify";

            $sellerContent = "<img src='".$PROJECT_PATH."webImages/logo.png' alt='Twizla Logo'/>
                                    <br><br><br>
                                Dear ".$seller['FirstName'].",<br>
                                This email is sent by <b>Twizla</b> to inform that your auction of item Number ".$item['ItemID']." ( ".$item['itemTitle'].") has been won by ".$buyer['FirstName']." at ".date('d M Y H:i:s',strtotime($item['timeFinish']))."
                                with the bid amount of ".$item['currentBid'].".<br>
                                Please <a href='".$PROJECT_PATH."user/".$buyer['UserName']."/contact'>contact the buyer</a> for any further question regarding the transaction.
                                <br><br>
                                Sincerely,<br>
                                <b>The Twizla Team</b> ";
//                                echo $sellerContent;
            $winnerContent = "<img src='".$PROJECT_PATH."webImages/logo.png' alt='Twizla Logo'/>
                                    <br><br><br>
                                    Dear ".$buyer['FirstName'].",<br>
                                    This email is sent by <b>Twizla</b> to inform that you have won the auction of item Number ".$item['ItemID']." ( ".$item['itemTitle'].") at ".date('d M Y H:i:s',strtotime($item['timeFinish']))."
                                    with the bid amount of ".$item['currentBid'].".<br>
                                    Please <a href='".$PROJECT_PATH."user/".$seller['UserName']."/contact'>contact the seller</a> for any further question regarding the transaction.
                                    <br><br>
                                    Sincerely,<br>
                                    <b>The Twizla Team</b> ";

            include_once 'sendEmail.inc.php';
            sendEmail($seller['Email'], $subject, $sellerContent);
            sendEmail($buyer['Email'], $subject, $winnerContent);

            //also send email notification to all bidders in the auction about the finish auction.
            foreach($bidList as $bid)
            {
                if($bid['BidderID'] != $maxBid['BidderID'])
                {
                    $sql = "SELECT * FROM user WHERE UserID = ".$bid['BidderID'];
                    $result = mysql_query($sql) or die(mysql_error());
                    $bidder = mysql_fetch_array($result);

                    $bidderContent = "<img src='".$PROJECT_PATH."webImages/logo.png' alt='Twizla Logo'/>
                                    <br><br><br>
                                    Dear ".$bidder['FirstName'].",<br>
                                    This email is sent by <b>Twizla</b> to inform about the finish auction of item Number ".$item['ItemID']." ( ".$item['itemTitle'].").<br>
                                    Unfortunately, you are not the winner. Another <b>Twizla</b> member have won the auction at ".date('d M Y H:i:s',strtotime($item['timeFinish']))." with the maximum bid amount of ".$item['currentBid'].".<br>
                                    We would like to wish you best luck in the future auctions.<br>
                                    Please check out other exciting auctions currently open on <a href='".$PROJECT_PATH."'>Twizla</a>.
                                    <br><br>
                                    Sincerely,<br>
                                    <b>The Twizla Team</b> ";

                    sendEmail($bidder['Email'], $subject, $bidderContent);
                }
            }

    }

    function processUnsoldAuction($item)
    {
        $sql = "SELECT * FROM user WHERE UserID = ".$item['SellerID'];
        $result = mysql_query($sql) or die(mysql_error());
        $seller = mysql_fetch_array($result);

        $selectSQL = "SELECT * FROM autoRelistList WHERE UserID = ".$seller['UserID'];
        $result = mysql_query($selectSQL) or die(mysql_error());

        if(mysql_num_rows($result))
        {
            $listDuration = $item['listDuration'];
            $newListedDate = date("Y-m-d H:i:s");
            $A_DAY_TIMESTAMP = 24*60*60;
            $newTimeFinish = date("Y-m-d H:i:s", (strtotime($newListedDate) + $listDuration * $A_DAY_TIMESTAMP));
            //create the delete query to remove item record
            $updateSQL = "UPDATE item SET  listedDate = '$newListedDate', timeFinish = '$newTimeFinish', Unsold = 0 WHERE ItemID = ".$item['ItemID'];
            mysql_query($updateSQL) or die(mysql_error());
        }
        else
        {

            //update unsold status of the item
            $sql = "UPDATE item SET Unsold = 1 WHERE ItemID = ".$item['ItemID'];
            mysql_query($sql) or die(mysql_error());

            //send email to the seller to inform that the item have become unsold
            include_once 'sendEmail.inc.php';




            $subject = "Twizla Unsold item Notification";

            $sellerContent = "<img src='".$PROJECT_PATH."webImages/logo.png' alt='Twizla Logo'/>
                                                        <br><br><br>
                                                        Dear ".$seller['FirstName'].",<br>
                                                        This email is sent by <b>Twizla</b> to inform that the item Number ".$item['ItemID']." ( ".$item['itemTitle'].") has become unsold at ".date('d M Y H:i:s',strtotime($item['timeFinish'])).".
                                                        <br>
                                                        Please <a href='".$PROJECT_PATH."myAccountPage.php?page=Sell&tab=3'>re-list the item</a> as soon as posible.
                                                        <br><br>
                                                        Sincerely,<br>
                                                        <b>The Twizla Team</b> ";
            sendEmail($seller['Email'], $subject, $sellerContent);
        }

    }

    function deleteOldItems()
    {
            //get the past date 1 months from now
            $ONE_MONTHS_TIMESTAMP = 30*24*60*60;
            $compareDate = date("Y-m-d H:i:s", time() - $ONE_MONTHS_TIMESTAMP);

            $sql = "SELECT * FROM item, sale WHERE item.ItemID = sale.ItemID AND
                                            sale.SaleTime <= '$compareDate'";

            $result = mysql_query($sql) or die(mysql_error());

            while($row = mysql_fetch_array($result))
            {
                $sql = "DELETE FROM feedback WHERE SaleID = ".$row['SaleID'];
                mysql_query($sql) or die(mysql_error());

                $sql = "DELETE FROM sale WHERE SaleID = ".$row['SaleID'];
                mysql_query($sql) or die(mysql_error());

                $sql = "DELETE FROM itemtag WHERE ItemID = ".$row['ItemID'];
                mysql_query($sql) or die(mysql_error());

                $sql = "DELETE FROM bid WHERE bid.ItemID = ".$row['ItemID'];
                mysql_query($sql) or die(mysql_error());

                $sql = "DELETE FROM picturelink WHERE ItemID = ".$row['ItemID'];
                mysql_query($sql) or die(mysql_error());

                $sql = "DELETE FROM itempaymentmethod WHERE ItemID = ".$row['ItemID'];
                mysql_query($sql) or die(mysql_error());
                
                $sql = "DELETE FROM item WHERE item.ItemID = ".$row['ItemID'];
                mysql_query($sql) or die(mysql_error());
            }

    }

?>
