<?php
//put the project path for redirecting paths later

    $PROJECT_PATH = "http://localhost/Twizla/";
    $SECURE_PATH = "https://localhost/Twizla/";

    //set the default timezone for all function that require date() function
    date_default_timezone_set('Australia/NSW');

function dbConnect()
{
  $conn = mysql_connect('localhost',"admin","password") or die ('Cannot connect to server');
  mysql_select_db("twizla",$conn) or die ('Cannot open database');
  return $conn;
  }

?>
