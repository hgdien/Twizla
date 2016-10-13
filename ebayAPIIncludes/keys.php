<?php
    //show all errors - useful whilst developing
    error_reporting(E_ALL);

    // these keys can be obtained by registering at http://developer.ebay.com
    
    $production         = true;   // toggle to true if going against production
    $debug              = false;   // toggle to provide debugging info
    $compatabilityLevel = 667;    // eBay API version
    
    //SiteID must also be set in the request
    //SiteID = 0  (US) - UK = 3, Canada = 2, Australia = 15, ....
    //SiteID Indicates the eBay site to associate the call with
    $siteID = 15;
    $referer  = $_SERVER['HTTP_REFERER'];
    if ($production) {
        $devID = '4c55c346-6d55-458c-914f-b23fae62dc7a';   // these prod keys are different from sandbox keys
        $appID = 'TwizlaPt-2e13-4b5f-974d-8307992e4e8b';
        $certID = '4df9c0eb-d567-4407-862c-764deb6ddc2b';
        //set the Server to use (Sandbox or Production)
        $serverUrl   = 'https://api.ebay.com/ws/api.dll';      // server URL different for prod and sandbox
        $shoppingURL = 'http://www.twizla.com.au/';
        
        // This is used in the Auth and Auth flow
        
        // This is an initial token, not to be confused with the token that is fetched by the FetchToken call
        $appToken = '';          
    } else {  
        // sandbox (test) environment
        $devID  = '4c55c346-6d55-458c-914f-b23fae62dc7a';   // insert your devID for sandbox
        $appID  = 'TwizlaPt-f3f5-402a-b7aa-dcf5fafdeb9d';   // different from prod keys
        $certID = '618eb37b-32e7-4cb2-b3af-519ed8828557';   // need three keys and one token
        //set the Server to use (Sandbox or Production)
        $serverUrl = 'https://api.sandbox.ebay.com/ws/api.dll';
        $shoppingURL = 'http://www.twizla.com.au/';

        $loginURL = 'https://signin.sandbox.ebay.com/ws/eBayISAPI.dll'; // This is the URL to start the Auth & Auth process
        $feedbackURL = 'http://feedback.sandbox.ebay.com/ws/eBayISAPI.dll'; // This is used to for link to feedback
        
        $runame = '';  // sandbox runame 
        
        // This is the sandbox application token, not to be confused with the sandbox user token that is fetched.
        // This token is a long string - do not insert new lines. 
        $appToken = '';                 
    }
    
    
?>