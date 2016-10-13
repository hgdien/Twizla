<?php

    if(isset($_POST['submitSendPassword']))
    {

        include("../mySQL_connection.inc.php");

        $email = $_POST['email'];

        $message = "";

        if($email == "")
        {
            $message = "--> Please enter an email address.";
            header("HTTP/1.1 301 Moved Permanently");
            header("Location: ".$PROJECT_PATH."account/forgotPasswordPage.php?email=$email&message=$message");
        }
        else if(!check_email_address($email))
        {
            $message = "Invalid email address entered.";
            header("HTTP/1.1 301 Moved Permanently");
            header("Location: ".$PROJECT_PATH."account/forgotPasswordPage.php?email=$email&message=$message");
        }
        else
        {
            // create connection and connect to the Twizla database
            $conn = dbConnect();

            // get the list of category from database
            $sql = "SELECT * FROM user WHERE user.Email = '$email'";

            $result = mysql_query($sql) or die(mysql_error());
            $numRows = mysql_num_rows($result);

            if($numRows == 0)
            {
                $message = "--> There are no existing Twizla member with this registration email.";
                header("HTTP/1.1 301 Moved Permanently");
                header("Location: ".$PROJECT_PATH."account/forgotPasswordPage.php?email=$email&message=$message");
            }
            else
            {
                $row = mysql_fetch_array($result);
                $user = $row['FirstName'];

                $subject = "Twizla Account Information Notify";

                //set verification message

                $content = "<a href='".$PROJECT_PATH."'><img src='".$PROJECT_PATH."webImages/logo.png' alt='Twizla Logo' style='border: 0;'/></a>
                            <br><br><br>
                            Dear $user,<br>
                            This email is sent by <b>Twizla</b> according to your request. The following lines contains a temporary password and link that allow you to log in and change your Twizlla password:<br><br>
                            UserName: ".$row['UserName']."
                            Full Name: ".$row['FirstName']." ".$row['LastName']."<br>
                            Email: $email<br>
                            Temporary Password: ".$row['Password']."<br>
                            Link: ".$PROJECT_PATH."forgotPasswordPage.php?updatePassword=1&email=$email<br>
                            We shall looking forward to seeing you around the site.<br><br>
                            Sincerely,<br>
                            <b>The Twizla Team</b> ";
            //        echo $email;



                include_once 'sendEmail.inc.php';
                sendEmail($email, $subject, $content);

                $message = "--> An email has been sent to the address you specified.<br/>Please check your inbox in a few minutes.";
                header("HTTP/1.1 301 Moved Permanently");
                header("Location: ".$PROJECT_PATH."account/forgotPasswordPage.php?message=".urlencode($message));
            }

            mysql_close($conn);
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
