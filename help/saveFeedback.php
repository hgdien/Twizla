<?php

    if(isset($_POST['submitFeedback']))
    {
       //include the functions to connect to database
        include("../mySQL_connection.inc.php");
        $userID = $_POST['userID'];
        $likeFeedback = $_POST['likeFeedback'];
        $dislikeFeedback = $_POST['dislikeFeedback'];
        $bugFeedback = $_POST['bugFeedback'];

        if (!get_magic_quotes_gpc())
        {
            $likeFeedback = addslashes($likeFeedback);
            $dislikeFeedback = addslashes($dislikeFeedback);
            $bugFeedback = addslashes($bugFeedback);
        }

        //check the user input

        if($likeFeedback == "" AND $dislikeFeedback == "" AND $bugFeedback == "")
        {
            $message = "--> Please give your feedback before submit.";
            header("HTTP/1.1 301 Moved Permanently");
            header("Location: ".$PROJECT_PATH."help/feedbackPage.php?message=$message");
        }
        else
        {
            $conn = dbConnect();

            // prepare the query for adding the new report case to the db
            $insertSQL = "INSERT INTO userfeedback (`UserID`, `Like`, `Dislike`, `Bug`, `FeedbackDate`) VALUES
                             ($userID, '$likeFeedback','$dislikeFeedback', '$bugFeedback', '".date("Y-m-d")."')";
    //            $message[] = $insertSQL;
//                echo $insertSQL;
            mysql_query($insertSQL) or die(mysql_error());

            //add a message with sender is current user and receiver is twizla to the db

            $mailContent = "Report item number: ".$itemID."<br/><br/>".$caseDesc;

            $insertSQL = "INSERT INTO usermessage (Subject, Content, SenderID, ReceiverID, ProcessDate, Status, Flagged, Folder) VALUE ('Problem report!','".$mailContent."',$userID,  0,'".date("Y-m-d H:i:s")."','read',0,null)";

            mysql_query($insertSQL) or die(mysql_error());

            mysql_close($conn);

            $message = "--> Your feedbacks have been recorded.<br>Thank you for your time.";
            header("HTTP/1.1 301 Moved Permanently");
            header("Location: ".$PROJECT_PATH."help/feedbackPage.php?submit=true&message=$message");
        }

        
    }

?>
