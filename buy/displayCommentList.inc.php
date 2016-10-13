<?php
    function displayCommentList($itemID)
    {
        $conn = dbConnect();
        //get the list of comment given to this item
        $sql =" SELECT * FROM comment, user WHERE comment.UserID = user.UserID AND ItemID = ".$itemID." ORDER BY Time DESC";

        $result = mysql_query($sql) or die(mysql_error());;

        while($row = mysql_fetch_array($result))
        {
             $commentList[] = $row;
        }

        mysql_close($conn);
        
        if(count($commentList) > 0)
        {
            echo "<ul style='padding-left: 0px; list-style=none; margin-left: 0px; ' >";
            echo "<li>";
            foreach($commentList as $comment)
            {
            ?>
                <table style="width: 500px; font-size: 13px;">
                    <tr>
                        <td style="font-weight: bold; width: 330px;">
                            <a href='<?php echo $PROJECT_PATH."user/".$comment['UserName']."/";?>'><?php echo $comment['UserName'];?></a>
                        </td>
                    <td>
                        <?php echo date('d M Y H:i:s',strtotime($comment['Time']));?>
                    </td>
                </tr>
                    <tr>
                        <td colspan="2">
                            <div>
                                <?php echo $comment['Comment'];?>
                            </div>
                        </td>
                    </tr>
                    <tr><td colspan='3' bgcolor='#c4c4c4' width='0.5'></td></tr>
                </table>
            <?php
            }
            echo "</li>";
        }
        else
        {
            echo "This item has no comment.";
        }
    }
?>
