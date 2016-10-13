<?php

class Blog
{
    
    // property declaration
   var $ID;
   var $title;
   var $content;
   var $picture;
   var $date;
   var $commentNo;
   var $commentList;

   function __construct($t, $c, $p) {
        $this->title = $t;
        $this->content = $c;
        $this->picture = $p;
   }

   function __destruct() {
       
   }

   public function save()
   {
       include_once "../mySQL_connection.inc.php";

       $conn = dbConnect();

        $sql = "INSERT INTO `blog` ( `Title` , `Date` , `Desc` , `PictureLink` ) VALUE ('".addslashes($this->title)."','".date('Y-m-d H:i:s')."', '".addslashes($this->content)."', '".addslashes($this->picture)."')";

        mysql_query($sql) or die(mysql_error());
        mysql_close($conn);
   }

   public function update($blogID, $title, $content, $picture)
   {
       include_once "../mySQL_connection.inc.php";

       $conn = dbConnect();

        $sql = "SELECT * FROM `blog` WHERE BlogID = ".$blogID;

        $result = mysql_query($sql) or die(mysql_error());

        $row = mysql_fetch_array($result);
        $oldLink = $row['PictureLink'];

        if($oldLink != "" AND $oldLink != null)
        {
            unlink($oldLink);
        }

        $this->pictureNo = mysql_num_rows($result);

       $sql = "UPDATE `blog` SET `Title` = '".addslashes($title)."', `Date` = '".date('Y-m-d H:i:s')."', `Desc` = '".addslashes($content)."',  `PictureLink` = '".addslashes($picture)."'
                                  WHERE `BlogID` = $blogID";
//                                  echo $sql;
        mysql_query($sql) or die(mysql_error());



        mysql_close($conn);
   }

   public function load($blogID)
   {
       $conn = dbConnect();

        $sql = "SELECT * FROM blog WHERE BlogID = $blogID";

        $result = mysql_query($sql) or die(mysql_error());
        $row = mysql_fetch_array($result);

        $this->ID = $row['BlogID'];
        $this->title = $row['Title'];
        $this->content = $row['Desc'];
        $this->picture = $row['PictureLink'];
        $this->date = $row['Date'];

        $sql = "SELECT * FROM `blog_comment` WHERE blog_comment.BlogID = ".$this->ID;
        //        echo $sql.'<br/><br/>';
        $result = mysql_query($sql) or die(mysql_error());
        
        $this->commentNo = mysql_num_rows($result);

        include_once 'Comment.php';
        if(mysql_num_rows($result) > 0)
        {

            while($row = mysql_fetch_array($result))
            {
                $com = new Comment($row['UserName'], $row['Desc'], $row['blogID'], $row['Date']);
                $this->commentList[] = $com;
            }


        }
        mysql_close($conn);


   }
}
?>
