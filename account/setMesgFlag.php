<?php
    //only process if there is a messageID provided
    if(isset($_GET['mesgID']))
    {
        include("../mySQL_connection.inc.php");


        $conn = dbConnect();

        $updateSQL = "UPDATE usermessage SET Flagged = ".$_GET['flagStatus']." WHERE MessageID =".$_GET['mesgID'];

        mysql_query($updateSQL) or die(mysql_error());
    }

?>
