<?php

class Comment
{
    
    // property declaration
   var $ID;
   var $blogID;
   var $username;
   var $comment;
   var $date;

   function __construct($n, $c, $b, $d) {
        $this->username = $n;
        $this->comment = $c;
        $this->blogID = $b;
        $this->date = $d;

   }

   function __destruct() {
       
   }

   public function save()
   {
       

       $conn = dbConnect();

        $sql = "INSERT INTO `blog_comment` (`BlogID` , `UserName` , `Desc` , `Date` ) VALUE ($this->blogID, '".addslashes($this->username)."', '".addslashes($this->comment)."', '$this->date')";

        mysql_query($sql) or die(mysql_error());
        mysql_close($conn);
   }


      public function load($commentID)
   {
        $conn = dbConnect();

        $sql = "SELECT * FROM blog_comment WHERE CommentID = $commentID";

        $result = mysql_query($sql) or die(mysql_error());
        $row = mysql_fetch_array($result);
        $this->ID = $row['CommentID'];
        $this->username = $row['UserName'];
        $this->comment = $row['Desc'];
        $this->blogID = $row['BlogID'];
        $this->date = $row['Date'];

        mysql_close($conn);


   }
}
?>
