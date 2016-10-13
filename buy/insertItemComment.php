<?php
    include("../mySQL_connection.inc.php");
    $conn = dbConnect();
    //if have comment insert, insert new comment
    if(isset($_POST['submitComment']))
    {
        $sql = "INSERT INTO comment(ItemID, UserID, Comment, Time)
            VALUE (".$_POST['ItemID'].", ".$_POST['UserID'].", '".$_POST['comment']."', '".date("Y-m-d H:i:s", time())."')";

        mysql_query($sql) or die(mysql_error());


    }
    mysql_close($conn);
    header("HTTP/1.1 301 Moved Permanently");
    header("Location:"."displayItemDetailPage.php?ItemID=".$_POST['ItemID']."&ItemName=".str_replace(" ",'-',$_POST['ItemName'])."&commentInserted=true");

?>
