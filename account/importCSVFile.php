<?php
    
    if(isset($_POST['CSVSubmit']))
    {
        session_start();
        include("../mySQL_connection.inc.php");
        $fileName = $_FILES['uploadFile']['name'];
        $fileSize = $_FILES['uploadFile']['size'];
        $fileType = $_FILES['uploadFile']['type'];
        $referer  = $_SERVER['HTTP_REFERER'];
        $fileName = preg_replace('/\s/', '_', $fileName);
        $file_ext = preg_split("/\./",$fileName);

        
        if($fileName == "") // if no file input, kill it
        {
            $message = "Please select a CSV file to import";

        }
        else if(strtolower($file_ext[1]) !='csv' )
             // if file does not equal these types, kill it
        {
            $message = "The upload file type is not in CSV format.";
        }
        else if($fileSize>'5000000') // if size is larger than 9MB, kill it
        {
            $message = $fileName . " is over 5MB. Please make it smaller.";
        }
        if($message == "")
        {
            $rHandle = fopen($_FILES['uploadFile']['tmp_name'], "r");
            $sData = '';
            $conn = dbConnect();
            while(!feof($rHandle))
            {
                $line_of_text = fgetcsv($rHandle, 1024);
                if($line_of_text != "")
                {
                    $result = importItem($line_of_text);
                    if($result != "success")
                    {
                        $failList[] = $line_of_text;
                        $failError[] = $result;
                    }
                }
            }
            fclose($rHandle);

            mysql_close($conn);

            if(count($failList) >0)
            {
                $message = "There are ".count($failList)." invalid item records in the CSV file: <br><br>";

                for($count = 0; $count < count($failList); $count++)
                {
                    if($count > 3)
                    {$message .= "...<br/>"; break;}

                    $record = $failList[$count];

                    $message .= implode(",", $record)." <br/>";
                    $message .= "Error: ".$failError[$count]." <br/><br/>";

                }

                $_SESSION['message'] = $message;
                header("HTTP/1.1 301 Moved Permanently");
                header("Location: $referer"); // go back to the page we came from

            }
            else
            {
                header("HTTP/1.1 301 Moved Permanently");
                header("Location: ".$PROJECT_PATH."sell/listItemPage1.php");
            }
        }

        
    }
    else
    {
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: ".$PROJECT_PATH."index.php");
    }

    function importItem($cols)
    {

        $itemTitle = addslashes($cols[0]);

        //following the format set up by the CSV file:
//        Title, Category_ID, CatchPhrase, Description, Buy Now Price, Starting Bid Price, Postage, Condition, Quantity, ImageURL, ImageURL2,...
        $itemCategoryID = $cols[1];

        if($cols[2]== "")
        {
            $itemCatchPhrase= "";
        }
        else
        {
            $itemCatchPhrase= addslashes($cols[2]);
        }

        $itemDesc = addslashes($cols[3]);
        
        if($cols[4]== "")
        {
            $buyPrice = null;
        }
        else
        {
            $buyPrice = $cols[4];
        }

        if($cols[5]== "")
        {
            $bidPrice = null;
        }
        else
        {
            $bidPrice = $cols[5];
        }

        $itemPostage = $cols[6];
//        echo $itemPostage;
        if($cols[7]== "")
        {
            $itemCondition  = "Good";
        }
        else
        {
            $itemCondition = $cols[7];
        }

        $quantity = $cols[8];

        for($count= 9; $count < count($cols); $count++)
        {
            if($count == 14)
            {
                break;
            }
            $pictureLink[] = $cols[$count];
        }
        //check the data field format
        $check = true;

        if(count($pictureLink) >0)
        {
            foreach($pictureLink as $link)
            {
                if(!is_valid_url($link))
                {
                    $check = false;
                }

            }
        }
        else
        {
            $check = false;
        }

        if(!$check)
        {
            return "Invalid picture links. Please re-check all of the picture links inputed.";

        }
        else if(!(is_numeric($itemCategoryID) AND is_numeric($quantity)) OR $quantity < 1 OR ($buyPrice == null AND $bidPrice== null) OR ($buyPrice != null AND !(is_numeric($buyPrice)))
                OR ($bidPrice != null AND !(is_numeric($bidPrice))) OR ($itemPostage != "Free shipping" AND $itemPostage != "Self Pick Up" AND substr($itemPostage, 0, 11) != "Fixed Price" ))
        {
            return "Invalid data field entered. Please recheck the Import CSV inventory file help section. ";
        }
        else
        {

            $itemVideo = "";
            $sellerID = $_SESSION['userID'];
            //set default value fields for importing from CSV file:
            $listDuration = 30;
            $categoryType = "sub";
            $listedDate = date("Y-m-d H:i:s");
            $A_DAY_TIMESTAMP = 24*60*60;
            $timeFinish = date("Y-m-d H:i:s", (strtotime($listedDate) + $listDuration * $A_DAY_TIMESTAMP));

            // prepare the query for adding new item into database
            $insertSQL = "INSERT INTO item (ItemTitle, ItemCategoryID, Description, Price, Postage, ItemCondition, VideoLink, SellerID, CatchPhrase, currentBid, listDuration, numberOfBid, listedDate, startingBid, timeFinish, Unsold, CategoryType, Quantity)
            VALUE ('$itemTitle',$itemCategoryID,'$itemDesc',$buyPrice,'$itemPostage','$itemCondition','$itemVideo',$sellerID,'$itemCatchPhrase',$bidPrice,$listDuration,0,'$listedDate', $bidPrice, '$timeFinish', 0, '$categoryType', $quantity)";
//            echo $insertSQL;
            mysql_query($insertSQL) or die(mysql_error());
    
            //get the return itemID and start insert the item  picture links
            $itemID = mysql_insert_id();
            foreach($pictureLink as $link)
            {
                //download the picture from URL
                $fileName = "itemImages/".substr($itemTitle, 0, 6)."_".date('d-m-Y');
                $fullFileName = "itemImages/full_".substr($itemTitle, 0, 6)."_".date('d-m-Y');
                $fileName = addslashes($fileName);
                $fullFileName = addslashes($fullFileName);

                $contents = file_get_contents($link);

                $fp = fopen($fullFileName, 'w');
                fwrite($fp, $contents);
                fclose($fp);

                //create a small version of the picture to speed up the page, dimesion of the box contain small picture is 110 x 110 px
                include_once '../SimpleImage.php';
                $smallImage = new SimpleImage();
                $smallImage->load($fullFileName);
                $smallImage->resize(110, 110);
                $smallImage->save($fileName);

                //insert the link record to database;
                $insertSQL = "INSERT INTO picturelink (ItemID, PictureLink) VALUE($itemID,'$fileName')";
                mysql_query($insertSQL) or die(mysql_error());
            }

            //record the pament method specified for this item

            $insertSQL = "INSERT INTO itempaymentmethod (ItemID, MethodID) VALUE ($itemID, 1)";

            mysql_query($insertSQL) or die(mysql_error());

            return "success";
        }


    }

    function is_valid_url ( $url )
    {
                    $url = @parse_url($url);

                    if ( ! $url) {
                            return false;
                    }

                    $url = array_map('trim', $url);
                    $url['port'] = (!isset($url['port'])) ? 80 : (int)$url['port'];
                    $path = (isset($url['path'])) ? $url['path'] : '';

                    if ($path == '')
                    {
                            $path = '/';
                    }

                    $path .= ( isset ( $url['query'] ) ) ? "?$url[query]" : '';

                    if ( isset ( $url['host'] ) AND $url['host'] != gethostbyname ( $url['host'] ) )
                    {
                            if ( PHP_VERSION >= 5 )
                            {
                                    $headers = get_headers("$url[scheme]://$url[host]:$url[port]$path");
                            }
                            else
                            {
                                    $fp = fsockopen($url['host'], $url['port'], $errno, $errstr, 30);

                                    if ( ! $fp )
                                    {
                                            return false;
                                    }
                                    fputs($fp, "HEAD $path HTTP/1.1\r\nHost: $url[host]\r\n\r\n");
                                    $headers = fread ( $fp, 128 );
                                    fclose ( $fp );
                            }
                            $headers = ( is_array ( $headers ) ) ? implode ( "\n", $headers ) : $headers;
                            return ( bool ) preg_match ( '#^HTTP/.*\s+[(200|301|302)]+\s#i', $headers );
                    }
                    return false;
    }
?>
