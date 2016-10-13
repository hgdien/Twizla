<?php

    $conn = dbConnect();
    $userID = $_SESSION['userID'];

    //remove any past current message
    unset ($_SESSION['currentMessage']);

    //delete sent messages that is older than 6 months
    //get the past date 3 months from now
    $SIX_MONTHS_TIMESTAMP = 30*3*24*60*60;
    $compareDate = date("Y-m-d", time() - $SIX_MONTHS_TIMESTAMP);
    $sql = "DELETE FROM usermessage WHERE usermessage.SenderID = ".$userID." AND ProcessDate <= '$compareDate'";

    mysql_query($sql) or die(mysql_error());


//
//
//    //get the list of message folders for this user
//    $selectSQL = "SELECT * FROM messagefoleder WHERE messagefoleder.UserID = ".$userID."
//                                                      ORDER BY messagefoleder.FolderName ASC";
//
//    $result = mysql_query($selectSQL) or die(mysql_error());
//
//    while($row = mysql_fetch_array($result))
//    {
//         $folderList[] = $row;
//    }
//
//    $_SESSION['$folderList'] = $folderList;

    //get the number of message unread for every message list
    //follow the order: 0 - Inbox | 1 - Sent | 2 - Flagged | 3 .... : Available folder
    $unreadAmountList = Array();

    $inboxSelectSQL ="SELECT * FROM usermessage, user WHERE usermessage.SenderID = user.UserID AND
                                                                usermessage.ReceiverID = ".$userID." AND
                                                                usermessage.Folder IS NULL
                                                              ORDER BY usermessage.ProcessDate DESC";

    $sentSelectSQL = "SELECT * FROM usermessage, user WHERE usermessage.ReceiverID = user.UserID AND
                                                                usermessage.SenderID = ".$userID."
                                                              ORDER BY usermessage.ProcessDate DESC";

    $flaggedSelectSQL = "SELECT * FROM usermessage, user WHERE usermessage.SenderID = user.UserID AND
                                                                usermessage.ReceiverID = ".$userID." AND
                                                                usermessage.Flagged = 1
                                                              ORDER BY usermessage.ProcessDate DESC";


    $result = mysql_query($inboxSelectSQL) or die(mysql_error());
    $unreadAmountList[0] = 0;
    while($row = mysql_fetch_array($result))
    {
         $inboxList[] = $row;
         if($row['Status'] == 'unread')
         {
             $unreadAmountList[0]++;
         }
    }

    $result = mysql_query($sentSelectSQL) or die(mysql_error());
    $unreadAmountList[1] = 0;
    while($row = mysql_fetch_array($result))
    {
         $sentList[] = $row;
         if($row['Status'] == 'unread')
         {
             $unreadAmountList[1]++;
         }
    }

    $result = mysql_query($flaggedSelectSQL) or die(mysql_error());
    $unreadAmountList[2] = 0;
    while($row = mysql_fetch_array($result))
    {
         $flaggedList[] = $row;
         if($row['Status'] == 'unread')
         {
             $unreadAmountList[2]++;
         }
    }

    //This is for the folder create by user, shall be integrate in the future????Maybe...
//    foreach($folderList as $folder)
//    {
//        $selectSQL = "SELECT * FROM usermessage, user WHERE usermessage.SenderID = user.UserID AND
//                                                            usermessage.ReceiverID = ".$userID." AND
//                                                            usermessage.Folder = ".$folder['FolderID']."
//                                                          ORDER BY usermessage.ProcessDate DESC";
//        $result = mysql_query($selectSQL) or die(mysql_error());
//        $countUnread = 0;
//        while($row = mysql_fetch_array($result))
//        {
//             if($row['Status'] == 'unread')
//             {
//                 $countUnread ++;
//             }
//        }
//        $unreadAmountList[] = $countUnread;
//    }
//
    $_SESSION['$unreadAmountList'] = $unreadAmountList;


    //the following codes process different type of message list based on the
    //messageType request by user.
    $messageType = $_GET['mesgType'];

    if($messageType != "")
    {
        
    //    $referer  = $_SERVER['HTTP_REFERER'];
        
        //set up the SQL query base on the type of list requested by the user
//        if($messageType == 'Inbox')
//        {
//            //get all message sent to this user
//            $_SESSION['messageList'] = $inboxList;
//        }
//        else if($messageType == "Sent")
//        {
//            //get all message sent by this user
//            $_SESSION['messageList'] = $sentList;
//        }
//        else if($messageType== "Flagged")
//        {
//            //get all message flagged by user
//            $_SESSION['messageList'] = $flaggedList;
//        }
//        else
//        {
//            //get all message belong to the specified folder
            $selectSQL = "SELECT * FROM usermessage, user WHERE usermessage.SenderID = user.UserID AND
                                                    usermessage.ReceiverID = ".$userID." AND
                                                    usermessage.Folder = ".$folder['FolderID']."
                                                  ORDER BY usermessage.ProcessDate DESC";

            $result = mysql_query($selectSQL) or die(mysql_error());
            while($row = mysql_fetch_array($result))
            {
                 $messageList[] = $row;

            }
//            $_SESSION['messageList'] = $messageList;
//        }    
    }

    //if there is a message ID sent by user, display the message
    if(isset($_GET['mesgID']))
    {
        //get the message detail
        $selectSQL = "SELECT * FROM usermessage, user WHERE usermessage.SenderID = user.UserID AND
                                                usermessage.MessageID = ".$_GET['mesgID']."
                                              ORDER BY usermessage.ProcessDate DESC";


        $result = mysql_query($selectSQL) or die(mysql_error());
        $_SESSION['currentMessage'] = mysql_fetch_array($result);


        //if the message is unread, set the status to read
        //does not apply for the sent message box
        if($_SESSION['currentMessage']['SenderID'] != $userID AND $_SESSION['currentMessage']['Status'] == 'unread')
        {
            $updateSQL = "UPDATE usermessage SET usermessage.Status = 'read' WHERE usermessage.MessageID =".$_GET['mesgID'];
            mysql_query($updateSQL) or die(mysql_error());
        }

    }

    mysql_close($conn);
?>
