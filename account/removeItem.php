<?php

    include("../mySQL_connection.inc.php");
    $referer  = $_SERVER['HTTP_REFERER'];
    if(isset($_GET['ItemID']))
    {
        //delete one item
        removeItem($_GET['ItemID']);
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: $referer"); // go back to the page we came from
    }
    else if(isset($_GET['ItemIDList']))
    {
        //delete a list of item
        $ItemID = strtok($_GET['ItemIDList'],'|');
        removeItem($ItemID);

        while(is_string($ItemID))
        {
            $ItemID = strtok("|");
            if($ItemID)
            {
                removeItem($ItemID);
            }
        }
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: $referer"); // go back to the page we came from
    }
    else
    {
        header("HTTP/1.1 301 Moved Permanently");
        header('Location: '.$PROJECT_PATH.'index.php');
    }

    function removeItem($itemID)
    {

//        create connection and connect to the Twizla database
        $conn = dbConnect();

        //create the delete query to remove item record
        $deleteSQL = "DELETE FROM item WHERE ItemID = $itemID";
        mysql_query($deleteSQL) or die(mysql_error());
        // delete all pictures associate with it
        $deleteSQL = "DELETE FROM picturelink WHERE ItemID = $itemID";
        mysql_query($deleteSQL) or die(mysql_error());
        mysql_close($conn);

    }
?>