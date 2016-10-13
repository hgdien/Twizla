<?php

    include("../mySQL_connection.inc.php");
    $conn = dbConnect();
    $itemID = substr($_GET['merchant_return_link'], 29);
    //update the paid status of the sale

    $sql = "UPDATE sale SET Paid = 1 WHERE ItemID = ".$itemID;

    mysql_query($sql) or die(mysql_error());

    mysql_close($conn);
    header("HTTP/1.1 301 Moved Permanently");
    header("Location: ".$PROJECT_PATH."account/myAccountPage.php?page=Buy&tab=3");


?>
