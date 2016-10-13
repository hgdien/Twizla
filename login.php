<?php
//    define('FACEBOOK_APP_ID', '107886915933327');
//    define('FACEBOOK_SECRET', 'f3fdfc75dfc947736d8ebb19ee0bf3a3');

    //check if the user have a cookie from previous log ins

   if(isset($_COOKIE['username']) && isset($_COOKIE['userID']))
   {

        $_SESSION['username'] = $_COOKIE['username'];
        $_SESSION['userID'] = $_COOKIE['userID'];
   }
   

//   //check if user have a Facebook cookie
//   $FBcookie = get_facebook_cookie(FACEBOOK_APP_ID, FACEBOOK_SECRET);
//
//    if ($FBcookie)
//    {
//        $user = json_decode(file_get_contents('https://graph.facebook.com/'.$FBcookie['uid'].'?access_token='.$FBcookie['access_token']));
//
//        $conn = dbConnect();
//
//        $sql = "SELECT UserID FROM user WHERE UserName = '".$user->first_name."' AND password = '".$user->id."'";
//
//        $result = mysql_query($sql) or die(mysql_error());
//
//        if(mysql_num_rows($result))
//        {
//            $row = mysql_fetch_array($result);
//            $_SESSION['userID'] = $row['UserID'];
//            $_SESSION['username'] = $user->first_name;
//        }
//        else
//        {
//            $_SESSION['userID'] = "-1";
//        }
//        mysql_close($conn);
//    }

   // process the script only if the form has been submitted
   if(isset($_POST['loginSubmit']))
   {
        //Get extra information from client as  search item /
//        include("mySQL_connection.inc.php");

        $email = trim($_POST['email']);

        //oneway hashing the password for security protection
        $pwd = sha1($_POST['password']);

        $loginMessage ="";

        if(strlen($email) == 0 OR strlen($_POST['password']) == 0)
        {
            $loginMessage = "Please input your email and password to login.";
        }
        else
        {
            // create connection and connect to the Twizla database
            $conn = dbConnect();

            if (!get_magic_quotes_gpc())
            {
                $email = addslashes($email);
                $pwd = addslashes($pwd);

            }

            // prepare email for use in SQL query
            $email = mysql_real_escape_string($email);

            //check if the this user has been banned
            $sql = "SELECT * FROM user_banned WHERE Email = '$email'";

            $result = mysql_query($sql) or die(mysql_error());

            //if matched, this user has been banned
            if(mysql_num_rows($result))
            {
                $loginMessage = "This member has been suspended.";

            }
            else
            {
                // get the email details from the database
                $sql = "SELECT * FROM user WHERE email = '$email' AND password = '$pwd'";

                $result = mysql_query($sql) or die(mysql_error());


        //        $currentUser= "";

                //check username and password
                //if matched, set a new session for the user
                if(mysql_num_rows($result))
                {
                    $row = mysql_fetch_array($result);
                    $_SESSION['username'] = $row['UserName'];
                    $_SESSION['userID'] = $row['UserID'];
    //                $_COOKIE['username']= $row['UserName'];

    //                $sql = "INSERT INTO TEST(test) VALUE('".$_SESSION['username']."')";
    //                $result = mysql_query($sql) or die(mysql_error());

                    //if remember me is checked. Save the username and password in a cookie for future visits
                    //set the cookie expired to 100 days
                    if(isset($_POST['rememberMe']))
                    {
                        $hour = 60*60*24*100;
                        setcookie("username", $row['UserName'], $hour);
                        setcookie("userID", $row['UserID'], $hour);
                    }
                    header("HTTP/1.1 301 Moved Permanently");
                    header('Location: '.$PROJECT_PATH.'index.php');
                }
                // if no matching prepare error message
                else
                {
                    $loginMessage = 'Invalid email or password';
                }
            }
            mysql_close($conn);


        }
    }



//    function get_facebook_cookie($app_id, $application_secret) {
//      $args = array();
//      parse_str(trim($_COOKIE['fbs_' . $app_id], '\\"'), $args);
//      ksort($args);
//      $payload = '';
//      foreach ($args as $key => $value) {
//        if ($key != 'sig') {
//          $payload .= $key . '=' . $value;
//        }
//      }
//      if (md5($payload . $application_secret) != $args['sig']) {
//        return null;
//      }
//      return $args;
//    }

?>