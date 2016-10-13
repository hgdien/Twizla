<?php

    if(isset($_POST['submitContact']))
    {
       //include the functions to connect to database
        include("../mySQL_connection.inc.php");
        $name = $_POST['contact_name'];
        $email = $_POST['contact_email'];
        $contact_message = $_POST['contact_message'];

        if (!get_magic_quotes_gpc())
        {
            $name = addslashes($name);
            $email = addslashes($email);
            $contact_message = addslashes($contact_message);
        }

          include("../captcha/securimage.php");
          $img = new Securimage();
          $valid = $img->check($_POST['code']);


        //check the user input
        if($contact_message == "" OR $name == "" OR $email == "")
        {
            $message = "Please fill in your name, email and your question.";
            header("HTTP/1.1 301 Moved Permanently");
            header("Location: ".$PROJECT_PATH."help/contactPage.php?contact_name=$name&contact_email=$email&contact_message=$contact_message&message=$message");
        }
        else if(!check_email_address($email))
        {
            $message = "Invalid email address inputted.";
            header("HTTP/1.1 301 Moved Permanently");
            header("Location: ".$PROJECT_PATH."help/contactPage.php?contact_name=$name&contact_email=$email&contact_message=$contact_message&message=$message");
        }
        else if($valid != true)
        {
            $message = "Invalid captcha entered.";
            header("HTTP/1.1 301 Moved Permanently");
            header("Location: ".$PROJECT_PATH."help/contactPage.php?contact_name=$name&contact_email=$email&contact_message=$contact_message&message=$message");
        }
        else
        {
            $conn = dbConnect();

            // prepare the query for adding the new report case to the db
            $insertSQL = "INSERT INTO contact (`Name`, `Email`, `Message`, `ContactTime`) VALUES
                             ('$name', '$email','$contact_message', NOW())";
//                echo $insertSQL;
            mysql_query($insertSQL) or die(mysql_error());

            mysql_close($conn);

            $message = "Your query have been submited. Please be patient and wait for our email over the next 48 hours.";
            header("HTTP/1.1 301 Moved Permanently");
            header("Location: ".$PROJECT_PATH."help/contactPage.php?message=$message");
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
