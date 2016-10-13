<?php

        $userID = $_SESSION['userID'];
        $conn = dbConnect();

        //get the items that won by this user, excluded the ones in the delete record list
        $selectSQL = "SELECT * FROM item, sale, picturelink WHERE item.ItemID = sale.ItemID AND
                                                                    item.ItemID = picturelink.ItemID AND
                                                                    sale.BuyerID = $userID AND
                                                                    sale.ItemID NOT IN (SELECT itemID FROM deleterecord WHERE deleterecord.UserID = $userID AND Type='wonList')
                                                                GROUP BY sale.ItemID
                                                                ORDER BY sale.Paid ASC,sale.saleTime DESC";


        $result = mysql_query($selectSQL) or die(mysql_error());
        $wonAmount = mysql_num_rows($result);

            //get the items that bidding by this user
        $selectSQL = "SELECT * FROM item, bid, picturelink WHERE item.ItemID = bid.ItemID AND
                                                                item.ItemID = picturelink.ItemID AND
                                                                bid.bidderID = $userID AND
                                                                item.ItemID NOT IN (SELECT itemID FROM sale) AND
                                                                item.timeFinish > '".date("Y-m-d H:i:s",time())."'
                                                            GROUP BY bid.ItemID
                                                            ORDER BY bid.bidTime DESC";

        $result = mysql_query($selectSQL) or die(mysql_error());
        $bidAmount = mysql_num_rows($result);

        //select all items this user is selling
        $selectSQL = "SELECT * FROM item, picturelink WHERE item.ItemID = picturelink.ItemID AND
                                                            item.SellerID = $userID AND
                                                            timeFinish > '".date("Y-m-d H:i:s",time())."' AND
                                                            item.ItemID NOT IN (SELECT itemID FROM sale)
                                                        GROUP BY item.ItemID
                                                        ORDER BY item.listedDate DESC";

        $result = mysql_query($selectSQL) or die(mysql_error());
        $sellingAmount = mysql_num_rows($result);

        //select all item listed by user which is sold
        $selectSQL = "SELECT * FROM item, picturelink, sale WHERE item.ItemID = picturelink.ItemID AND
                                                            item.ItemID = sale.ItemID AND
                                                            item.SellerID = $userID
                                                        GROUP BY item.ItemID
                                                        ORDER BY sale.Paid ASC,sale.saleTime DESC";

//        echo $selectSQL;
        $result = mysql_query($selectSQL) or die(mysql_error());
        $soldAmount = mysql_num_rows($result);

        //select all item listed by user which is not won and finished( become unsold)
        $selectSQL = "SELECT * FROM item, picturelink WHERE item.ItemID = picturelink.ItemID AND
                                                            item.SellerID = $userID AND
                                                            item.Unsold = 1 AND
                                                            item.ItemID NOT IN (SELECT itemID FROM sale)
                                                        GROUP BY item.ItemID
                                                        ORDER BY item.listedDate DESC";

        $result = mysql_query($selectSQL) or die(mysql_error());
        $unsoldAmount = mysql_num_rows($result);

        //get number of pending emails
        $selectSQL = "SELECT * FROM usermessage WHERE ReceiverID = $userID AND
                                                            Status = 'unread'";

        $result = mysql_query($selectSQL) or die(mysql_error());
        $pendingMailAmount = mysql_num_rows($result);



        mysql_close($conn);
?>
