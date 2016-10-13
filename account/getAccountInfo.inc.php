<?php

    $conn = dbConnect();
    //get all information of this user account
    $selectSQL = "SELECT * FROM user, userpayment WHERE user.UserID = userpayment.UserID AND user.UserID = ".$_SESSION['userID'];

    $result = mysql_query($selectSQL) or die(mysql_error());
    $userInfo = mysql_fetch_array($result);


    if($userInfo['State_Country'] != null)
    {
        $selectSQL = "SELECT State_CountryName FROM state_country WHERE State_CountryID = ".$userInfo['State_Country'];

        $result = mysql_query($selectSQL) or die(mysql_error());
        $row = mysql_fetch_array($result);
        $userInfo['stateName'] = $row['State_CountryName'];

    }


    $selectSQL = "SELECT * FROM state_country ORDER BY State_CountryName ASC";

    $result = mysql_query($selectSQL) or die(mysql_error());

    while($row = mysql_fetch_array($result))
    {
         $stateList[] = $row;
    }

    //check if user have already import feedback point from ebay
    $selectSQL = "SELECT * FROM ebay_imported_list WHERE UserID = ".$_SESSION['userID'];
    $result = mysql_query($selectSQL) or die(mysql_error());

    //if user have already imported in the past, user is trying to access importer
    //illegally, go back to main page
    if(mysql_num_rows($result))
    {
        $userInfo['imported'] = true;
    }
    else
    {
        $userInfo['imported'] = false;
    }

    //check if the user has the auto relist setting on or off
    $selectSQL = "SELECT * FROM autoRelistList WHERE UserID = ".$_SESSION['userID'];
    $result = mysql_query($selectSQL) or die(mysql_error());

    if(mysql_num_rows($result))
    {
        $userInfo['autoRelist'] = true;
    }
    else
    {
        $userInfo['autoRelist'] = false;
    }
    
    mysql_close($conn);
?>
