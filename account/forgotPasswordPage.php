<?php
    session_start();
    include("../mySQL_connection.inc.php");
    include("../login.php");
    include('../loadHome.php');
?>

<!--
    Document   : forgotPasswordPage.php
    Created on : Jan 28, 2010, 12:36:45 PM
    Author     : Peter
    Description:
        The main page.

    Updated: 28/1/2010
-->


<!Include php files for login, sign up function>


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
                    <?php
                        if(isset($_GET['updatePassword']))
                        {
                    ?>
                            <form id="updatePasswordForm"action="updatePassword.php" method="POST">
                                <input type="hidden" name ="submitUpdatePassword" value="true"/>
                                <input type="hidden" name="email" value="<?php echo $_GET['email'];?>" />
                                <table>
                                    <tr>
                                        <td colspan="3"><div id="bigHeading">Change your Password</div></td>
                                    </tr>

                                    <tr>
                                        <td colspan="3"><p style="color: #213155; font-size: 14; margin-top: 5px;">Please enter the temporary password and your new password below. </p></td>
                                    </tr>

                                    <tr><td colspan="3"></td></tr>
                                    <tr>
                                        <td class="label">Temporary Password:</td>
                                        <td><pre> </pre></td>
                                        <td><input type="password" class="inputtext" id="pw" name="pw" size="40" maxlength="40" value="<?php echo $_GET['pw'];?>" />
                                        </td>
                                    </tr>

                                    <tr><td colspan="3"></td></tr>
                                    <tr>
                                        <td class="label">New Password:</td>
                                        <td><pre> </pre></td>
                                        <td><input type="password" class="inputtext" id="newPw" name="newPw" size="40" maxlength="40" value="" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="label">Re-type new Password:</td>
                                        <td><pre> </pre></td>
                                        <td><input type="password" class="inputtext" id="reTypePw" name="reTypePw" size="40" maxlength="40" value="" />
                                        </td>
                                    </tr>
                                    <tr><td colspan="3"></td></tr>
                                    <tr>
                                        <td></td>
                                        <td><pre> </pre></td>
                                        <td>
                                            <!input id="button2" name="signUpSubmit" type="submit" value="Save" style=""/>
                                            <img id="buttonImage" src="<?php echo $PROJECT_PATH;?>webImages/signupbutton.png" alt="SignUpButton" onclick="document.getElementById('updatePasswordForm').submit()"/>
                                        </td>
                                    </tr>
                                </table>
                            </form>

                    <?php
                        }
                        else
                        {
                    ?>
                            <form id="sendPasswordForm" action="sendPasswordEmail.php" method="POST">
                                <input id="type" type="hidden" name ="submitSendPassword" value="true"/>
                                <table>
                                    <tr>
                                        <td colspan="3"><div id="bigHeading">Trouble logging in?</div></td>

                                    </tr>

                                    <tr>
                                        <td colspan="3"><p style="color: #213155; font-size: 14; margin-top: 5px;">Enter the email you used to register below. We will send you an email to reset your password.</p></td>
                                    </tr>

                                    <tr><td colspan="3"></td></tr>
                                    <tr>
                                        <td class="label">Registration Email:</td>
                                        <td><pre> </pre></td>
                                        <td><input type="text" class="inputtext" id="email" name="email" size="40" maxlength="20" value="<?php echo $_GET['email']?>" />
                                        </td>
                                    </tr>

                                    <tr><td colspan="3"></td></tr>

                                    <tr>
                                        <td></td>
                                        <td><pre> </pre></td>
                                        <td>
                                            <!input id="bigButton2" name="signUpSubmit" type="submit" value="Send Password" style="width: 125px;"/>
                                            <img id="buttonImage" src="<?php echo $PROJECT_PATH;?>webImages/sendpasswordbutton.png" alt="SendPasswordButton" onclick="document.getElementById('sendPasswordForm').submit()"/>
                                        </td>
                                    </tr>
                                </table>
                            </form>
                    <?php
                        }
                    ?>

                    <div id="message" style="margin-left: 80px;"><?php if(isset($_GET['message'])) echo $_GET['message']; ?></div>


                </div>

                <?php
                    include("../middleRightSection.inc.php");
                ?>
            </div>

            <?php
                include("../footerSection.inc.php");
            ?>

    </body>
</html>
