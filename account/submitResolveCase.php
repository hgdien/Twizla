<?php
    
// process the script only if the form has been submitted

    if(isset($_POST['resolveSubmit']))
    {
        //include the functions to connect to database
        include("../mySQL_connection.inc.php");
        $type = $_POST['type'];
        $itemID = $_POST['itemNumberInput'];
        $caseDesc = $_POST['caseDesc'];
        $userID = $_POST['userID'];

        if (!get_magic_quotes_gpc())
        {
            $reporter = addslashes($reporter);
            $itemID = addslashes($itemID);
            $caseDesc = addslashes($caseDesc);
        }
        $conn = dbConnect();

        // prepare the query for adding the new report case to the db
        $insertSQL = "INSERT INTO reportcase (Type, ItemID, Description, UserID, ReportDate)
                         VALUE ('$type', $itemID, '$caseDesc', $userID, '".date("Y-m-d")."')";
//            $message[] = $insertSQL;
//            echo $insertSQL;
        mysql_query($insertSQL) or die(mysql_error());

        //add a message with sender is current user and receiver is twizla to the db

        $mailContent = "Report item number: ".$itemID."<br/><br/>".$caseDesc;

        $insertSQL = "INSERT INTO usermessage (Subject, Content, SenderID, ReceiverID, ProcessDate, Status, Flagged, Folder) VALUE ('Problem report!','".$mailContent."',$userID,  0,'".date("Y-m-d H:i:s")."','read',0,null)";

        mysql_query($insertSQL) or die(mysql_error());

        mysql_close($conn);

        $message = "Reported case submitted. Please be patient and wait for our reply in the next several days.";
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: ".$SECURE_PATH."account/myAccountPage.php?page=Account&tab=4&resolveWarning=$message");
    }
//    else
//    {
//        header("HTTP/1.1 301 Moved Permanently");
//        header("Location: ".$PROJECT_PATH."index.php");
//    }
?>
