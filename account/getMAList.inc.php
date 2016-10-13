<?php

    $conn = dbConnect();
    //get all item that have been won or sold with this user as buyer for the last month
    $ONE_MONTHS_TIMESTAMP = 30*24*60*60;
    $oneMonthPreviousDate = date("Y-m-d H:i:s", time() - $ONE_MONTHS_TIMESTAMP);
    $selectSQL = "SELECT * FROM item, picturelink, sale, user WHERE item.ItemID = sale.ItemID AND
                                                                item.ItemID = picturelink.ItemID AND
                                                                item.SellerID = user.UserID AND
                                                                sale.BuyerID = ".$_SESSION['userID']." AND
                                                                sale.SaleTime > '".$oneMonthPreviousDate."'
                                                            GROUP BY item.ItemID
                                                            ORDER BY sale.SaleTime DESC";
//    echo $selectSQL;
    $result = mysql_query($selectSQL) or die(mysql_error());
    while($row = mysql_fetch_array($result))
    {
         $buyerItemList[] = $row;
    }


    //get all item that have been won or sold with this user as seller for the last month
    $selectSQL = "SELECT * FROM item, picturelink, sale, user  WHERE item.ItemID = sale.ItemID AND
                                                                item.ItemID = picturelink.ItemID AND
                                                                sale.BuyerID = user.UserID AND
                                                                item.SellerID = ".$_SESSION['userID']." AND
                                                                sale.SaleTime > '".$oneMonthPreviousDate."'
                                                            GROUP BY item.ItemID
                                                            ORDER BY sale.SaleTime DESC";

    $result = mysql_query($selectSQL) or die(mysql_error());
    while($row = mysql_fetch_array($result))
    {
         $sellerItemList[] = $row;
    }
    


    //get all items that awaiting feedback
        $waitFeedBackList = array();
        //item that current user bought
        $selectSQL = "SELECT * FROM item, picturelink, sale, feedback, user WHERE item.ItemID = sale.ItemID AND
                                                                    item.ItemID = picturelink.ItemID AND
                                                                    item.SellerID = user.UserID AND
                                                                    sale.BuyerID = ".$_SESSION['userID']." AND
                                                                    sale.SaleID = feedback.SaleID AND
                                                                    feedback.buyerRating IS NULL
                                                                GROUP BY item.ItemID
                                                                ORDER BY sale.SaleTime DESC";
    //    echo $selectSQL;
        $result = mysql_query($selectSQL) or die(mysql_error());
        while($row = mysql_fetch_array($result))
        {
             $waitFeedBackList[] = $row;
        }

        //item that current user sold
        $selectSQL = "SELECT * FROM item, picturelink, sale, feedback, user WHERE item.ItemID = sale.ItemID AND
                                                                    sale.BuyerID = user.UserID AND
                                                                    item.ItemID = picturelink.ItemID AND
                                                                    item.SellerID = ".$_SESSION['userID']." AND
                                                                    sale.SaleID = feedback.SaleID AND
                                                                    feedback.sellerRating IS NULL
                                                                GROUP BY item.ItemID
                                                                ORDER BY sale.SaleTime DESC";
    //    echo $selectSQL;
        $result = mysql_query($selectSQL) or die(mysql_error());
        while($row = mysql_fetch_array($result))
        {
             $waitFeedBackList[] = $row;
        }

        usort($waitFeedBackList, "cmp_date") ;

    //get all recent feedbacks to user items
        $ONE_WEEK_TIMESTAMP = 7*24*60*60;
        $oneWeekPreviousDate = date("Y-m-d", time() - $ONE_WEEK_TIMESTAMP);
        $recentBuyerFeedbackList = array();
        $recentSellerFeedbackList = array();
        //feedbacks from buyers
        $selectSQL = "SELECT * FROM feedback, sale, item, user WHERE feedback.SaleID = sale.SaleID AND
                                                                    item.ItemID = sale.ItemID AND
                                                                    item.SellerID = ".$_SESSION['userID']." AND
                                                                    sale.BuyerID = user.UserID AND
                                                                    feedback.buyerFeedbackDate > ".$oneWeekPreviousDate."
                                                                GROUP BY feedback.FeedbackID
                                                                ORDER BY feedback.buyerFeedbackDate DESC";

        $result = mysql_query($selectSQL) or die(mysql_error());
        while($row = mysql_fetch_array($result))
        {
             $recentBuyerFeedbackList[] = $row;
        }


        //feedbacks from sellers
        $selectSQL = "SELECT * FROM feedback, sale, item, user WHERE feedback.SaleID = sale.SaleID AND
                                                                    item.ItemID = sale.ItemID AND
                                                                    sale.BuyerID = ".$_SESSION['userID']." AND
                                                                    item.SellerID = user.UserID AND
                                                                    feedback.sellerFeedbackDate > ".$oneWeekPreviousDate."
                                                                GROUP BY feedback.FeedbackID
                                                                ORDER BY feedback.sellerFeedbackDate DESC";

        $result = mysql_query($selectSQL) or die(mysql_error());
        while($row = mysql_fetch_array($result))
        {
             $recentSellerFeedbackList[] = $row;
        }
        //total feedback list
            //merge all feedback , then sort the list by feedback date
            $recentFeedbackList = array_merge($recentBuyerFeedbackList, $recentSellerFeedbackList);

            //function to compare feedbackdate
            usort($recentFeedbackList, "cmp_date") ;




        //if there is a itemID submit for feedback, get the item information

        if(isset($_GET['feedBackItemID']))
        {
            $selectSQL = "SELECT * FROM item, picturelink, feedback, sale WHERE item.ItemID = picturelink.ItemID AND
                                                                        feedback.SaleID = sale.SaleID AND
                                                                        sale.ItemID = item.ItemID AND
                                                                    item.ItemID = ".$_GET['feedBackItemID']." GROUP BY item.ItemID";

//            echo $selectSQL;
            $result = mysql_query($selectSQL) or die(mysql_error());

             $currentFeedBackItem = mysql_fetch_array($result);

        }

        mysql_close($conn);

        function cmp_date( $a, $b )
        {
            //compare the type of feedback date based on the user is a seller or buyer
            if( $a['SellerID'] == $_SESSION['userID'])
            {
                $a_date = strtotime($a['buyerFeedbackDate']) ;

            }
            else
            {
                $a_date = strtotime($a['sellerFeedbackDate']) ;
            }

            if( $b['SellerID'] == $_SESSION['userID'])
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
?>
