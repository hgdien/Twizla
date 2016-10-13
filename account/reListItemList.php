<?php

    include("../mySQL_connection.inc.php");
    $referer  = $_SERVER['HTTP_REFERER'];
    if(isset($_GET['ItemIDList']))
    {
        //delete a list of item
        $ItemID = strtok($_GET['ItemIDList'],'|');
        reListItem($ItemID);

        while(is_string($ItemID))
        {
            $ItemID = strtok("|");
            if($ItemID)
            {
                reListItem($ItemID);
            }
        }
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: ".$PROJECT_PATH.'account/myAccountPage.php?page=Sell&tab=3'); // go back to the page we came from
    }
    else
    {
        header("HTTP/1.1 301 Moved Permanently");
        header('Location: '.$PROJECT_PATH.'index.php');
    }

    function reListItem($itemID)
    {

//        create connection and connect to the Twizla database
        $conn = dbConnect();

        //get the listDuration of the item
        $selectSQL = "SELECT listDuration FROM item WHERE ItemID = $itemID";
        $result = mysql_query($selectSQL) or die(mysql_error());
        $row = mysql_fetch_array($result);
        $listDuration = $row['listDuration'];

        $newListedDate = date("Y-m-d H:i:s");
        $A_DAY_TIMESTAMP = 24*60*60;
        $newTimeFinish = date("Y-m-d H:i:s", (strtotime($newListedDate) + $listDuration * $A_DAY_TIMESTAMP));
        //create the delete query to remove item record
        $updateSQL = "UPDATE item SET  listedDate = '$newListedDate', timeFinish = '$newTimeFinish', Unsold = 0 WHERE ItemID = $itemID";
        mysql_query($updateSQL) or die(mysql_error());
        mysql_close($conn);

    }

?>
