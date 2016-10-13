<?php
// process the script only if the form has been submitted
if(isset($_POST['signUpSubmit']))
{
    include("../mySQL_connection.inc.php");
   
    //oneway hashing the password for security protection
    $pwd = sha1($_POST['reg_password']);
    
    $firstName = trim($_POST['firstName']);
    $lastName = trim($_POST['lastName']);
    $email = trim($_POST['reg_email']);
    $username = trim($_POST['username']);
    $state = trim($_POST['state']);
    $knowingSource = trim($_POST['source']);

    if($_POST['type'] != 'simple')
    {
        $friendEmail1 = trim($_POST['friendEmail1']);
        $friendEmail2 = trim($_POST['friendEmail2']);
        $friendEmail3 = trim($_POST['friendEmail3']);
    }
    
    // initialize error array
    $message = array();

    //check both email, username and password input, etc exist
    if(strlen($email) == 0 OR strlen($_POST['reg_password']) == 0 OR strlen($firstName) == 0 OR strlen($lastName) == 0 OR strlen($username) == 0)
    {
        $message[] ='Please input your name, email and password to sign up.';
    }
    else
    {
        // check length of username
        if (strlen($username) < 6 || strlen($username) > 25)
        {
            $message[] = "Username must be between 6 and 25 characters.";
        }

        // validate username
        if (!ctype_alnum($username))
        {
        $message[] = 'Username must consist of alphanumeric characters with no spaces.';
        }

        //validate email
        if(!check_email_address($email))
        {
            $message[] = 'Invalid Email Address.';
        }

        if($_POST['type'] != 'simple')
        {
            if(($friendEmail1 != "" AND!check_email_address($friendEmail1)) OR ($friendEmail2 !="" AND !check_email_address($friendEmail2))
                    OR ($friendEmail3 != "" AND !check_email_address($friendEmail3)))
            {
                $message[] = "Invalid Friend Email Address.";
            }
        }


        // check length of password
        if (strlen($_POST['reg_password']) < 6 || preg_match('/\s/', $_POST['reg_password']))
        {

            $message[] = 'Password must be at least 6 characters with no spaces';
        }
        else if(isset($_POST['state']) AND ($_POST['reg_password'] != $_POST['reType_reg_password'])) //check retype password if registering in details
        {
        
            $message[] = 'Password and Re-type Password do not match.';
        }
    //  // check that the confirm passwords match
    //  if ($pwd != $_POST['conf_pwd']) {
    //    $message[] = 'Your passwords don\'t match';
    //	}
    // if no errors so far, check for duplicate email
    }
             // connect to database
        $conn = dbConnect();
        if (!get_magic_quotes_gpc())
        {
            $email = addslashes($email);
            $pwd = addslashes($pwd);
            $firstName = addslashes($firstName);
            $lastName = addslashes($lastName);
            $username = addslashes($username);

        }

        // check for duplicate password
        $checkDuplicate = "SELECT UserID FROM user
                           WHERE UserName = '$username'";

        $result = mysql_query($checkDuplicate) or die(mysql_error());
        $numRows = mysql_num_rows($result);

        // if $numRows is positive, the email is already in use
        if ($numRows)
        {
            $message[] = "User name is already in use. Please choose another user name.";
        }

        // check for duplicate email
        $checkDuplicate = "SELECT UserID FROM user
                           WHERE Email = '$email'";

        $result = mysql_query($checkDuplicate) or die(mysql_error());
        $numRows = mysql_num_rows($result);

        // if $numRows is positive, the email is already in use
        if ($numRows)
        {
            $message[] = "$email is already in use. Please choose another email.";
        }

        if (count($message) == 0)
        {


              // insert details into database
              $insertQuery = "INSERT INTO user (LastName, FirstName,Email,Password,Suburb_City,KnowingSource, AddressLine1, State_Country,Postcode,ContactNumber, AddressLine2, feedbackPoint, registerDate, verifyStatus, UserName)
                                VALUES ('$lastName','$firstName','$email','$pwd', null,'$knowingSource',null,(SELECT State_CountryName FROM state_country WHERE State_CountryName = '$state'),null,null,null, 0, '".date("Y-m-d")."', 'no', '$username')";

              $result = mysql_query($insertQuery) or die(mysql_error());

              //get the userID of the new User
              $userID = mysql_insert_id();

              //insert a new record of user payment options into database
              $insertQuery = "INSERT INTO userpayment (UserID, PaypalEmail, PaymateEmail, AccountHolder, BankName, BSB1, BSB2, AccountNo)
                                VALUES ($userID, null, null, null, null, null, null, null)";

              $result = mysql_query($insertQuery) or die(mysql_error());

            //set user setting to relist unsold items automatically for now

                $sql = "INSERT IGNORE INTO autoRelistList(UserID) VALUE ($userID)";

                mysql_query($sql) or die(mysql_error());
                
              if ($result)
              {
                  //sent a welcome message to the user inbox
                  //the UserID '0' is reserved for Twizla Team, thus any message from Twizla shall be marked with senderID 0

                  $welcomeMail = "Congratulations! You\'re now an Twizla member<br/>
                                    Hi ".$firstName.",<br/>
                                    Congrats on becoming an Twizla member. We\'re glad you\'ve decided to join all of us.<br/>
                                    Ready to start shopping?<br/>

                                    By joining Twizla you\'ve changed the way you\'re going to shop forever. Shopping on Twizla is exciting. Here\'s how it works:<br/>
                                    <b>1. Find</b><br/>
                                    &nbsp;&nbsp;&nbsp;Search for an item with the search bar.<br/>
                                    <b>2. Buy</b><br/>
                                    &nbsp;&nbsp;&nbsp;Place a bid or use \"Buy It Now\".<br/>
                                    <b>Place a bid</b>
                                    &nbsp;&nbsp;&nbsp;For auction-format items, enter the amount you want to spend; Twizla bids for you, up to the limit you set.<br/>
                                    <b>Buy it now</b><br/>
                                    &nbsp;&nbsp;&nbsp;You don\'t have to wait for the auction to end - you can puchase your item instantly.<br/>
                                    3. Pay<br/>
                                    &nbsp;&nbsp;&nbsp;Once you\'ve won, pay the seller.<br/>
                                    <b>Pay for your item</b><br/>
                                    You\'ll receive an email from Twizla explaining how to contact and pay the seller. <a href='".$PROJECT_PATH."help/12/3500'>Click here</a> to learn more about payment options.<br/>
                                    <b>Get your item</b><br/>
                                    &nbsp;&nbsp;&nbsp;After the seller receives your payment, the item is sent to you. It\'s that easy!<br/>
                                    <br/>
                                    All this without ever leaving your house! Do be careful. Shopping on Twizla is highly addictive.";
                  $welcomeMail = addslashes($welcomeMail);
                $insertSQL = "INSERT INTO usermessage (Subject, Content, SenderID, ReceiverID, ProcessDate, Status, Flagged, Folder) VALUE ('Welcome to Twizla!','".$welcomeMail."', 0, $userID,'".date("Y-m-d H:i:s")."','unread',0,null)";
                
                mysql_query($insertSQL) or die(mysql_error());

                mysql_close($conn);
                
                //sent invitation emails to friends if exist
                if($friendEmail1 != "" OR $friendEmail2 != "" OR $friendEmail3 != "")
                {

                    $subject = "Your friend $firstName has invite you to become a Twizla member";
                    $content = "<html><head>
                                  <title>Invitation Email</title>
                                </head><body><a href='".$PROJECT_PATH."'><img src='".$PROJECT_PATH."webImages/logo.png' alt='Twizla Logo' style='border: 0;'/></a>
                                <br><br><br>
                                Good day,<br>
                                You has been invited by your friend $firstName $lastName (Email: $email) to become a Twizla member.
                                Twizla Online Auction is a place where buying and selling are made fast and easy.
                                You can register in less than 15 seconds and start your first 30 seconds listing now, IT'S FREE.<br>
                                Buyers can find all kind of products with simple and descriptive information, ready to be won. Twizla will let you taste the joy of buying, selling and online auction in a new experience - Quick and Simple.
                                <br>
                                Visit us <a href='".$PROJECT_PATH."'>now</a>. We look forward to seeing you around the site.<br><br>
                                Sincerely,<br>
                                <b>The Twizla Team</b></body></html>";

                    include_once '../sendEmail.inc.php';
                    if($friendEmail1 != "")
                    {
                        
                        sendEmail($friendEmail1, $subject, $content);

                    }
                    if($friendEmail2 != "")
                    {

                        sendEmail($friendEmail2, $subject, $content);

                    }
                    if($friendEmail3 != "")
                    {

                        sendEmail($friendEmail3, $subject, $content);

                    }



                }
                
                header("HTTP/1.1 301 Moved Permanently");
                header("Location: ".$SECURE_PATH."registration/$firstName $lastName/$email/");

              }
              else
              {
                $warning = "There was a problem creating an account for $email";
                if($_POST['type'] == 'simple')
                {
                    header("HTTP/1.1 301 Moved Permanently");
                    header("Location: ".$PROJECT_PATH."index.php?message=$warning");
                }
                else
                {
                    header("HTTP/1.1 301 Moved Permanently");
                    header("Location: ".$SECURE_PATH."registration/$warning");
                }

              }
        }
        else
        {
            $messageString ="";
            foreach($message as $text)
            {
                $messageString .= $text."|";
            }

            //Get the type of signup - Simple or Full Registration
            //to direct to either index page or registration page
            if($_POST['type'] == 'simple')
            {
                header("HTTP/1.1 301 Moved Permanently");
                header("Location: ".$PROJECT_PATH."index.php?message=$messageString&username=".$_POST['username']."&firstName=".
                        $_POST['firstName']."&lastName=".$_POST['lastName']."&email=".$_POST['reg_email']."&friendEmail1=".$_POST['friendEmail1']."
                            &friendEmail2=".$_POST['friendEmail2']."&friendEmail3=".$_POST['friendEmail3']);
            }
            else
            {
                header("HTTP/1.1 301 Moved Permanently");

                header("Location: ".$SECURE_PATH."account/registrationPage.php?message=$messageString&username=".$_POST['username']."&firstName=".
                    $_POST['firstName']."&lastName=".$_POST['lastName']."&email=".$_POST['reg_email']."&friendEmail1=".$_POST['friendEmail1']."
                        &friendEmail2=".$_POST['friendEmail2']."&friendEmail3=".$_POST['friendEmail3']);


            }
//            var_dump($messageString);
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
