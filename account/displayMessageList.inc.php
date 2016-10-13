<?php
   
    function displayMessageList($mesgList, $tab, $unread)
    {
        $PROJECT_PATH = "http://www.twizla.com.au/";

        echo "<table id='listPanel'>";
            $MESG_PER_PAGE = 18;
            $numberOfPage = ceil(count($mesgList) / $MESG_PER_PAGE);
            $startMesgNumber = 0;
            $count = 0;

            if(isset($_GET['pageNumber']))
            {
                $startMesgNumber = ($_GET['pageNumber'] - 1) * $MESG_PER_PAGE;
            }
            
            for($count = $startMesgNumber; $count < count($mesgList); $count ++)
            {
                //only display the allow number of messages per page
                if($count == ($startMesgNumber + $MESG_PER_PAGE))
                {
                    break;
                }
                $message = $mesgList[$count];
                if($message['Status'] == 'unread' AND $unread != "noUnread")
                {
                    echo "<tr style='font-weight:bold;'>";
                }
                else
                {
                    echo "<tr>";
                }
                    echo "<td><input type='checkbox' id='checkBox".$message['MessageID']."' name='messageIDList[]' value='".$message['MessageID']."'/></td>";

                    echo "<td  style='width:30px; padding-left:35px; padding-right:28px;' >";

//                        echo "<form>";
                    if($unread != "noUnread")
                    {
                        if($message['Flagged'] == '1')
                        {
                            echo "<img src='".$PROJECT_PATH."webImages/iconFlagOn.png' id='mesgFlag".$message['MessageID']."' alt='flagImageOn' onclick='setMessageFlag(".$message['MessageID'].")'/> ";
                        }
                        else
                        {
                            echo "<img src='".$PROJECT_PATH."webImages/iconFlagOff.png' id='mesgFlag".$message['MessageID']."' alt='flagImageOff' onclick='setMessageFlag(".$message['MessageID'].")'/> ";
                        }
                    }
//                        echo "</form>";
                    echo "</td>";
                    echo "<td><div style='width:140px;'>";
                        if(strlen($message['UserName']) > 20)
                        {
                            echo substr($message['UserName'], 0, 16)."...";
                        }
                        else
                        {
                            echo $message['UserName'];
                        }

                    echo "</div></td>";
                    echo "<td><div style='width:300px;'>";
                        echo "<a class='messageLink' href='".$PROJECT_PATH."account/mail/".$tab."/".$message['MessageID']."/' >".$message['Subject']."</a>";

                    echo "</div></td>";

                    echo "<td><label style='left:390px;'>".date('d-M-Y',strtotime($message['ProcessDate']))."</label></td>";

                echo "</tr>";
            }
        echo "</table>";

        //Show the page bar if there is more pages of messages to display on the screen.
        if($numberOfPage > 1)
        {
            echo "<ul id='pageBar'>";
            echo "<li style='border:0'><b>Page</b></li>";
            //set the pageBar depend on the current page
            //increase the pageBar numbers when the current page > 5
            if(isset($_GET['pageNumber']) & $_GET['pageNumber'] > 5)
            {
                //add 3 page links on the left of the current page
                $pageBarStart = $_GET['pageNumber'] - 3;

                echo "<li><a href='".$PROJECT_PATH."/account/mail/".$tab."&page1/' style='text-decoration: none; color:#213155;'>1</a></li>";
                echo "<li>... |</a></li>";
            }
            else
            {
                $pageBarStart = 1;
            }

            for ($count = $pageBarStart; $count <= $numberOfPage; $count++)
            {
                //stop when there is 3 page link on the right of the current page
                if($count > ($pageBarStart + 6))
                {
                    //if there is more than 1 page link still not display, then add ...
                    if(($count + 1 ) < $numberOfPage)
                    {
                        echo "<li>...</a></li>";
                        echo "<li style='border:0;'>
                                <a href='".$PROJECT_PATH."/account/mail/".$tab."&page$numberOfPage/' style='text-decoration: none; color:#213155;'> $numberOfPage</a>
                            </li>";
                    }
                    //if there is still hidden page link then insert the next page button
                    if($count < $numberOfPage)
                    {
                        echo "<a href='".$PROJECT_PATH."/account/mail/".$tab."&page".($_GET['pageNumber'] + 1)."/'><img src='".$PROJECT_PATH."webImages/pageBarButton.png' border='0'/>";
                    }
                    break;
                }
                //bold format the current page
                if($count == $_GET['pageNumber'])
                {
                    echo "<li style='text-decoration:underline; color:#213155; '>
                            <a href='".$PROJECT_PATH."/account/mail/".$tab."&page$count/' >$count</a>
                        </li>";
                }
                else
                {
                    echo "<li>
                            <a href='".$PROJECT_PATH."/account/mail/".$tab."&page$count/' style='text-decoration: none; color:#213155;'>$count</a>
                        </li>";
                }

            }
            echo "</ul>";
        }

    }
?>
