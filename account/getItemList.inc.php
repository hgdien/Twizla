<?php





    $userID = $_SESSION['userID'];
    $conn = dbConnect();

    //get the past date 1 months from now
    $ONE_MONTH_TIMESTAMP = 30*24*60*60;
    $compareDate = date("Y-m-d", time() - $ONE_MONTH_TIMESTAMP);
    //get the list of item based on the current page of myAccount ]
    if(!isset($_GET['page']) OR $_GET['page']== 'Buy')
    {

        //delete all items in deletedrecord table that is older than 1 months

        $sql = "DELETE FROM deleterecord WHERE DeleteDate <= '$compareDate'";

        mysql_query($sql) or die(mysql_error());

        //for Buy page get the tag list, bidding list, won list, didn't win list and deleted list

        //get the items that tagged by this user, excluded the ones in the delete record list
        $selectSQL = "SELECT * FROM item, itemtag, picturelink WHERE item.ItemID = itemtag.ItemID AND
                                                            item.ItemID = picturelink.ItemID AND
                                                            itemtag.UserID = $userID AND
                                                            itemtag.ItemID NOT IN (SELECT itemID FROM deleterecord WHERE deleterecord.UserID = $userID AND Type='tagList')
                                                            GROUP BY itemtag.ItemID
                                                            ORDER BY itemtag.TagID DESC";
        $result = mysql_query($selectSQL) or die(mysql_error());

        while($row = mysql_fetch_array($result))
        {
             $tagList[] = $row;
        }

        $_SESSION['tagList'] = $tagList;
        //get the items that bidding by this user
        $selectSQL = "SELECT * FROM item, bid, picturelink WHERE item.ItemID = bid.ItemID AND
                                                                item.ItemID = picturelink.ItemID AND
                                                                bid.bidderID = $userID AND
                                                                item.Quantity > 0 AND
                                                                item.timeFinish > '".date("Y-m-d H:i:s",time())."'
                                                            GROUP BY bid.ItemID
                                                            ORDER BY bid.bidTime DESC";

        $result = mysql_query($selectSQL) or die(mysql_error());

        while($row = mysql_fetch_array($result))
        {
             $bidList[] = $row;
        }

        //get the items that won by this user, excluded the ones in the delete record list
        $selectSQL = "SELECT * FROM item, sale, picturelink WHERE item.ItemID = sale.ItemID AND
                                                                    item.ItemID = picturelink.ItemID AND
                                                                    sale.BuyerID = $userID AND
                                                                    sale.ItemID NOT IN (SELECT itemID FROM deleterecord WHERE deleterecord.UserID = $userID AND Type='wonList')
                                                                GROUP BY sale.SaleID
                                                                ORDER BY sale.Paid ASC,sale.saleTime DESC";


        $result = mysql_query($selectSQL) or die(mysql_error());

        while($row = mysql_fetch_array($result))
        {
             $wonList[] = $row;
        }


        //get all item that the user bidded but did not win, excluded the ones in the delete record list
        $selectSQL = "SELECT * FROM item, bid, picturelink, sale WHERE item.ItemID = bid.ItemID AND
                                                                    item.ItemID = picturelink.ItemID AND
                                                                    bid.bidderID = $userID AND
                                                                    sale.BuyerID != $userID AND
                                                                    item.ItemID = sale.ItemID AND
                                                                    item.timeFinish <= '".date("Y-m-d H:i:s",time())."' AND
                                                                    bid.ItemID NOT IN (SELECT itemID FROM deleterecord WHERE deleterecord.UserID = $userID AND Type='notWinList')
                                                                GROUP BY bid.ItemID
                                                                ORDER BY bid.bidTime DESC";


        $result = mysql_query($selectSQL) or die(mysql_error());

        while($row = mysql_fetch_array($result))
        {
             $notWinList[] = $row;
        }

        //get all item deleted in the myAccount page by this user
        $selectSQL = "SELECT * FROM item, deleterecord, picturelink WHERE item.ItemID = deleterecord.ItemID AND
                                                                    item.ItemID = picturelink.ItemID AND
                                                                    deleterecord.UserID = $userID
                                                                GROUP BY deleterecord.ItemID
                                                                ORDER BY deleterecord.ItemID DESC";
        $result = mysql_query($selectSQL) or die(mysql_error());

        while($row = mysql_fetch_array($result))
        {
             $buyDeleteList[] = $row;
        }

    }

    else if($_GET['page'] == "Sell")
    {

        //select all items this user is selling
        $selectSQL = "SELECT * FROM item, picturelink WHERE item.ItemID = picturelink.ItemID AND
                                                            item.SellerID = $userID AND
                                                            timeFinish > '".date("Y-m-d H:i:s",time())."' AND
                                                            item.Quantity > 0
                                                        GROUP BY item.ItemID
                                                        ORDER BY item.listedDate DESC";

        $result = mysql_query($selectSQL) or die(mysql_error());
        while($row = mysql_fetch_array($result))
        {
             $sellList[] = $row;
        }       

        //select all item listed by user which is sold
        $selectSQL = "SELECT * FROM item, picturelink, sale WHERE item.ItemID = picturelink.ItemID AND
                                                            item.ItemID = sale.ItemID AND
                                                            item.SellerID = $userID
                                                        GROUP BY sale.SaleID
                                                        ORDER BY sale.Paid ASC,sale.saleTime DESC";

//        echo $selectSQL;
        $result = mysql_query($selectSQL) or die(mysql_error());
        while($row = mysql_fetch_array($result))
        {
             $soldList[] = $row;
        }

        //select all item listed by user which is not won and finished( become unsold)
        $selectSQL = "SELECT * FROM item, picturelink WHERE item.ItemID = picturelink.ItemID AND
                                                            item.SellerID = $userID AND
                                                            item.Unsold = 1 AND
                                                            item.Quantity > 0
                                                        GROUP BY item.ItemID
                                                        ORDER BY item.listedDate DESC";
        
        $result = mysql_query($selectSQL) or die(mysql_error());
        while($row = mysql_fetch_array($result))
        {
             $unsoldList[] = $row;
        }

    }
    mysql_close($conn);
?>
