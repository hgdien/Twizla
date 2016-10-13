<?php

    include("../mySQL_connection.inc.php");
    $userID = $_POST['userID'];

    $firstName = trim($_POST['firstName']);
    $lastName = trim($_POST['lastName']);
//    $email = trim($_POST['reg_email']);
    $suburb = trim($_POST['suburb']);
    $state = trim($_POST['state']);
    $addressLine1 = $_POST['addressLine1'];
    $addressLine2 = $_POST['addressLine2'];
    $contactNumber = trim($_POST['contactNumber']);
    $postcode = trim($_POST['postcode']);

    if(isset($_POST['autoReList']))
    {
        $autoReList = true ;
    }
    else
    {
        $autoReList = false;
    }
    
    $isListing = $_POST['listing'];
    //check input information
    // initialize error message
    $message ="";
        $referer  = $_SERVER['HTTP_REFERER'];
    $conn = dbConnect();
//    var_dump($_POST['updatePassword']);

//    // check length of username
//    if (strlen($username) < 6 || strlen($username) > 25)
//    {
//        $message[] = 'Username must be between 6 and 25 characters';
//    }
//
//    // validate username
//    if (!ctype_alnum($username))
//    {
//    $message[] = 'Username must consist of alphanumeric characters with no spaces';
//    }
    //check both email and password input exist
    if(strlen($firstName) == 0 OR strlen($lastName) == 0)
    {
        $message ='Please fill in your name.';
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: ".$SECURE_PATH."account/personalinfo/1/warning=$message");
    }
    else
    {
        if($contactNumber != "" AND (!is_numeric($contactNumber) OR (strlen($contactNumber) < 8)))
        {
            $message = 'Invalid contact number.';
            header("HTTP/1.1 301 Moved Permanently");
            header("Location: ".$SECURE_PATH."account/personalinfo/1/warning=$message");
        }

        if($postcode != "" AND (!is_numeric($postcode) OR (strlen($postcode) < 4)))
        {
            $message = 'Invalid postcode.';
            header("HTTP/1.1 301 Moved Permanently");
            header("Location: ".$SECURE_PATH."account/personalinfo/1/warning=$message");
        }
  
        $updateSQL = "UPDATE user SET LastName = '$lastName', FirstName = '$firstName', Suburb_City = '$suburb', AddressLine1 = '$addressLine1', AddressLine2 = '$addressLine2' ";


        $updateSQL .= ", State_Country = (SELECT State_CountryID FROM state_country WHERE State_CountryName = '$state')";

        if($postcode != "")
        {
            $updateSQL .= ", Postcode = $postcode";
        }

        if($contactNumber != "")
        {
            $updateSQL .= ", ContactNumber = '$contactNumber' ";
        }

        $updateSQL .= " WHERE UserID = ".$userID;
//        echo $updateSQL;
        mysql_query($updateSQL) or die(mysql_error());
//            echo $updateSQL;

        //change the db depend on user setting to whether relist unsold items automatically or not
        if($autoReList)
        {
            $sql = "INSERT IGNORE INTO autoRelistList(UserID) VALUE ($userID)";

            mysql_query($sql) or die(mysql_error());

        }
        else
        {
            $sql = "DELETE FROM autoRelistList WHERE UserID = $userID";

            mysql_query($sql) or die(mysql_error());
        }
        
        //case the user update their password
        if($_POST['updatePassword'] == "true")
        {
            $pw = sha1($_POST['oldPw']);

            $newPw = $_POST['newPw'];
            $reTypePw = $_POST['reTypePw'];

            if($_POST['oldPw'] == "" OR $newPw == "" OR $reTypePw == "")
            {
                $message = "Please fill all the password fields.";
                header("HTTP/1.1 301 Moved Permanently");
                header("Location: ".$SECURE_PATH."account/personalinfo/1/updatePassword/warning=$message");
            }
            // check length of password
            else if (strlen($newPw) < 6 || preg_match('/\s/', $newPw)) {
                $message = 'Password must be at least 6 characters with no spaces';
                header("HTTP/1.1 301 Moved Permanently");
                header("Location: ".$SECURE_PATH."account/personalinfo/1/updatePassword/warning=$message");
            }
            else if($newPw != $reTypePw)
            {
                $message = "New password and Re-type new Password do not match.";
                header("HTTP/1.1 301 Moved Permanently");
                header("Location: ".$SECURE_PATH."account/personalinfo/1/updatePassword/warning=$message");
            }
            else
            {

                //oneway hashing the password for security protection
                $newPw = sha1($newPw);

                // check if the old/temporary password is correct
                $sql = "SELECT * FROM user WHERE user.Password = '".$pw."' AND UserID = $userID";
//                echo $sql;
                $result = mysql_query($sql) or die(mysql_error());
                $numRows = mysql_num_rows($result);
//                echo $pw." ".$numRows;
                if($numRows)
                {
                    $sql = "UPDATE user SET Password = '".$newPw."' WHERE UserID = $userID";
        //            echo $sql;
                    mysql_query($sql) or die(mysql_error());
                    $message = "Account updated.";
                    header("HTTP/1.1 301 Moved Permanently");
                    header("Location: ".$SECURE_PATH."account/personalinfo/1/warning=".$message);
                }
                else
                {
                    $message = "Incorrect current password input.";

                    if($isListing == 'true')
                    {
                        header("HTTP/1.1 301 Moved Permanently");
                        header("Location: ".$SECURE_PATH."account/personalinfo/1/updatePassword/listing/warning=$message");
                    }
                    else
                    {
                        header("HTTP/1.1 301 Moved Permanently");
                        header("Location: ".$SECURE_PATH."account/personalinfo/1/updatePassword/warning=$message");
                    }
                }
            }
        }
        else
        {
            $message = "Account updated.";
            if($isListing == 'true')
            {
                header("HTTP/1.1 301 Moved Permanently");
                header("Location: ".$SECURE_PATH."account/personalinfo/1/listing/warning=".$message);
            }
            else
            {
                header("HTTP/1.1 301 Moved Permanently");
                header("Location: ".$SECURE_PATH."account/personalinfo/1/warning=".$message);
            }
        }

        mysql_close($conn);

    }
    
?>
