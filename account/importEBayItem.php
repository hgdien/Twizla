<?php
    session_start();
    include("mySQL_connection.inc.php");
    //set the RuName, RuName are associated with which page the eBay Consent Form
    //will be directed to

    if(!isset($_SESSION['userID']))
    {
        header( "HTTP/1.1 301 Moved Permanently" );
        header("Location: ".$PROJECT_PATH."account/importerPage.php");
    }
    else
    {
        $RuName = "Twizla_Pty_Ltd-TwizlaPt-2e13-4-tikjsk";
        //get the EBayAuthorized Token
        include_once 'ebayAPIIncludes/eBayImporter.php';

        if($token)
        {
            //after obtain the token, use it to get the selling list of this user from Ebay
            $verb = 'GetSellerList';
//            $verb = 'GetCategories';
            $A_MONTH_TIMESTAMP = 24*60*60*30;
            $toTimeStamp = strtotime(date("Y-m-d H:i:s")) + $A_MONTH_TIMESTAMP;

            $requestXmlBody='<?xml version="1.0" encoding="utf-8"?>
                                <GetSellerListRequest xmlns="urn:ebay:apis:eBLBaseComponents">
                                <DetailLevel>ReturnAll</DetailLevel>
                                <RequesterCredentials>
                                <eBayAuthToken>'.$token.'</eBayAuthToken>
                                </RequesterCredentials>
                             
                              <EndTimeFrom>'.date("Y-m-d").'T'.date("H:i:s").".005Z".'</EndTimeFrom>
                              <EndTimeTo>'.date("Y-m-d", $toTimeStamp).'T'.date("H:i:s",$toTimeStamp).".005Z".'</EndTimeTo>
                            <Pagination ComplexType="PaginationType">
                            <EntriesPerPage>2</EntriesPerPage>
                            <PageNumber>1</PageNumber>
                            </Pagination>
                            </GetSellerListRequest>';


         /*
$requestXmlBody='<?xml version="1.0" encoding="utf-8"?>
<GetCategoriesRequest xmlns="urn:ebay:apis:eBLBaseComponents">
<RequesterCredentials>
<eBayAuthToken>AgAAAA**AQAAAA**aAAAAA**1CTeSw**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6AEkICoCZaCpASdj6x9nY+seQ**Y9gAAA**AAMAAA**Auf/1cSRb/zikqKPqmm+oCV+gta4LkPy46O/s5MPef7aguI6ZPDEkmjRrzf2SG/chxaZzEMexwtm1lkYH+M3i3UDnSCG59MWdIuePrsjNY0jr7h5C+KsPspAXO2Wx91XGy8sV4+QCkekdSMJxI8z+n+o+b6pQf+oUJ8tS0H3y4k0Q03odjcC6YhtdKuzDEKd1jeB6pky/oVthrd5zcVZQa0LItG+1vIw//xjTzZDxWnS2vclxlgRc/g3cujiLyfYctuStF554Q8mB46Hg5sYbPUlz7+knY2zv5zKgwa530yRZMwrlZq16uVhvTOM3BfceoIB+okM2hJxYd6LfiPfB+otK5R52nCerLPoJ6ocz7NzrMsWITALY7wBgVu2JkCOUYWvux4EMqvn7cSPuu2V3bbjHgoOJ3BOf12hT3wp/GJX4YhwtYGHg4i+Hij9hHoReK8ZFSFSADoX6nxlpKgTmwO0j/VILFE7dikK8Yus3CiOS+ElM52flkCoD5Sp0J467cyK9MVuKU15YJXsYfR4FpiS3jHN+V/Jhqphuec65YXiaSyc9tEiDFXyhkOFwSVELDSclDukD5Rhdw3xpKgWkHW+7joqpq5k9Wd6/ZRPSxSm3Im9H2x1ZOqg5xnkAI4+OoRIDkVV3r66/vSRzibw9IarrxZZ3dl9nMkxYpWaHmFxax8wc3qvXZdqajMkq5cjQXIlVbyfr89SWMUlCFue3ver2tal1a6gLbNBumjV0OrgI6U2djc6RfccvLDb4xdO</eBayAuthToken>
</RequesterCredentials>
  <DetailLevel>ReturnAll</DetailLevel>
  <CategoryLevel></CategoryLevel>
</GetCategoriesRequest>';*/


            //Create a new eBay session with all details pulled in from included keys.php
            $session = new eBaySession($devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID, $verb);
            //send the request and get response
            $responseXml = $session->sendHttpRequest($requestXmlBody);
            if(stristr($responseXml, 'HTTP 404') || $responseXml == '')
                die('<P>Error sending request');

            //Xml string is parsed and creates a DOM Document object
            $responseDoc = new DomDocument();
            $responseDoc->loadXML($responseXml);

            $itemArray = $responseDoc->getElementsByTagName('Item');

//            echo $requestXmlBody;
//            echo "<br/><br/><br/>";
//
//
//            echo $responseXml;
            if($itemArray -> length != 0)
            {
//                import each item in the active list
                foreach($itemArray as $item)
                {
                    $itemTitle = $item->getElementsByTagName('Title')->item(0)->nodeValue;

                    importItem($item);
                }
                ?>
                <script type="text/javascript">
                    window.location='<?php echo $PROJECT_PATH;?>listItemPage1.php';
                    </script>
                <?php

            }
            else
            {
//                ?>
//                <script type="text/javascript">
                    window.location='<?php echo $PROJECT_PATH;?>importerPage.php?message=There are no active selling item to import in your eBay account.';
//                    </script>
//                <?php
            }


        }
    }

    function importItem(DOMElement $item)
    {

        $itemTitle = $item->getElementsByTagName('Title')->item(0)->nodeValue;

        $itemDesc = $item->getElementsByTagName('Description')->item(0)->nodeValue;
//        $categoryType
        $buyPrice = $item->getElementsByTagName('BuyItNowPrice')->item(0)->nodeValue;
        $itemPostage = "Fixed Price AUD $".$item->getElementsByTagName('ShippingServiceCost')->item(0)->nodeValue;
        $itemCondition = "Good";
        $itemCategoryID = getMatchedCategory($item->getElementsByTagName('CategoryID')->item(0)->nodeValue, $item->getElementsByTagName('CategoryName')->item(0)->nodeValue);
        $itemVideo = "";
        $sellerID = $_SESSION['userID'];
        
        $itemCatchPhrase= "";
        $bidPrice = $item->getElementsByTagName('CurrentPrice')->item(0)->nodeValue;
        $listDuration = substr($item->getElementsByTagName('ListingDuration')->item(0)->nodeValue,5);
        $listedDate = date("Y-m-d H:i:s");
        $A_DAY_TIMESTAMP = 24*60*60;
        $timeFinish = date("Y-m-d H:i:s", (strtotime($listedDate) + $listDuration * $A_DAY_TIMESTAMP));
        $quantity = $item->getElementsByTagName('Quantity')->item(0)->nodeValue;
        $link = $item->getElementsByTagName('PictureURL')->item(0)->nodeValue;
        $fileName = "itemImages/".substr($itemTitle, 0, 6)."_".date('d-m-Y');
        $fullFileName = "itemImages/full_".substr($itemTitle, 0, 6)."_".date('d-m-Y');
//        $paymentMethods = $item->getElementsByTagName('PaymentMethods')->item(0)->nodeValue;


        $itemTitle = addslashes($itemTitle);
        $itemDesc = addslashes($itemDesc);
        $bidPrice = addslashes($bidPrice);
        $buyPrice = addslashes($buyPrice);
        $itemPostage = addslashes($itemPostage);
        $fileName = addslashes($fileName);
        $fullFileName = addslashes($fullFileName);
        $quantity = addslashes($quantity);


        $conn = dbConnect();
//        // prepare the query for adding new item into database
        $insertSQL = "INSERT INTO item (ItemTitle, ItemCategoryID, Description, Price, Postage, ItemCondition, VideoLink, SellerID, CatchPhrase, currentBid, listDuration, numberOfBid, listedDate, startingBid, timeFinish, Unsold, CategoryType, Quantity)
        VALUE ('$itemTitle',$itemCategoryID,'$itemDesc',$buyPrice,'$itemPostage','$itemCondition','$itemVideo',$sellerID,'$itemCatchPhrase',$bidPrice,$listDuration,0,'$listedDate', $bidPrice, '$timeFinish', 0, 'sub', $quantity)";

        echo $insertSQL."<br/>";
        mysql_query($insertSQL) or die(mysql_error());
        $itemID = mysql_insert_id();

        //download the picture from URL
        //copy the big picture
        $contents = file_get_contents($link);

        $fp = fopen($fullFileName, 'w');
        fwrite($fp, $contents);
        fclose($fp);

        //create a small version of the picture to speed up the page, dimesion of the box contain small picture is 110 x 110 px
        include_once 'SimpleImage.php';
        $smallImage = new SimpleImage();
        $smallImage->load($fullFileName);
        $smallImage->resize(110, 110);
        $smallImage->save($fileName);
//        $smallImage->output();
//        $imageSize =getimagesize($image);
//        $fwidth = $imageSize[0];
//        $fheight = $imageSize[1];

//        if($fwidth > $fheight)
//        {
//            $ratio = 110 /$fheight;
//        }
//        else
//        {
//            $ratio = 110 / $fwidth;
//        }
//
//        //gets the new value and applies the percentage, then rounds the value
//        $small_fwidth = round($fwidth * $ratio);
//        $small_fheight = round($fheight * $ratio);
//
//
//        $small_image_p = imagecreatetruecolor($small_fwidth, $small_fheight);
//        imagefill($small_image_p, 0, 0, $white);
//        imagecopyresampled($small_image_p, $image, 0, $top_offset, 0, 0, $small_fwidth, $small_fheight, $width_orig, $height_orig);
//        file_put_contents($fileName, file_get_contents($link));
//
        //insert the link record to database;
        $insertSQL = "INSERT INTO picturelink (ItemID, PictureLink) VALUE($itemID,'$fileName')";
        mysql_query($insertSQL) or die(mysql_error());

//        //set the pament method specified for items imported from ebay is Paypal (ID: 1)

        $insertSQL = "INSERT INTO itempaymentmethod (ItemID, MethodID) VALUE ($itemID, 1)";

        mysql_query($insertSQL) or die(mysql_error());

        mysql_close($conn);
    }

    function getMatchedCategory($ebayID, $ebayName)
    {

        $ebayName = strtok($ebayName, "&");
        $level1 = strtok($ebayName, ":");

        $level ="";
        while(is_string($level))
        {
            $level = strtok(":");
            if($level)
            {
                $levelList[] = $level;
            }
        }

        //match main category between Twizla and Ebay
        $mainCategoryID = "";

        $conn = dbConnect();
//
        $sql = "SELECT * FROM matchingebaycategory WHERE ebayCategoryName = '".$level1."' ";

        $result = mysql_query($sql) or die(mysql_error());

        if(mysql_num_rows($result) != 0)
        {
            $row = mysql_fetch_array($result);
            $mainCategoryID = $row['CategoryID'];
        }
        else
        {
            $sql = "SELECT * FROM category WHERE CategoryName = '".$level1."'";
            $result = mysql_query($sql) or die(mysql_error());
            if(mysql_num_rows($result) != 0)
            {
                $row = mysql_fetch_array($result);
                $mainCategoryID = $row['CategoryID'];
            }
            else
            {

                //24 is the ID for "Everything else" category;
                $mainCategoryID = 24;
            }
        }
        $level2 = $levelList[0];

        //match level 2 ebayCategory with twizla subCategory
        $sql = "SELECT * FROM matchingebaycategory WHERE ebayCategoryName = '".$level2."'";

        $result = mysql_query($sql) or die(mysql_error());

        if(mysql_num_rows($result) != 0)
        {
            $row = mysql_fetch_array($result);
            $subCategoryID = $row['CategoryID'];
        }
        else
        {
            $sql = "SELECT * FROM subcategory WHERE subCategoryName = '".$level2."' AND CategoryID =".$mainCategoryID;
            $result = mysql_query($sql) or die(mysql_error());
            if(mysql_num_rows($result) != 0)
            {
                $row = mysql_fetch_array($result);
                $subCategoryID = $row['CategoryID'];
            }
            else
            {

                //242 is the ID for "Others" subcategory;
                $subCategoryID = 242;
            }
        }

        mysql_close($conn);

        return $subCategoryID;
    }
?>
