<?php
    session_start();
    require_once('keys.php');
    require_once('eBaySession.php');
    error_reporting(E_ALL);          // useful to see all notices in development

   //SiteID must also be set in the Request's XML
    //SiteID = 0  (US) - UK = 3, Canada = 2, Australia = 15, ....
    //SiteID Indicates the eBay site to associate the call with
    $siteID = 15;
    //the call being made:

    //Level / amount of data for the call to return (default = 0)
    $detailLevel = 0;

    


    //if there is a sessionID, start getting the eBay authorization Token
    if(isset($_GET['username']))
    {

        $eBayUserName = $_GET['username'];
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
    }
    else
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
        header("HTTP/1.1 301 Moved Permanently");
        header("Location:https://signin.ebay.com/ws/eBayISAPI.dll?SignIn&RuName=$RuName&SessID=$SessionID");

    }

?>



