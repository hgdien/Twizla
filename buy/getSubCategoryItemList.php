<?php

    include("../mySQL_connection.inc.php");

    $searchSQL = "SELECT * FROM item, picturelink Where item.ItemID = picturelink.ItemID";
    if($_GET['type'] == 'subSub')
    {

        // create connection and connect to the Twizla database
        

        // get the list of sub category belong to this category from database
        $searchSQL .= " And ((item.CategoryType = '".$_GET['type']."' AND item.ItemCategoryID = ".$_GET['subID'].")";

        $searchSQL .= " OR (item.CategoryType = 'subSubSub' AND item.ItemCategoryID IN (SELECT subSubSubCategoryID FROM subsubcategory, subsubsubcategory WHERE 
                                                                    subsubsubcategory.subSubCategoryID = subsubcategory.subSubCategoryID AND subsubcategory.subSubCategoryID = ".$_GET['subID'].")))";

    }
    else if ($_GET['type'] == 'subSubSub')
    {
        $searchSQL .= " And item.CategoryType = '".$_GET['type']."' AND item.ItemCategoryID = ".$_GET['subID'];
    }

    $searchSQL .= " AND timeFinish > '".date('Y-m-d H:i:s')."' AND item.Quantity > 0";
    
    $conn = dbConnect();
    $result = mysql_query($searchSQL) or die(mysql_error());
    
    while($row = mysql_fetch_array($result))
    {
         $itemList[] = $row;
    }

    mysql_close();

    include_once '../displayItemList.inc.php';
    $pageLink = $PROJECT_PATH."category/".$_GET['CategoryName'];
    displayItemList($itemList,24,"", "latestList","buyItemContainer",true, $pageLink, false);

?>
