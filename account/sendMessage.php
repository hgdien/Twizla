<?php
    
// process the script only if the form has been submitted
    if(isset($_POST['submitSendMessage']))
    {
        include("../mySQL_connection.inc.php");
        $senderID = $_POST['senderID'];
        $receiverID = $_POST['receiverID'];
        $receiverName = $_POST['receiverName'];
        $subject = $_POST['subject'];
        $mesgContent = $_POST['mesgContent'];

        $conn = dbConnect();

        if (!get_magic_quotes_gpc())
        {
            $mesgContent = addslashes($mesgContent);
            $subject = addslashes($subject);
        }

        
        //insert a new messgae to the DB
        $insertSQL = "INSERT INTO usermessage (Subject, Content, SenderID, ReceiverID, ProcessDate, Status, Flagged, Folder) VALUE ('$subject','$mesgContent', $senderID, $receiverID,'".date("Y-m-d H:i:s")."','unread',0,null)";

        mysql_query($insertSQL) or die(mysql_error());

        //get the receive detail
        $sql = "SELECT * FROM user WHERE UserID = $receiverID";

        $result = mysql_query($sql) or die(mysql_error());

        $receiver = mysql_fetch_array($result);
        mysql_close($conn);

        //send an email notification to the receiver
        $subject = "You have received a new Twizla message";

        //set verification message

        $content = "<html><head>
                      <title>Message Notification</title>
                    </head><body><a href='".$PROJECT_PATH."'><img src='".$PROJECT_PATH."webImages/logo.png' alt='Twizla Logo' style='border: 0;'/></a>
                    <br><br><br>
                    Dear ".$receiver['FirstName'].",<br>
                    You have received a new message from another Twizla member.<br>
                    Please <a href='".$PROJECT_PATH."'>login</a> to your Twizla account to check your Inbox for the new message.<br>
                    We look forward to seeing you around the site.<br><br>
                    Sincerely,<br>
                    <b>The Twizla Team</b></body></html>";
    //        echo $email;

        include_once '../sendEmail.inc.php';
        sendEmail($receiver['Email'], $subject, $content);

        $message = "Message sent successfully";
        header("HTTP/1.1 301 Moved Permanently");
        header("Location:".$PROJECT_PATH."account/viewUserProfilePage.php?UserName=".$receiverName."&contact=true&message=$message");
    }

?>
