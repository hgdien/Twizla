<?php

    function getCurrentBid($itemID)
    {
        $conn = dbConnect();
        //get the list of bids for this item
        $selectSQL = "SELECT * FROM bid, user WHERE bid.BidderID = user.UserID AND
                                                    bid.ItemID = ".$itemID."
                                                ORDER BY bid.bidAmount DESC";

//        echo $selectSQL;
        $result = mysql_query($selectSQL) or die(mysql_error());
        while($row = mysql_fetch_array($result))
        {
             $bidList[] = $row;
        }

        $selectSQL = "SELECT * FROM item WHERE ItemID = $itemID";

        $result = mysql_query($selectSQL) or die(mysql_error());
        $item = mysql_fetch_array($result);

        mysql_close($conn);
        
        if($item['numberOfBid'] < 2)
        {
            $currentBid = $item['startingBid'];

        }
        else
        {
            //get the increaseBid for user by get the second maximum bid
            //and plus it with the incremental amount
            $increaseBid = $bidList[1]['BidAmount'] + getIncrement($bidList[1]['BidAmount']);
            //compare the increaseBid and the maximum bid and display the lower one as the currentBid
            if($increaseBid < $bidList[0]['BidAmount'])
            {
                $currentBid = $increaseBid;
            }
            else
            {
                $currentBid = $bidList[0]['BidAmount'];
            }
        }



        
        return $currentBid;
    }

    //this function return minimum amount of inscrease money for a valid bidding
    //base on amount of the current bid.
    function getIncrement($currentPrice)
    {

        $conn = dbConnect();
        $sql = "SELECT * FROM bidincrements";

        $result = mysql_query($sql) or die(mysql_error());

        $increment = 0;
        while($row = mysql_fetch_array($result))
        {
             if($currentPrice >= $row['MinValue'] AND $currentPrice <= $row['MaxValue'])
             {
                $increment = $row['IncrementValue'];
             }
        }

        mysql_close($conn);
        return $increment;
    }

    function isBiddingOnItem($itemID, $userID)
    {
        $conn = dbConnect();
        $sql = "SELECT * FROM bid WHERE ItemID = ".$itemID." AND BidderID = ".$userID;
        $result = mysql_query($sql) or die(mysql_error());

        mysql_close($conn);

        if(mysql_num_rows($result) > 0)
        {
            return true;
        }
        else
        {
            return false;
        }
        
    }

       //check if a bid have been placed on this item, this is for remove the buy now
       //option after the auction has started
    function hasBid($itemID)
    {
        $conn = dbConnect();
       $selectSQL = "SELECT * FROM bid
                           WHERE ItemID =".$itemID;

        $result = mysql_query($selectSQL) or die(mysql_error());
        $numRows = mysql_num_rows($result);

        mysql_close($conn);
        if ($numRows)
        {
            return true;
        }
        else
        {
            return false;
        }
    }


    function isMaxBidder($itemID, $userID)
    {
        $conn = dbConnect();
        $sql = "SELECT * FROM bid WHERE BidAmount IN (SELECT MAX(BidAmount) FROM bid WHERE ItemID = ".$itemID.") AND ItemID = ".$itemID." ORDER BY bidTime ASC";
        $result = mysql_query($sql) or die(mysql_error());
        while($row = mysql_fetch_array($result))
        {
            $bidList[] = $row;
        }

        $maxBid = $bidList[0];
        mysql_close();

        if($maxBid["BidderID"] != $userID)
        {
            return false;
        }
        else
        {
            return true;
        }
    }

    function getMaxBid($itemID)
    {
        $conn = dbConnect();
        $sql = "SELECT Max(BidAmount) FROM bid WHERE ItemID = ".$itemID;

        $result = mysql_query($sql) or die(mysql_error());
        $row = mysql_fetch_array($result);

        mysql_close();

        return $row[0];
    }
?>
