<?php

    include("../mySQL_connection.inc.php");
    $itemID = $_GET['ItemID'];
    $userID = $_GET['UserID'];
    $referer  = $_SERVER['HTTP_REFERER'];

    $conn = dbConnect();
    if (!get_magic_quotes_gpc())
    {
        $itemID = addslashes($itemID);
        $userID = addslashes($userID);
    }

    $insertSQL = "INSERT INTO itemtag (ITEMID, USERID)
                    VALUES ($itemID, $userID)";

    mysql_query($insertSQL) or die(mysql_error());

    //delete any deleted taged record of this item

    $sql = "DELETE FROM deleterecord WHERE ItemID = $itemID AND UserID = $userID AND Type = 'tagList'";

    mysql_query($sql) or die(mysql_error());

    mysql_close($conn);

    //go back to the displayItemDetailPage
    header("HTTP/1.1 301 Moved Permanently");
    header("Location: $referer");


?>
