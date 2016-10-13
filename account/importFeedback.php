<?php
    session_start();
    include("mySQL_connection.inc.php");

    //first check if the user have already import their EBay Feedback before
    $conn = dbConnect();
    $selectSQL = "SELECT * FROM ebay_imported_list WHERE UserID = ".$_SESSION['userID'];

    $result = mysql_query($selectSQL) or die(mysql_error());

    //if user have already imported in the past, user is trying to access importer
    //illegally, go back to main page
    if(mysql_num_rows($result))
    {
        header("HTTP/1.1 301 Moved Permanently");
       header("Location: ".$PROJECT_PATH."index.php");
    }
    else
    {
        //set the RuName, RuName are associated with which page the eBay Consent Form
        //will be directed to 
        $RuName = "Twizla_Pty_Ltd-TwizlaPt-2e13-4-doslxo";
        //get the EBayAuthorized Token
        include_once 'ebayAPIIncludes/eBayImporter.php';
        
        if($token)
        {
            //get user feedback from eBay
            $verb = 'GetFeedback';
             $requestXmlBody='<?xml version="1.0" encoding="utf-8"?>
                                <GetFeedbackRequest xmlns="urn:ebay:apis:eBLBaseComponents">
                                <RequesterCredentials>
                                <eBayAuthToken>'.$token.'</eBayAuthToken>
                                </RequesterCredentials>
                                  <UserID>'.$eBayUserName.'</UserID>
                                </GetFeedbackRequest>';

            //Create a new eBay session with all details pulled in from included keys.php
            $session = new eBaySession($devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID, $verb);
            //send the request and get response
            $responseXml = $session->sendHttpRequest($requestXmlBody);
            if(stristr($responseXml, 'HTTP 404') || $responseXml == '')
                die('<P>Error sending request');

            //Xml string is parsed and creates a DOM Document object
            $responseDoc = new DomDocument();
            $responseDoc->loadXML($responseXml);
            $negativeNode = $responseDoc->getElementsByTagName('UniqueNegativeFeedbackCount');
            $negative = $negativeNode->item(0)->nodeValue;
            $positiveNode = $responseDoc->getElementsByTagName('UniquePositiveFeedbackCount');
            $positive = $positiveNode->item(0)->nodeValue;
            $neutralNode = $responseDoc->getElementsByTagName('UniqueNeutralFeedbackCount');
            $neutral = $neutralNode->item(0)->nodeValue;

            $totalPoint = $positive - $negative;

            //get the current feedback point
            $selectSQL = "SELECT feedbackPoint FROM user WHERE UserID = ".$_SESSION['userID'];
            $result = mysql_query($selectSQL) or die(mysql_error());
            $row = mysql_fetch_array($result);

            $totalPoint = $totalPoint + $row['feedbackPoint'];

            //update feedback point
            $sql = "UPDATE user SET FeedbackPoint = $totalPoint WHERE UserID = ".$_SESSION['userID'];
            mysql_query($sql) or die(mysql_error());

            //insert the ebayImport record
            $sql = "INSERT INTO ebay_imported_list (UserID, Date, FeedbackPoint) VALUE (".$_SESSION['userID'].",'".date("Y-m-d")."', $totalPoint)";
            
            mysql_query($sql) or die(mysql_error());
            ?>
            <script type="text/javascript">
                window.location='viewUserProfilePage.php?UserName=<?php echo $_SESSION['username']?>';
                </script>
            <?php

        }
    }
?>
