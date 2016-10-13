<?php
    session_start();
//delete cookies

   setcookie("username","",time() - 60000);
   setcookie("userID","",time() - 60000);


//delete session vars

   unset($_SESSION['username']);
   unset($_SESSION['userID']);
   $_SESSION = array(); // reset session array
   session_destroy();   // destroy session.


   header("HTTP/1.1 301 Moved Permanently");
   header("Location: ".$PROJECT_PATH."index.php");




?>
