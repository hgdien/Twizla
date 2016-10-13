<?php
    session_start();
    include("../mySQL_connection.inc.php");
    include("../login.php");

    include("../loadHome.php");

?>

<!--
    Document   : contactPage.php
    Created on : Jan 27, 2010, 12:36:45 PM
    Author     : Peter
    Description:
        The main page.

    Updated: 27/1/2010


-->

<?php


?>




<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">


<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

        <script type="text/javascript" src="<?php echo $PROJECT_PATH;?>javascripts/main.js"></script>

        <?php
            include("../stylesheet.inc.php");
        ?>
    </head>
    <body>
        <?php
            include("../headSection.inc.php");
        ?>

            <div id="middleSection">
                <div id="middleLeftSection">
                    <div id ="bigHeading">Contact Us</div>
                    <br/>
                    <!display the help content>
                    <label class="colorLabel">Please feel free to contact us anytime with questions;
                        we will endeavour to reply within 48 hours of your request. Or check out our <a class="helpLink" href="<?php echo $PROJECT_PATH;?>help/">Help section</a> for onsite support
                    </label>
                    <br/><br/>
                    <form id="contactForm" action="<?php echo $PROJECT_PATH;?>help/submitContact.php" method="POST">
                        <input id="type" type="hidden" name ="submitContact" value="true"/>
                        <table>
                            <!--tr>
                                <td colspan="3" style="color: #213155; font-size: 17px; font-weight: bold;">Start selling and buying today!<br/>It's take less than 20 seconds</td>
                            </tr-->

                            <tr>
                                <td class="label">Full Name:</td>
                                <td></td>
                                <td><input type="text" class="inputtext" id="contact_name" name="contact_name" size="40" maxlength="40" value="<?php if(isset($_GET['contact_name'])) {echo $_GET['contact_name'];}?>" />
                                </td>
                            </tr>

                            <tr>
                                <td class="label">Email:</td>
                                <td></td>
                                <td><input type="text" class="inputtext" id="contact_email" name="contact_email" size="40" maxlength="40" value="<?php if(isset($_GET['contact_email'])) {echo $_GET['contact_email'];}?>" />
                                </td>
                            </tr>
                            <tr>
                                <td class="label">Question/Query:</td>
                                <td></td>
                                <td>
                                    <textarea rows="5" cols="32" id="contact_message" name="contact_message"  style="width: 275px;"
                                              onKeyDown="limitText(this.form.contact_message,1000);" onKeyUp="limitText(this.form.contact_message,1000);"><?php if(isset($_GET['contact_message'])) {echo $_GET['contact_message'];}?>
                                    </textarea>
                                </td>

                            </tr>
                            <tr>
                                <td class="label">Captcha:</td>
                                <td></td>
                                <td>

                                    <div style="width: 430px; float: left; height: 90px">
                                          <img id="siimage" align="left" style="margin-right: 5px; border: 1px solid #c4c4c4;" src="<?php echo $PROJECT_PATH;?>captcha/securimage_show.php?sid=<?php echo md5(time()) ?>" />

                                                <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0" width="19" height="19" id="SecurImage_as3" align="middle">
                                                    <param name="allowScriptAccess" value="sameDomain" />
                                                    <param name="allowFullScreen" value="false" />
                                                    <param name="movie" value="captcha/securimage_play.swf?audio=securimage_play.php&bgColor1=#777&bgColor2=#fff&iconColor=#000&roundedCorner=5" />
                                                    <param name="quality" value="high" />

                                                    <param name="bgcolor" value="#ffffff" />
                                                    <embed src="<?php echo $PROJECT_PATH;?>captcha/securimage_play.swf?audio=securimage_play.php&bgColor1=#777&bgColor2=#fff&iconColor=#000&roundedCorner=5" quality="high" bgcolor="#ffffff" width="19" height="19" name="SecurImage_as3" align="middle" allowScriptAccess="sameDomain" allowFullScreen="false" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
                                                  </object>
                                                <br />

                                                <!-- pass a session id to the query string of the script to prevent ie caching -->
                                                <a tabindex="-1" style="border-style: none" href="#" title="Refresh Image" onclick="document.getElementById('siimage').src = '<?php echo $PROJECT_PATH;?>captcha/securimage_show.php?sid=' + Math.random(); return false"><img src="<?php echo $PROJECT_PATH;?>captcha/images/refresh.gif" alt="Reload Image" border="0" onclick="this.blur()" align="bottom" /></a>
                                    </div>
                                    <input type="text" name="code" size="12" style="width: 200px;"/><br/>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td>
                                    <!input id="button2" name="signUpSubmit" type="submit" value="Sign Up"/>
                                    <img id="buttonImage" src="<?php echo $PROJECT_PATH;?>webImages/submitbutton.png" alt="submitButton" onclick="document.getElementById('contactForm').submit()"/>
                                </td>
                            </tr>
                        </table>

                    <p id="message" ><?php

        //              Display any available error message
                        if(isset($_GET['message']) AND count($_GET['message']) > 0)
                        {
                            //Separate the message String and display them
                            $text = strtok($_GET['message'],'|');
                            echo "--> ".$text."<br/>";

                            while(is_string($text))
                            {
                                $text = strtok("|");
                                if($text)
                                {
                                    echo "--> ".$text."<br/>";
                                }
                            }
                        }
                    ?></p>
                    </form>
                </div>
                <!--label style='color:blue;'>".$item['total_value']." stars.</label-->

            <?php

                include("../middleRightSection.inc.php");

            ?>

            </div>


            <?php
                include("../footerSection.inc.php");
            ?>

    </body>
</html>
