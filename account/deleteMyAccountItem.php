<?php

    include("../mySQL_connection.inc.php");
    $referer  = $_SERVER['HTTP_REFERER'];
    //        create connection and connect to the Twizla database

    $conn = dbConnect();
    if(isset($_GET['ItemID']))
    {
        moveToDeleteRecord($_GET['ItemID'],$_GET['UserID'],$_GET['Type']);
//        $tab = $_GET['tab'];
//        header("Location:".$PROJECT_PATH."myAccountPage.php?page=Buy&tab=$tab"); // go back to the page we came from
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: $referer"); // go back to the page we came from
    }
    else if(isset($_GET['ItemIDList']))
    {
        $ItemID = strtok($_GET['ItemIDList'],'|');
        $IDList[] =$ItemID;
//        $tab = $_GET['tab'];
        $userID = $_GET['UserID'];
        $type = $_GET['Type'];
        while(is_string($ItemID))
        {
            $ItemID = strtok("|");
            if($ItemID)
            {
                $IDList[] = $ItemID;
            }
        }

        foreach($IDList as $ID)
        {
            moveToDeleteRecord($ID, $userID, $type);
        }
//        header("Location:".$PROJECT_PATH."myAccountPage.php?page=Buy&tab=$tab"); // go back to the page we came from
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: $referer"); // go back to the page we came from
    }
    else
    {
        header("HTTP/1.1 301 Moved Permanently");
        header('Location: '.$PROJECT_PATH .'index.php');
    }

    mysql_close($conn);


    
    function moveToDeleteRecord($itemID, $userID, $type)
    {
        $sql = "INSERT INTO deleterecord(ItemID, UserID, Type, DeleteDate) VALUE ($itemID, $userID, '$type', '".date("Y-m-d H:i:s")."')";

        mysql_query($sql) or die(mysql_error());
        
        //untagged a item if it is tagged.
        if($type == 'tagList')
        {
            $sql = "DELETE FROM itemtag WHERE ItemID = $itemID AND UserID = $userID";

            mysql_query($sql) or die(mysql_error());
        }
    }

    
?>
