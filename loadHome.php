
<?php

    // create connection and connect to the Twizla database
    $conn = dbConnect();

    // get the list of category from database
    $sql = "SELECT * FROM category ORDER BY CategoryID ASC";
    
    $result = mysql_query($sql) or die(mysql_error());

    while($row = mysql_fetch_array($result))
    {
        $categoryList[] = $row;
    }

    $sql = "SELECT COUNT(*) AS UserAmount FROM user";

    $result = mysql_query($sql) or die(mysql_error());

    while($row = mysql_fetch_array($result))
    {
        $userAmount = $row['UserAmount'];
    }

    $fake = 442;

    $userAmount = $fake + $userAmount;

    $sql = "SELECT SUM(Quantity) AS ItemAmount FROM item";

    $result = mysql_query($sql) or die(mysql_error());

    while($row = mysql_fetch_array($result))
    {
        $itemAmount = $row['ItemAmount'];
    }

    mysql_close($conn);

    require 'facebook.php';

    $facebook = new Facebook(array(
      'appId'  => '107886915933327',
      'secret' => 'f3fdfc75dfc947736d8ebb19ee0bf3a3',
      'cookie' => true, // enable optional cookie support
    ));
    $me = null;
    $session = $facebook->getSession();

    if($session)
    {
        try {
        $id = $facebook->getUser();
        $me = $facebook->api('/'.$id);
            } catch (FacebookApiException $e) {

            echo "Error:" . print_r($e, true);

        }
    }

//    var_dump($facebook->getSession());
    if($me != null)
    {


            //check if the FB user is stored in the database
            $conn = dbConnect();

            $sql = "SELECT * FROM user WHERE UserName = '".$me['name']."' AND password = 'FB_".$me['id']."'";

            $result = mysql_query($sql) or die(mysql_error());

            $row = mysql_fetch_array($result);
            $_SESSION['userID'] = $row['UserID'];
            $_SESSION['username'] = $row['UserName'];


            $friends = $facebook->api('/'.$id.'/friends');

            foreach($friends as $friend)
            {
                $sql ="SELECT * FROM user WHERE UserName = '".$friend[0]['name']."' AND password = 'FB_".$friend[0]['id']."'";

                $result = mysql_query($sql) or die(mysql_error());
                $row = mysql_fetch_array($result);
                if(mysql_num_rows($result))
                {
                    $FBFriendList[] = $row['UserID'];
                }
            }
            mysql_close($conn);
    }


    function formatCategoryName($name)
    {
        
        $formatName = str_replace(" ",'-', $name);
        $formatName = str_replace("&",'And', $formatName);
        return $formatName;
    }

    function getOriginalName($formatName)
    {
        $nameOrginal = str_replace("-", " ", $formatName);
        $nameOrginal = str_replace("And", "&", $nameOrginal);
        return $nameOrginal;
    }
    
    function formatItemTitle($title)
    {
        //replace all special characters with '-';
        $formatTitle = str_replace(" ",'-', $title);
        $formatTitle = str_replace("&",'And', $formatTitle);
        $formatTitle = str_replace(".",'-', $formatTitle);
        $formatTitle = str_replace(":",'', $formatTitle);
        $formatTitle = str_replace("(",'-', $formatTitle);
        $formatTitle = str_replace(")",'-', $formatTitle);
        $formatTitle = str_replace("/",'-', $formatTitle);
        $formatTitle = str_replace('"','-', $formatTitle);
        $formatTitle = str_replace("'",'-', $formatTitle);
        $formatTitle = str_replace("---",'-', $formatTitle);
        $formatTitle = str_replace("--",'-', $formatTitle);
        $formatTitle = str_replace("--",'-', $formatTitle);

        return $formatTitle;
    }
?>
