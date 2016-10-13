<?php
    
    function displayMessageContent($message, $tab, $hasButton)
    {
        $PROJECT_PATH = "http://www.twizla.com.au/";
        if($hasButton)
        {
            ?>
            <form id='messageForm' action='deleteMessage.php' method='POST'>
                <input type='hidden' name='messageID' value="<?php echo $message['MessageID'];?>" />
                <input type='hidden' name='tab' value="<?php echo $tab?>" />

                <img id='buttonImage' src="<?php echo $PROJECT_PATH;?>webImages/backbutton.png" alt="BackButton" onclick="window.location='<?php echo $PROJECT_PATH;?>account/mail/1/'"/>
                <img id='buttonImage' src="<?php echo $PROJECT_PATH;?>webImages/replybutton.png" alt="ReplyButton"  onclick="window.location='<?php echo $PROJECT_PATH;?>user/<?php echo $message['UserName'];?>/contact'"/>
                <img id='buttonImage' src="<?php echo $PROJECT_PATH;?>webImages/deletebutton.png" alt="DeleteButton"  onclick="window.location='deleteMessage.php?MessageID=<?php echo $message['MessageID'];?>'"/>
            </form>
            <div style='height:17px;'></div>
            <?php
        }
        else
        {
            echo "<div style='height:43px;'></div>";
        }
//            echo "<select id='moveToSelection' style='margin-left:20px; margin-right:20px;' onchange='"."moveMessageTo(this[this.selectedValue].value)"."'>
//            <option> --Move to-- </option>";
//            foreach($_SESSION['$folderList'] as $folder)
//            {
//                echo "<option>".$folder['FolderName']."</option>";
//            }
//            echo "</select>";
        echo "<div id='MessageBox'>";
            echo "<div style='background-color:#c4c4c4; padding-left:5px; border: 1px solid;' >";
                if($message['Flagged'] == '1')
                {
                    echo "<img src='".$PROJECT_PATH."webImages/iconFlagOn.png' style='margin-right:5px; margin-bottom:-8px;'/>";
                }
                else if($message['Flagged'] == '0')
                {
                    echo "<img src='".$PROJECT_PATH."webImages/iconFlagOff.png' style='margin-right:5px; margin-bottom:-8px;'/>";
                }
                echo "<label style='font-weight:bold;'>".$message['Subject']." - ".date('d/m/Y',strtotime($message['ProcessDate']))."</label><br>";
                echo "<label>From: </label>".$message['UserName'];
            echo "</div>";
//            echo "<br/>";
            echo "<div id='messageContent'>";
                echo str_replace("\n","<br/>",$message['Content']);
            echo "</div>";
        echo "</div>";
    }

?>
