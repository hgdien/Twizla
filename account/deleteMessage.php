<?php
    include("../mySQL_connection.inc.php");
    
    $tab= $_POST['tab'];

    $conn = dbConnect();
    if(isset($_GET['MessageID']))
    {
        deleteMessage($_GET['MessageID']);
        header("HTTP/1.1 301 Moved Permanently");
        header("Location:".$PROJECT_PATH."account/myAccountPage.php?page=Mail&tab=$tab");
    }
    else
    {
        //delete all message
        if($_POST['deleteAll']  == 'true')
        {
            //copy messages into another table for future evidence to resolve cases
            $sql = "INSERT INTO messagedeleted (MessageID, Subject, Content, SenderID, ReceiverID, ProcessDate, Status, Flagged, Folder) SELECT * FROM usermessage
                                                                WHERE usermessage.ReceiverID = ".$_POST['userID']." AND
                                                                        usermessage.Folder IS NULL";
            mysql_query($sql) or die(mysql_error());

            //delete all inbox message
            $deleteSQL = "DELETE FROM usermessage WHERE usermessage.ReceiverID = ".$_POST['userID']." AND
                                                                usermessage.Folder IS NULL";
            mysql_query($deleteSQL) or die(mysql_error());
            header("HTTP/1.1 301 Moved Permanently");
            header("Location:".$PROJECT_PATH."account/myAccountPage.php?page=Mail&tab=$tab");
        }
        //delete selected message
        else
        {
//                var_dump($_POST["messageIDList"]);
            if(count($_POST["messageIDList"]) == 0)
            {
                $warning ='Please select a message to delete';
//                echo $warning;
                header("HTTP/1.1 301 Moved Permanently");
                header("Location:".$PROJECT_PATH."account/myAccountPage.php?page=Mail&tab=$tab&warning=$warning");
            }
            else
            {

                foreach ($_POST['messageIDList'] as $messageID)
                {
                    deleteMessage($messageID);
                }
                header("HTTP/1.1 301 Moved Permanently");
                header("Location:".$PROJECT_PATH."account/myAccountPage.php?page=Mail&tab=$tab");
            }
        }

    }

    function deleteMessage($messageID)
    {
        $conn = dbConnect();

        //copy messages into another table for future evidence to resolve cases
        $sql = "INSERT INTO messagedeleted (MessageID, Subject, Content, SenderID, ReceiverID, ProcessDate, Status, Flagged, Folder) SELECT * FROM usermessage
                    WHERE MessageID = $messageID";
        mysql_query($sql) or die(mysql_error());


        $deleteSQL = "DELETE FROM usermessage WHERE MessageID = $messageID";

        mysql_query($deleteSQL) or die(mysql_error());
    }
    mysql_close($conn);

    
?>
