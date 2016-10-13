<?php

    require 'facebook.php';
    include("mySQL_connection.inc.php");
    $facebook = new Facebook(array(
      'appId'  => '107886915933327',
      'secret' => 'f3fdfc75dfc947736d8ebb19ee0bf3a3',
      'cookie' => true, // enable optional cookie support
    ));

    if(isset($_GET['close']))
    {
        echo "<script>
            window.close();
            </script>";
    }
    else if(isset($_GET['login_success']))
    {


//        //get permission to acess user email
//        $url = $facebook->getLoginUrl(array(
//            'req_perms' => 'email, read_friendlists',
//            'next' => $PROJECT_PATH."FBLogin.php?saveFBUser=true",
//            'cancel_url' => $PROJECT_PATH."FBLogin.php?close=true"
//        ));
//
//        header("Location: {$url} ");
//
//    }
//    else if(isset($_GET['saveFBUser']))
//    {
//        $uid = $facebook->getUser();
//
//        # users.hasAppPermission
//        $api_call = array(
//            'method' => 'users.hasAppPermission',
//            'uid' => $uid,
//            'ext_perm' => 'email, read_friendlists',
//        );
//        $users_hasapppermission = $facebook->api($api_call);
//
//        if($users_hasapppermission)
//        {
            $me = $facebook->api('/me');

            $conn = dbConnect();
            $sql = "SELECT UserID FROM user WHERE UserName = '".$me['name']."' AND password = 'FB_".$me['id']."'";

            $result = mysql_query($sql) or die(mysql_error());
            $row = mysql_fetch_array($result);

            if(!mysql_num_rows($result))
            {


              $insertQuery = "INSERT INTO user (LastName, FirstName,Email,Password,Suburb_City,KnowingSource, AddressLine1, State_Country,Postcode,ContactNumber, AddressLine2, feedbackPoint, registerDate, verifyStatus, UserName)
                                VALUES ('".$me['last_name']."','".$me['first_name']."','".$me['email']."','FB_".$me['id']."', null,'',null,'',null,null,null, 0, '".date("Y-m-d")."', 'no', '".$me['name']."')";

              mysql_query($insertQuery);
              //get the userID of the new User
              $userID = mysql_insert_id();

              //insert a new record of user payment options into database
              $insertQuery = "INSERT INTO userpayment (UserID, PaypalEmail, PaymateEmail, AccountHolder, BankName, BSB1, BSB2, AccountNo)
                                VALUES ($userID, null, null, null, null, null, null, null)";

              mysql_query($insertQuery);
            }
            mysql_close($conn);
//        }

        echo "<script>
        window.close();
        window.opener.location.reload();
        </script>";
    }
?>
