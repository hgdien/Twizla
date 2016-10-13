<?php

// process the script only if the form has been submitted
    if(isset($_POST['submitFeedBack']))
    {
        include("../mySQL_connection.inc.php");
        $rating = $_POST['rating'];
        $feedbackID = $_POST['feedbackID'];
        $reason = $_POST['reason'];
        $type = $_POST['feedbackType'];
        $dealingUser = $_POST['dealingUser'];

        $conn = dbConnect();

        if (!get_magic_quotes_gpc())
        {
            $reason = addslashes($reason);

        }

        //update the feedback of the item depend on the type
        if($type == 'buyer')
        {
            $updateSQL = "UPDATE feedback SET buyerRating = $rating, buyerComment = '$reason', buyerFeedbackDate = '".date('Y-m-d')."' WHERE FeedbackID = $feedbackID";
        }
        else
        {
            $updateSQL = "UPDATE feedback SET sellerRating = $rating, sellerComment = '$reason', sellerFeedbackDate = '".date('Y-m-d')."' WHERE FeedbackID = $feedbackID";
        }
        mysql_query($updateSQL) or die(mysql_error());


        //update the user feedbackPoint
        $selectSQL = "SELECT FeedbackPoint FROM user WHERE UserID = $dealingUser";
//        echo $selectSQL;
        $result = mysql_query($selectSQL) or die(mysql_error());
        $row = mysql_fetch_array($result);

        $newPoint = $row['FeedbackPoint'] + $rating;

        $updateSQL = "UPDATE user SET FeedbackPoint = $newPoint WHERE UserID = $dealingUser";
        mysql_query($updateSQL) or die(mysql_error());


        mysql_close($conn);
        header("HTTP/1.1 301 Moved Permanently");
        header("Location:".$SECURE_PATH."account/myAccountPage.php?page=Account&tab=2");
    }

?>
