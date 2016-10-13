<?php
    if(isset($_GET['ItemID']))
    {
        $itemID = $_GET['ItemID'];
//        create connection and connect to the Twizla database
        $conn = dbConnect();

        $displayItemSQL = "SELECT * FROM item, user WHERE item.ItemID = $itemID AND
                                                                        item.SellerID = user.UserID";


//        echo $displayItemSQL;
        $result = mysql_query($displayItemSQL) or die(mysql_error());;
        
        $item = mysql_fetch_array($result);
        
        //get the state of the user
        if($item['State_Country'] != null)
        {
            $displayItemSQL = "SELECT * FROM state_country WHERE state_country.State_CountryID = ".$item['State_Country'];



            $result = mysql_query($displayItemSQL) or die(mysql_error());;

            $row = mysql_fetch_array($result);
            $item['State_CountryName'] = $row['State_CountryName'];
        }
        else
        {
            $item['State_CountryName'] = "";
        }


        //get item pictures
        
        $displayItemSQL =" SELECT PictureLink FROM picturelink WHERE picturelink.ItemID = $itemID";
        
        $result = mysql_query($displayItemSQL) or die(mysql_error());;
        
        while($row = mysql_fetch_array($result))
        {
            //get the link of the full_picture, check if file exist for the old items that has no full picture
            $full_pic = substr_replace($row['PictureLink'], "itemImages/full_", 0, 11);
//            echo file_exists($row['PictureLink'])."<br/>";
//            if(file_exists($PROJECT_PATH.$full_pic))
//            {
                $pictureList[] = $full_pic;
//            }
//            else
//            {
//                $pictureList[] = $row['PictureLink'];
//            }
        }
        
        //get the item category
        if($item['CategoryType'] == 'sub')
        {
            $displayItemSQL ="SELECT * FROM category, subcategory WHERE subcategory.CategoryID = category.CategoryID AND
                                                                         subcategory.subCategoryID = ".$item['ItemCategoryID'];
        }
        else if($item['CategoryType'] == 'subSub')
        {
            $displayItemSQL =" SELECT * FROM category, subcategory, subsubcategory WHERE subcategory.CategoryID = category.CategoryID AND
                                                                                        subsubcategory.subCategoryID = subcategory.subCategoryID AND
                                                                                        subsubcategory.subSubCategoryID = ".$item['ItemCategoryID'];
        }
        else if($item['CategoryType'] == 'subSubSub')
        {
            $displayItemSQL =" SELECT * FROM category, subcategory, subsubcategory, subsubsubcategory WHERE subcategory.CategoryID = category.CategoryID AND
                                                                                                        subsubcategory.subCategoryID = subcategory.subCategoryID AND
                                                                                                        subsubsubcategory.subSubCategoryID = subsubcategory.subSubCategoryID AND
                                                                                                        subsubsubcategory.subSubSubCategoryID = ".$item['ItemCategoryID'];
        }

//        echo $displayItemSQL;
        $result = mysql_query($displayItemSQL) or die(mysql_error());;

        $itemCategory = mysql_fetch_array($result);

        if($item['CategoryType'] == 'sub')
        {
            $categoryString = "<a href='".$PROJECT_PATH."category/".formatCategoryName($itemCategory['CategoryName'])."/'>".
                $itemCategory['CategoryName']."</a> >> <a href='".$PROJECT_PATH."category/".formatCategoryName($itemCategory['CategoryName'])."/".$itemCategory['subCategoryName']."/'>".$itemCategory['subCategoryName']."</a>";
        }
        else if($item['CategoryType'] == 'subSub')
        {
            $categoryString = "<a href='".$PROJECT_PATH."category/".formatCategoryName($itemCategory['CategoryName'])."/'>".
                $itemCategory['CategoryName']."</a> >> <a href='".$PROJECT_PATH."category/".formatCategoryName($itemCategory['CategoryName'])."/".$itemCategory['subCategoryName']."/'>".$itemCategory['subCategoryName']."</a>
                     >> <a href='".$PROJECT_PATH."category/".formatCategoryName($itemCategory['CategoryName'])."/".$itemCategory['subCategoryID']."/".$itemCategory['subSubCategoryName']."/'>".$itemCategory['subSubCategoryName']."</a>";

        }
        else if($item['CategoryType'] == 'subSubSub')
        {
            $categoryString = "<a href='".$PROJECT_PATH."category/".formatCategoryName($itemCategory['CategoryName'])."/'>".
                $itemCategory['CategoryName']."</a> >> <a href='".$PROJECT_PATH."category/".formatCategoryName($itemCategory['CategoryName'])."/".$itemCategory['subCategoryName']."/'>".$itemCategory['subCategoryName']."</a>
                     >> <a href='".$PROJECT_PATH."category/".formatCategoryName($itemCategory['CategoryName'])."/".$itemCategory['subCategoryID']."/".$itemCategory['subSubCategoryName']."/'>".$itemCategory['subSubCategoryName']."</a>
                          >> <a href='".$PROJECT_PATH."searchProductPage.php?searchSubmit=true&CategoryType=subSubSub&subID=".$itemCategory['subSubSubCategoryName']."/'>".$itemCategory['subSubSubCategoryName']."</a>";
        }


        //get Item payment methods
        $sql = "SELECT * FROM itempaymentmethod, payment_method WHERE itempaymentmethod.MethodID = payment_method.MethodID AND ITEMID =$itemID";
        
        $result = mysql_query($sql) or die(mysql_error());;
        
        while($row = mysql_fetch_array($result))
        {
             $itemPayment[] = $row;
        }

        mysql_close($conn);
    }
?>