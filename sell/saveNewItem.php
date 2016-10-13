<?php
    include("../mySQL_connection.inc.php");
// process the script only if the form has been submitted

    if(isset($_POST['listItemSubmit']))
    {
        //include the functions to connect to database
        $itemTitle = $_POST['itemTitle'];
        $itemCatchPhrase = $_POST['catchPhrase'];
        $itemCategoryID = $_POST['itemCategoryID'];
        $categoryType = $_POST['categoryType'];
        $itemDesc = $_POST['itemDesc'];
        $bidPrice = $_POST['bidPrice'];
        $buyPrice = $_POST['buyPrice'];
        $paymentMethods = $_POST['paymentMethod'];
        $quantity = $_POST['quantity'];


        //case the user only set up either bid or buy now price
        if($buyPrice == "")
        {
            $buyPrice = 'null';
        }
        if($bidPrice == "")
        {
            $bidPrice ='null';
        }


        $itemPostage = $_POST['itemPostage'];
        $itemCondition = $_POST['itemCondition'];
        $listDuration = str_replace(" days","", $_POST['listDuration']);

        $sellerID = $_POST['sellerID'];
        $listedDate = date("Y-m-d H:i:s");

        $A_DAY_TIMESTAMP = 24*60*60;
        $timeFinish = date("Y-m-d H:i:s", (strtotime($listedDate) + $listDuration * $A_DAY_TIMESTAMP));
//


        $pictureLink = array();
        //get the list of picture uploaded, maximum 6 pictures
        //copy the image files from the temporary uploads folder to the actual itemImages folder
        for($count = 1; $count < 7; $count++)
        {
           if($_POST["pictureLink$count"] != "")
           {
               //check the file location
               $fileLocation = substr($_POST["pictureLink$count"], 0, 8);
               //if stay in the temporary folder (add new item) then start the copy
               if($fileLocation == "uploads/")
               {
                   //set the file path to the itemImages folder instead of the upload temporary folder
                   $fileName = substr_replace($_POST["pictureLink$count"], "itemImages/", 0, 8);
                   $fullFileName = substr_replace($_POST["pictureLink$count"], "itemImages/full_", 0, 8);

                   //copy the full picture and the small version to the server
                   $smallPic_src = substr_replace($_POST["pictureLink$count"], "uploads/small_", 0, 8);
                   copy($smallPic_src, "../".$fileName) or die("Can not copy to itemImages folder.");
                   copy($_POST["pictureLink$count"], "../".$fullFileName) or die("Can not copy to itemImages folder.");
                   $pictureLink[] = $fileName;
               }
               //if not then the file already exist in the itemImages folder (edit existing item),
               //save it in a list of keepList, as we shall remove every old picture except this list later
               else
               {
                   //as the links displayed are in full picture move (links contains a "full_" mark in front of the item name)
                   //we shall remove the full mode mark from the filename before added it to the keeplist
                   $fileName = substr_replace($_POST["pictureLink$count"], "", 11, 5);
                   $keepList[] = $fileName;
                   $pictureLink[] = $fileName;
               }
           }
        }
//
//        //copy the video file from the temporary uploads folder to the actual itemVideo folder
//       //check the file location
//       $fileLocation = substr($_POST["videoLink"], 0, 8);
//       //if stay in the temporary folder (add new item) then start the copy
//       if($fileLocation == "uploads/")
//       {
//           //set the file path to the itemVideo folder instead of the upload temporary folder
//           $fileName = substr_replace($_POST["videoLink"], "itemVideo/", 0, 8);
//           copy($_POST["videoLink"], $fileName) or die("Can not copy to itemImages folder.");
//       }
//       //if not then the file already exists (edit existing item), the user did not
//       // change the video file when edit the item, set the keepVideo to true
//
//       else
//       {
//           $fileName = $_POST["videoLink"];
//           $keepVideo = true;
//       }
//        $itemVideo = $fileName;


        //clear up the uploads temporary folder
        recursive_remove_directory("..uploads/", TRUE);


        if (!get_magic_quotes_gpc())
        {
            $itemTitle = addslashes($itemTitle);
            $itemCatchPhrase = addslashes($itemCatchPhrase);
            $itemDesc = addslashes($itemDesc);
            $bidPrice = addslashes($bidPrice);
            $buyPrice = addslashes($buyPrice);
            $itemPostage = addslashes($itemPostage);
            $itemCondition = addslashes($itemCondition);
            $listedDate = addslashes($listedDate);
            $itemVideo = addslashes($itemVideo);
            $itemPicture = addslashes($itemPicture);
            $quantity = addslashes($quantity);
            foreach($pictureLink as $link)
            {
                $link = addslashes($link);
            }
        }

        if($itemPostage == 'Fixed Price')
        {
            $itemPostage .= " AUD $".$_POST['postagePrice'];
        }

//        copy ($_FILES[$itemVideo]['tmp_name'], $folder.$newfilename) or die ('Could not move file');

        $conn = dbConnect();

        //check if it is add new or edit item
        if($_POST['editID'] == "")
        {

            // prepare the query for adding new item into database
            $insertSQL = "INSERT INTO item (ItemTitle, ItemCategoryID, Description, Price, Postage, ItemCondition, VideoLink, SellerID, CatchPhrase, currentBid, listDuration, numberOfBid, listedDate, startingBid, timeFinish, Unsold, CategoryType, Quantity)
            VALUE ('$itemTitle',$itemCategoryID,'$itemDesc',$buyPrice,'$itemPostage','$itemCondition','$itemVideo',$sellerID,'$itemCatchPhrase',$bidPrice,$listDuration,0,'$listedDate', $bidPrice, '$timeFinish', 0, '$categoryType', $quantity)";
//            $message[] = $insertSQL;
//            echo $insertSQL;
            mysql_query($insertSQL) or die(mysql_error());

            //get the return itemID and start insert the item  picture links
            $itemID = mysql_insert_id();
            foreach($pictureLink as $link)
            {
                $insertSQL = "INSERT INTO picturelink (ItemID, PictureLink) VALUE($itemID,'$link')";
                mysql_query($insertSQL) or die(mysql_error());
            }

            //record the pament method specified for this item
            foreach($paymentMethods as $methodID)
            {
                $insertSQL = "INSERT INTO itempaymentmethod (ItemID, MethodID) VALUE ($itemID, $methodID)";

                mysql_query($insertSQL) or die(mysql_error());
            }

        }
        else
        {
            //before update the item, compare it with the old spec and remove item images and video that have been removed by user
            //if the video is untouch then skip the checking
//            if($keepVideo)
//            {
//                $checkSQL = "SELECT VideoLink FROM item WHERE item.itemID = ".$_POST['editID'];
//                $result = mysql_query($checkSQL) or die(mysql_error());
//                $row = mysql_fetch_array($result);
//                if($itemVideo != $row['VideoLink'])
//                {
//                    //remove the old video file
//                    unlink($row['VideoLink']);
//                }
//            }

            $checkSQL = "SELECT PictureLink FROM picturelink WHERE picturelink.ItemID = ".$_POST['editID'];
            $result = mysql_query($checkSQL) or die(mysql_error());
            $row = mysql_fetch_array($result);

            //remove every old picture except the ones in the keep list
            while($row = mysql_fetch_array($result))
            {
                $keep = false;
                if(count($keepList) > 0)
                {
                    foreach($keepList as $link)
                    {
                        if($link == $row['PictureLink'])
                        {
                            $keep = true;
                        }
                    }
                }
                if(!$keep)
                {
                    unlink("../".$row['PictureLink']);
                    //also unlink the full version of the picture
                    $full_pic = substr_replace($row['PictureLink'], "itemImages/full_", 0, 11);
                    unlink("../".$full_pic);
                }
            }

            $updateSQL = "UPDATE item SET ItemTitle = '$itemTitle', ItemCategoryID = $itemCategoryID, Description = '$itemDesc', Price = $buyPrice,
                                            Postage = '$itemPostage', ItemCondition= '$itemCondition', VideoLink = '$itemVideo', SellerID = $sellerID, CatchPhrase ='$itemCatchPhrase',
                                            currentBid = $bidPrice, listDuration = $listDuration, listedDate='$listedDate', startingBid = $bidPrice, timeFinish = '$timeFinish', CategoryType = '$categoryType', Quantity = $quantity";

            //if it is re-List, set the unsold column back to 0
            if($_POST['submitType'] == "reList")
            {
                $updateSQL .= " , Unsold = 0";
            }

            $updateSQL .= " WHERE ItemID = ".$_POST['editID'];
//            echo $updateSQL;
            mysql_query($updateSQL) or die(mysql_error());

            //remove all existing pics and put up new uploaded picture
            $deleteSQL = "DELETE FROM picturelink WHERE ItemID =".$_POST['editID'];
            mysql_query($deleteSQL) or die(mysql_error());

            foreach($pictureLink as $link)
            {
                $insertSQL = "INSERT INTO picturelink (ItemID, PictureLink) VALUE(".$_POST['editID'].",'$link')";
                mysql_query($insertSQL) or die(mysql_error());
            }

            //update the pament methods specified for this item - first remove all existing payment method, then insert the new ones
            $deleteSQL = "DELETE FROM itempaymentmethod WHERE ItemID =".$_POST['editID'];
            mysql_query($deleteSQL) or die(mysql_error());

            foreach($paymentMethods as $methodID)
            {
                $insertSQL = "INSERT INTO itempaymentmethod (ItemID, MethodID) VALUE (".$_POST['editID'].", $methodID)";
//                echo $insertSQL;
                mysql_query($insertSQL) or die(mysql_error());
            }

        }

        mysql_close($conn);

        // process the script based on the submit type
        if($_POST['submitType'] == "saveItem")
        {
            header("HTTP/1.1 301 Moved Permanently");
            header("Location:".$PROJECT_PATH."sell/listItemPage1.php");
        }
        else if($_POST['submitType'] == "saveItemAndContinue")
        {
            $message[] = "Successful List the item.";
            header("HTTP/1.1 301 Moved Permanently");
            header("Location:".$PROJECT_PATH."sell/listItemPage2.php?message=$message[0]");
        }
        else if($_POST['submitType'] == "reList")
        {
            header("HTTP/1.1 301 Moved Permanently");
            header("Location:".$PROJECT_PATH."account/myAccountPage.php?page=Sell&tab=3");
        }
    }
?>

<?php

// ------------ lixlpixel recursive PHP functions -------------
// recursive_remove_directory( directory to delete, empty )
// expects path to directory and optional TRUE / FALSE to empty
// of course PHP has to have the rights to delete the directory
// you specify and all files and folders inside the directory
// ------------------------------------------------------------

// to use this function to totally remove a directory, write:
// recursive_remove_directory('path/to/directory/to/delete');

// to use this function to empty a directory, write:
// recursive_remove_directory('path/to/full_directory',TRUE);

function recursive_remove_directory($directory, $empty=FALSE)
{
	// if the path has a slash at the end we remove it here
	if(substr($directory,-1) == '/')
	{
		$directory = substr($directory,0,-1);
	}

	// if the path is not valid or is not a directory ...
	if(!file_exists($directory) || !is_dir($directory))
	{
		// ... we return false and exit the function
		return FALSE;

	// ... if the path is not readable
	}elseif(!is_readable($directory))
	{
		// ... we return false and exit the function
		return FALSE;

	// ... else if the path is readable
	}else{

		// we open the directory
		$handle = opendir($directory);

		// and scan through the items inside
		while (FALSE !== ($item = readdir($handle)))
		{
			// if the filepointer is not the current directory
			// or the parent directory
			if($item != '.' && $item != '..')
			{
				// we build the new path to delete
				$path = $directory.'/'.$item;

				// if the new path is a directory
				if(is_dir($path))
				{
					// we call this function with the new path
					recursive_remove_directory($path);

				// if the new path is a file
				}else{
					// we remove the file
					unlink($path);
				}
			}
		}
		// close the directory
		closedir($handle);

		// if the option to empty is not set to true
		if($empty == FALSE)
		{
			// try to delete the now empty directory
			if(!rmdir($directory))
			{
				// return false if not possible
				return FALSE;
			}
		}
		// return success
		return TRUE;
	}
}
// ------------------------------------------------------------

?>