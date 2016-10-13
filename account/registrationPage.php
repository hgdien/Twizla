<?php
    session_start();
    include("../mySQL_connection.inc.php");
    include("../login.php");

    include("../loadHome.php");

?>

<!--
    Document   : registrationPage.php
    Created on : Jan 27, 2010, 12:36:45 PM
    Author     : Peter
    Description:
        The registration page.

    Updated: 27/6/2010


-->
<?php
    if(isset($_GET['newUser']))
    {
        
        
        $subject = "Twizla Account Verification";

        //set verification message

        $content = "<html><head>
                      <title>Registration Email</title>
                    </head><body><a href='".$PROJECT_PATH."'><img src='".$PROJECT_PATH."webImages/logo.png' alt='Twizla Logo' style='border: 0;'/></a>
                    <br><br><br>
                    Dear ".$_GET['newUser'].",<br>
                    Welcome and thanks for joining <b>Twizla</b> ! Now that you are a member, you can easily sell and buy products, or give feedback and have your voice heard.<br>
                    To find and edit your reviews or update your contact information, go to your <a href='".$SECURE_PATH."myAccountPage.php?page=Account'>profile page</a>.<br>
                    Need help? Still have questions? Try our <a href='".$PROJECT_PATH."helpPage.php'>Help Page</a>.<br>
                    We look forward to seeing you around the site.<br><br>
                    Sincerely,<br>
                    <b>The Twizla Team</b></body></html>";
    //        echo $email;

        include_once '../sendEmail.inc.php';
        sendEmail($_GET['email'], $subject, $content);

    }

    // create connection and connect to the Twizla database
    $conn = dbConnect();

    // get the list of category from database
    $sql = "SELECT * FROM state_country ORDER BY State_CountryName";

    $result = mysql_query($sql) or die(mysql_error());

    while($row = mysql_fetch_array($result))
    {
        $stateList[] = $row;
    }

    mysql_close($conn);


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
                <div style="margin-left: 250px;">
                    <?php
                        if(isset($_GET['newUser']))
                        {
    //                         var_dump($_GET);

                    ?>
                        <div id="bigHeading">Verify Your Email Address</div>
                        <div id="confirmMessageBox">
                            <div id="confirmMessage">
                            <div id="bigHeading">Welcome <?php echo $_GET['newUser']?>! Your account has been activated.</div>
                            You can now login with your registered account.
                            </div>
                        </div>

                        <!--
                                            We strongly recommend that you verify your email address associated with your Twizla account.
                            To verify, please click on <a href="registrationPage.php?newUser=<?php //echo $_GET['newUser']?>&email=<?php //echo $_GET['email']?>">Send email verification link</a>.<br/>-->
                    <?php

                        }
                        else
                        {
                    ?>
                        <form id="registrationBox" action="<?php echo $SECURE_PATH;?>account/signup.php" method="POST">
                            <input type="hidden" name="signUpSubmit" value="true" />
                            <table>
                                <tr>
                                    <td colspan="3"><div id="bigHeading">Registration </div></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="3"><p style="color: #213155; font-size: 16px;">Twizla.com.au is a simple and <u><b>FREE</b></u> service that makes buying and selling fun !</p></td>

                                </tr>
                                <tr>
                                    <td class="label">First Name:</td>
                                    <td></td>
                                    <td><input type="text" class="inputtext" id="firstName" name="firstName" size="40" maxlength="40" value="<?php if(isset($_GET['firstName'])) {echo $_GET['firstName'];}?>" />
                                    </td>
                                </tr>

                                <tr>
                                    <td class="label">Last Name:</td>
                                    <td></td>
                                    <td><input type="text" class="inputtext" id="lastName" name="lastName" size="40" maxlength="40" value="<?php if(isset($_GET['lastName'])) {echo $_GET['lastName'];}?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label">UserName:</td>
                                    <td></td>
                                    <td><input type="text" class="inputtext" id="username" name="username" size="40" maxlength="20" value="<?php if(isset($_GET['username'])) {echo $_GET['username'];}?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label">Your Email:</td>
                                    <td></td>
                                    <td><input type="text" class="inputtext" id="reg_email" name="reg_email" size="40" maxlength=40" value="<?php if(isset($_GET['email'])) {echo $_GET['email'];}?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label">Password:</td>
                                    <td></td>
                                    <td><input type="password" class="inputtext" id="reg_password" name="reg_password" size="40" maxlength="40" value=""/>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label">Re-type Password:</td>
                                    <td></td>
                                    <td><input type="password" class="inputtext" id="reg_password" name="reType_reg_password" size="40" maxlength="40" value=""/>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label">State:</td>
                                    <td></td>
                                    <td>
                                        <select id="state" name="state" style="width:225px;" >
                                            <?php
                                                foreach($stateList as $state)
                                                {
                                                    echo "<option>".$state['State_CountryName']."</option>";
                                                }
                                            ?>
                                        </select>
                                    </td>
                                </tr>
                                <?php
                                if(isset($_GET['state']))
                                {
                                ?>
                                    <script type="text/javascript">

                                        var state = document.getElementById("state");
                                        var exist = "<?php echo $_GET['state'];?>";
                                        
                                        for( i = 0;i < state.length ; i++)
                                        {

                                            if(state.options[i].value==exist)
                                            {
                                                state.selectedIndex = i;
                                            }
                                        }
                                    </script>
                                <?php
                                }
                                ?>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td>
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3"><div style="color: #213155; font-size: 16px;"><b>A Quick Quiz</b> (Optional)</div></td>
                                </tr>
                                <tr>
                                    <td colspan="3"><div style="color: #213155; font-size: 14px;">How did you hear about Twizla ?</div></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <select id="source" name="source" style="width:225px;" >
                                            <option>Friend</option>
                                            <option>Google</option>
                                            <option>Magazine</option>
                                        </select>
                                    </td>
                                </tr>
                                <?php
                                if(isset($_GET['knowingSource']))
                                {
                                ?>
                                    <script type="text/javascript">
                                        var source = document.getElementById("source");
                                        var exist = "<?php echo $_GET['knowingSource'];?>";

                                        for( i = 0;i < source.length ; i++)
                                        {
                                            if(source.options[i].value==exist)
                                            {
                                                source.selectedIndex = i;
                                            }
                                        }
                                    </script>
                                <?php
                                }
                                ?>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td>
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3"><div style="color: #213155; font-size: 16px;"><b>Tell your friends about Twizla</b> (Optional)</div></td>
                                </tr>
                                <tr>
                                    <td colspan="3"><div style="color: #213155; font-size: 14px;">Why not invite your friends to Twizla for a new online auction experience?</div></td>
                                </tr>
                                <tr>
                                    <td class="label">Friend Email 1:</td>
                                    <td></td>
                                    <td><input type="text" class="inputtext" id="friendEmail1" name="friendEmail1" size="40" maxlength="40" value="<?php if(isset($_GET['friendEmail1'])) {echo $_GET['friendEmail1'];}?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label">Friend Email 2:</td>
                                    <td></td>
                                    <td><input type="text" class="inputtext" id="friendEmail2" name="friendEmail2" size="40" maxlength="40" value="<?php if(isset($_GET['friendEmail2'])) {echo $_GET['friendEmail2'];}?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label">Friend Email 3:</td>
                                    <td></td>
                                    <td><input type="text" class="inputtext" id="friendEmail3" name="friendEmail3" size="40" maxlength="40" value="<?php if(isset($_GET['friendEmail3'])) {echo $_GET['friendEmail3'];}?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <!input id="button2" name="signUpSubmit" type="submit" value="Sign Up"/>
                                        <img id="buttonImage" src="<?php echo $PROJECT_PATH;?>webImages/signupbutton.png" alt="signupButton" onclick="document.getElementById('registrationBox').submit()"/>
                                    </td>
                                </tr>
                            </table>
                        </form>
                            <p id="message"><?php

                //              Display any available error message
                                if(isset($_GET['message']) AND count($_GET['message']) > 0 AND !isset($newUser))
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

                    <?php
                        }
                    ?>
                        <img src="<?php echo $PROJECT_PATH;?>webImages/sslgrey.png" alt="SSLGreyIcon" style="bottom: 0px; left: 40px;"/>
                </div>
                


            </div>
        <?php
            include("../footerSection.inc.php");
        ?>
    </body>
</html>
