<?php

    if(isset($_POST['submitUpdatePassword']))
    {
        include("../mySQL_connection.inc.php");
        //process either temp password or old password
//        var_dump($_POST);

        $pw = $_POST['pw'];  
        $newPw = $_POST['newPw'];
        $reTypePw = $_POST['reTypePw'];
        $email = $_POST['email'];

        $message = "";

        if($pw == "" OR $newPw == "" OR $reTypePw == "")
        {
            $message = "Please fill all the fields.";
            header("HTTP/1.1 301 Moved Permanently");
            header("Location: ".$PROJECT_PATH."account/forgotPasswordPage.php?updatePassword=1&message=$message");
        }
        // check length of password
        else if (strlen($newPw) < 6 || preg_match('/\s/', $newPw)) {
            $message = 'Password must be at least 6 characters with no spaces';
            header("HTTP/1.1 301 Moved Permanently");
            header("Location: ".$PROJECT_PATH."account/forgotPasswordPage.php?updatePassword=1&pw=".$pw."&message=$message");
        }
        else if($newPw != $reTypePw)
        {
            $message = "New password and Re-type new Password do not match.";
            header("HTTP/1.1 301 Moved Permanently");
            header("Location: ".$PROJECT_PATH."account/forgotPasswordPage.php?updatePassword=1&pw=".$pw."&message=$message");
        }
        else
        {
            // create connection and connect to the Twizla database
            $conn = dbConnect();

            //oneway hashing the password for security protection
            $newPw = sha1($newPw);

            // check if the old/temporary password is correct
            $sql = "SELECT * FROM user WHERE user.Password = '".$pw."' AND Email = '$email'";
//            echo $email;
            $result = mysql_query($sql) or die(mysql_error());
            $numRows = mysql_num_rows($result);

            if($numRows)
            {
                $sql = "UPDATE user SET Password = '".$newPw."' WHERE user.Password = '".$pw."' AND Email = '$email'";
    //            echo $sql;
                $result = mysql_query($sql) or die(mysql_error());

                $message = "Your account password has been updated.";
                header("HTTP/1.1 301 Moved Permanently");
                header("Location: ".$PROJECT_PATH."account/forgotPasswordPage.php?updatePassword=1&message=$message");
            }
            else
            {
                $message = "Incorrect temporary password inputted.";
                header("HTTP/1.1 301 Moved Permanently");
                header("Location: ".$PROJECT_PATH."account/forgotPasswordPage.php?updatePassword=1&message=$message");
            }

            mysql_close($conn);
        }
    }

?>
