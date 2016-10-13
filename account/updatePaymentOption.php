<?php

    if(isset($_POST['submitUpdatePayment']))
    {
        include("../mySQL_connection.inc.php");
        $userID = $_POST['userID'];
        $paypalEmail = trim($_POST['paypalEmail']);
        $paymateEmail = trim($_POST['paymateEmail']);
        $accountHolder = $_POST['accountHolder'];
        $bankName = $_POST['bankName'];
        $BSB1 = trim($_POST['BSB1']);
        $BSB2 = trim($_POST['BSB2']);
        $accountNo = trim($_POST['accountNo']);
        $listing = $_POST['listing'];
        $message = "";

        //validate input information
        if($palpayEmail != "" AND !check_email_address($palpayEmail))
        {
            $message = "Invalid paypal email entered.";
        }
        else if($paymateEmail != "" AND !check_email_address($paymateEmail))
        {
            $message = "Invalid paymate email entered.";
        }
        else if($accountHolder != "")
        {
            if($bankName == "" || $BSB1 == "" || $BSB2 == "" || $accountNo == "")
            {
                $message = "Please fill in all bank detail information.".$bankName.$BSB1.$BSB2.$accountNo;
            }
            else if(!is_numeric($BSB1) || !is_numeric($BSB2) || !is_numeric($accountNo))
            {
                $message = "BSB and Account Number must be in numeric format.";
            }
            else if(strlen($BSB1) < 3 || strlen($BSB2) < 3)
            {
                $message = "BSB is invalid.";
            }
        }
        else if($accountHolder == "" AND ($bankName != "" OR $BSB1 != "" OR $BSB2 != "" OR $accountNo != "" ))
        {
            $message = "Please fill in all bank detail information.";
        }

//        echo $message;
        if($message == "")
        {
            $conn = dbConnect();
            $sql = "UPDATE userpayment SET PaypalEmail = '$paypalEmail', PaymateEmail = '$paymateEmail', AccountHolder= '$accountHolder',
            BankName= '$bankName' ";

            if($BSB1 != "")
            {
                $sql .= ",BSB1= '$BSB1' ";
            }

            if($BSB2 != "")
            {
                $sql .= ",BSB2= '$BSB2' ";
            }

            if($accountNo != "")
            {
                $sql .= ",AccountNo = '$accountNo' ";
            }

            $sql .= " WHERE UserID = $userID";

//            echo $sql;
            mysql_query($sql) or die(mysql_error());

            mysql_close($conn);

            $message = "Account Updated.";


        }

        if($listing == 'true')
        {
            header("HTTP/1.1 301 Moved Permanently");
            header("Location: ".$SECURE_PATH."account/myAccountPage.php?page=Account&listing=true&warning=".$message);
        }
        else
        {
            header("HTTP/1.1 301 Moved Permanently");
            header("Location: ".$SECURE_PATH."account/myAccountPage.php?page=Account&tab=3&warning=".$message);
        }


    }

    function check_email_address($email) {
      // First, we check that there's one @ symbol,
      // and that the lengths are right.
      if (!ereg("^[^@]{1,64}@[^@]{1,255}$", $email)) {
        // Email invalid because wrong number of characters
        // in one section or wrong number of @ symbols.
        return false;
      }
      // Split it into sections to make life easier
      $email_array = explode("@", $email);
      $local_array = explode(".", $email_array[0]);
      for ($i = 0; $i < sizeof($local_array); $i++) {
        if
    (!ereg("^(([A-Za-z0-9!#$%&'*+/=?^_`{|}~-][A-Za-z0-9!#$%&
    ?'*+/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$",
    $local_array[$i])) {
          return false;
        }
      }
      // Check if domain is IP. If not,
      // it should be valid domain name
      if (!ereg("^\[?[0-9\.]+\]?$", $email_array[1])) {
        $domain_array = explode(".", $email_array[1]);
        if (sizeof($domain_array) < 2) {
            return false; // Not enough parts to domain
        }
        for ($i = 0; $i < sizeof($domain_array); $i++) {
          if
    (!ereg("^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|
    ?([A-Za-z0-9]+))$",
    $domain_array[$i])) {
            return false;
          }
        }
      }
      return true;
    }
?>
