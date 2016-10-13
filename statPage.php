<?php
    session_start();
//    require_once('ebayAPIIncludes/sessionHeader.php');
//    require_once('ebayAPIIncludes/SingleItem.php');
    require_once('ebayAPIIncludes/keys.php');
    require_once('ebayAPIIncludes/eBaySession.php');
    error_reporting(E_ALL);          // useful to see all notices in development

    include("mySQL_connection.inc.php");

    $conn = dbConnect();

    $sql = "SELECT COUNT(*) FROM user";
    
    $result = mysql_query($sql) or die(mysql_error());

    while($row = mysql_fetch_array($result))
    {
         $userAmount = $row[0];
    }

    $ONE_MONTH_TIMESTAMP = 30*24*60*60;
    $compareDate = date("Y-m-d", time() - $ONE_MONTH_TIMESTAMP);
    $sql = "SELECT COUNT(*) FROM user WHERE registerDate  >= '$compareDate'";
    
    $result = mysql_query($sql) or die(mysql_error());

    while($row = mysql_fetch_array($result))
    {
         $oneMonthAmount = $row[0];
    }

    $ONE_DAY_TIMESTAMP = 24*60*60;
    $compareDate = date("Y-m-d", time() - $ONE_DAY_TIMESTAMP);
    $sql = "SELECT COUNT(*) FROM user WHERE registerDate >= '$compareDate'";

    $result = mysql_query($sql) or die(mysql_error());

    while($row = mysql_fetch_array($result))
    {
         $oneDayAmount = $row[0];
    }


    mysql_close();

?>

<!--
    Document   : index.php
    Created on : Dec 22, 2009, 12:36:45 PM
    Author     : Peter
    Description:
        The main page.

    Updated: 12/1/2010
-->


<!Include php files for login, sign up function>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">


        <script type="text/javascript" src="javascripts/main.js"></script>

        <?php
            include("stylesheet.inc.php");
        ?>

    </head>
    <body>
        <div id="content">
            <a href="index.php" style="position: absolute; top: 140px;"><img id="logo" src="webImages/logo.png" alt="Twizla"  border="0"/></a>
            <br><br><br><br><br><br><br><br><br><br><br><br><br><br>
            <div id="middeBorderBoxTop"> </div>
            <div id="middleSection">
                <div id="middleLeftSection">
                    <div id="bigHeading">Twizla members stats:</div>
                    <br>
                    <label>Total number of members: </label><?php echo $userAmount;?>
                    <br><br>
                    <label>Number of new members in the last 30 days: </label><?php echo $oneMonthAmount;?>
                    <br><br>
                    <label>Number of new members in the last 24 hours: </label><?php echo $oneDayAmount;?>
                    <br><br>
                    <!--input type="text" value="" id="email"/>
                    <button onclick="window.location='statPage.php?test=true&email=' + document.getElementById('email').value">Test Email</button-->
                    <button onclick="window.location='statPage.php?test=true'">Test</button>
                


                <div>
                <?php
                   //SiteID must also be set in the Request's XML
                    //SiteID = 0  (US) - UK = 3, Canada = 2, Australia = 15, ....
                    //SiteID Indicates the eBay site to associate the call with
                    $siteID = 15;
                    //the call being made:
                    
                    //Level / amount of data for the call to return (default = 0)
                    $detailLevel = 0;
                    $RuName = "Twizla_Pty_Ltd-TwizlaPt-2e13-4-doslxo";
                    if(isset($_GET['username']))
                    {
                        $eBayUserName = $_GET['username'];
                        //get the token eBay given to this user
                        $verb = 'FetchToken';
                         $requestXmlBody='<?xml version="1.0" encoding="UTF-8"?>
                            <FetchTokenRequest xmlns="urn:ebay:apis:eBLBaseComponents">
                            <SessionID>'.$_SESSION['eBaySessionID'].'</SessionID>
                            </FetchTokenRequest>';

                        //Create a new eBay session with all details pulled in from included keys.php
                        $session = new eBaySession($devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID, $verb);
                        //send the request and get response
                        $responseXml = $session->sendHttpRequest($requestXmlBody);
                        if(stristr($responseXml, 'HTTP 404') || $responseXml == '')
                            die('<P>Error sending request');

                        //Xml string is parsed and creates a DOM Document object
                        $responseDoc = new DomDocument();
                        $responseDoc->loadXML($responseXml);
//                        echo $responseXml;
                        $tokenNode = $responseDoc->getElementsByTagName('eBayAuthToken');
                        $token = $tokenNode->item(0)->nodeValue;

                        //after obtain the token, use it to get the selling list of this user from Ebay
                        $verb = 'GetMyeBaySelling';
                         $requestXmlBody='<?xml version="1.0" encoding="utf-8"?>
                                        <GetMyeBaySellingRequest xmlns="urn:ebay:apis:eBLBaseComponents">
                                        <RequesterCredentials>
                                        <eBayAuthToken>'.$token.'</eBayAuthToken>
                                        </RequesterCredentials>
                                        <Version>663</Version>
                                        <ActiveList>
                                        <Sort>TimeLeft</Sort>
                                        <Pagination><EntriesPerPage>3</EntriesPerPage>
                                        <PageNumber>1</PageNumber>
                                        </Pagination>
                                        </ActiveList>
                                        </GetMyeBaySellingRequest>';

                        //Create a new eBay session with all details pulled in from included keys.php
                        $session = new eBaySession($devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID, $verb);
                        //send the request and get response
                        $responseXml = $session->sendHttpRequest($requestXmlBody);
                        if(stristr($responseXml, 'HTTP 404') || $responseXml == '')
                            die('<P>Error sending request');

                        //Xml string is parsed and creates a DOM Document object
                        $responseDoc = new DomDocument();
//                        $responseDoc->loadXML($responseXml);
                        echo $responseXml;
//                        $tokenNode = $responseDoc->getElementsByTagName('eBayAuthToken');
//                        $token = $tokenNode->item(0)->nodeValue;
//                        var_dump($responseDoc);

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

                        echo "Positive: ".$positive." | Negative: ".$negative." |Neutral: ".$neutral;

                        $totalPoint = $positive - $negative;

                        echo "<br>Total Points: ".$totalPoint;

                    }


                    if(isset($_GET['test']))
                    {
                        $verb = 'GetSessionID';
                        //get the SessionID first
                        $requestXmlBody='<?xml version="1.0" encoding="UTF-8"?>
                            <GetSessionIDRequest xmlns="urn:ebay:apis:eBLBaseComponents">
                            <RuName>'.$RuName.'</RuName>
                            </GetSessionIDRequest>';

                        //Create a new eBay session with all details pulled in from included keys.php
                        $session = new eBaySession($devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID, $verb);
                        //send the request and get response
                        $responseXml = $session->sendHttpRequest($requestXmlBody);
                        if(stristr($responseXml, 'HTTP 404') || $responseXml == '')
                            die('<P>Error sending request');

                        //Xml string is parsed and creates a DOM Document object
                        $responseDoc = new DomDocument();
                        $responseDoc->loadXML($responseXml);
//                        echo $responseXml;
                        $SessionIDNode = $responseDoc->getElementsByTagName('SessionID');
                        $SessionID = $SessionIDNode->item(0)->nodeValue;
                        $_SESSION['eBaySessionID'] = $SessionID;
                        ?>
                        <script>
                            window.location="https://signin.ebay.com/ws/eBayISAPI.dll?SignIn&RuName=<?php echo $RuName?>&SessID=<?php echo $SessionID?>";
                        </script>
                        <?php


                        ///Build the request Xml string to get user token
/*                        $requestXmlBody = '<?xml version="1.0" encoding="utf-8" ?>';
                        $requestXmlBody .= '<GeteBayOfficialTimeRequest xmlns="urn:ebay:apis:eBLBaseComponents">';
                        $requestXmlBody .= "<RequesterCredentials><Username>dougtopyou</Username><Password>wecandoitin10</Password></RequesterCredentials>";
                        $requestXmlBody .= '</GeteBayOfficialTimeRequest>';

                        
                        //Create a new eBay session with all details pulled in from included keys.php
                        $session = new eBaySession($devID, $appID, $certID, $serverUrl, $compatabilityLevel, $siteID, $verb);
                        //send the request and get response
                        $responseXml = $session->sendHttpRequest($requestXmlBody);
                        if(stristr($responseXml, 'HTTP 404') || $responseXml == '')
                            die('<P>Error sending request');

                        //Xml string is parsed and creates a DOM Document object
                        $responseDoc = new DomDocument();
                        $responseDoc->loadXML($responseXml);


                        //get any error nodes
                        $errors = $responseDoc->getElementsByTagName('Errors');

                        //if there are error nodes
                        if($errors->length > 0)
                        {
                            echo '<P><B>eBay returned the following error(s):</B>';
                            //display each error
                            //Get error code, ShortMesaage and LongMessage
                            $code = $errors->item(0)->getElementsByTagName('ErrorCode');
                            $shortMsg = $errors->item(0)->getElementsByTagName('ShortMessage');
                            $longMsg = $errors->item(0)->getElementsByTagName('LongMessage');
                            //Display code and shortmessage
                            echo '<P>', $code->item(0)->nodeValue, ' : ', str_replace(">", "&gt;", str_replace("<", "&lt;", $shortMsg->item(0)->nodeValue));
                            //if there is a long message (ie ErrorLevel=1), display it
                            if(count($longMsg) > 0)
                                echo '<BR>', str_replace(">", "&gt;", str_replace("<", "&lt;", $longMsg->item(0)->nodeValue));

                        }
                        else //no errors
                        {
                            //get the node containing the time and display its contents
                            $eBayTime = $responseDoc->getElementsByTagName('Timestamp');
                            echo '<P><B>The Official eBay Time is ', $eBayTime->item(0)->nodeValue, ' GMT</B>';
                        }*/
//                        include_once 'sendEmail.inc.php';
//                        $subject = "Twizla Unsold item Notification";
//
//                        $content = "<img src='".$PROJECT_PATH."webImages/logo.png' alt='Twizla Logo'/>
//                                                    <br><br><br>
//                                                    Dear ".$seller['FirstName'].",<br>
//                                                    This email is sent by <b>Twizla</b> to inform that the item Number ".$item['ItemID']." ( ".$item['itemTitle'].") has become unsold at ".date('d M Y H:i:s',strtotime($item['timeFinish'])).".
//                                                    <br>
//                                                    Please <a href='".$PROJECT_PATH."myAccountPage.php?page=Sell&tab=3'>re-list the item</a> as soon as posible.
//                                                    <br><br>
//                                                    Sincerely,<br>
//                                                    <b>The Twizla Team</b> ";
//
////                        $subject = "Your friend $firstName has invite you to become a Twizla member";
////                        $content = "<html><head>
////                                      <title>Invitation Email</title>
////                                    </head><body><a href='".$PROJECT_PATH."index.html'><img src='".$PROJECT_PATH."webImages/logo.png' alt='Twizla Logo' style='border: 0;'/></a>
////                                    <br><br><br>
////                                    Good day,<br>
////                                    You has been invited by your friend $firstName $lastName (Email: $email) to become a Twizla member.
////                                    Twizla Online Auction is a place where buying and selling are made fast and easy.
////                                    You can register in less than 15 seconds and start your first 30 seconds listing now, IT'S FREE.<br>
////                                    Buyers can find all kind of products with simple and descriptive information, ready to be won. Twizla will let you taste the joy of buying, selling and online auction in a new experience - Quick and Simple.
////                                    <br>
////                                    Visit us <a href='".$PROJECT_PATH."index.html'>now</a>. We look forward to seeing you around the site.<br><br>
////                                    Sincerely,<br>
////                                    <b>The Twizla Team</b></body></html>";
//                        sendEmail($_GET['email'], $subject, $content);
                    }

                ?>
                    </div>
                </div>
                <?php
                    include("middleRightSection.inc.php");
                ?>
            </div>

            <?php
                include("footerSection.inc.php");
            ?>

    </body>
</html>
