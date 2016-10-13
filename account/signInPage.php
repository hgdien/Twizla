<?php
    session_start();
    include("../mySQL_connection.inc.php");
    include("../login.php");

    include("../loadHome.php");

?>

<!--
    Document   : signInPage.php
    Created on : Jan 29, 2010, 12:36:45 PM
    Author     : Peter
    Description:
        The selling page.

    Updated: 28/6/2010


-->


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">


<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml">
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

                    <?php
                        if(!isset($_SESSION['username']))
                        {
                    ?>
                            <div id="bigHeading">Sign in to your account</div>
                    <?php
                        }
                        else
                        {
                            ?>
                            <div id="bigHeading">Sign in as a different user</div>
                            <?php
                        }
                    ?>
                    <br/><br/>
                    <form id="loginForm" action="" method="POST">
                        <input type="hidden" name="loginSubmit" value="yes"/>
                        <table>
                            <tr>
                                <tr>
                                    <td class="label">Email:</td>
                                    <td></td>
                                    <td><input type="text" class="inputtext" id="email" name="email" size="50" maxlength="50" />
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label">Password:</td>
                                    <td></td>
                                    <td><input type="password" class="inputtext" id="password" name="password" size="50" maxlength=50" />
                                        
                                    </td>
                                </tr>
                        </table>
                        <a href="<?php echo $PROJECT_PATH;?>account/forgotPasswordPage.php" id="forgotPasswordLink">Forgot your password?</a>
                        <br/>

                        <div id="rememberMeBox"><input type="checkbox" name="rememberMe"/> <b>Remember me.</b><br/> Don't check this box if you're at a public or shared computer.</div>
                        <div style="float: right;">
                        <img id="buttonImage" src="<?php echo $PROJECT_PATH;?>webImages/loginbutton.png" alt="loginbutton" onclick="document.getElementById('loginForm').submit()" onmouseover="this.src='<?php echo $PROJECT_PATH;?>webImages/login_hover.png'" onmouseout="this.src='<?php echo $PROJECT_PATH;?>webImages/loginbutton.png'"
                         onmousedown="this.src='<?php echo $PROJECT_PATH;?>webImages/login_down.png'" onmouseup="this.src='<?php echo $PROJECT_PATH;?>webImages/loginbutton.png.png'" />
                         </div>
                        <br/>
                        <div id="loginMessageBox"><?php echo $loginMessage;?></div>

                        <!Hide the register button and the forgotPassword link when the user logged in>

                                

                    </form>


                    <div id="fbLoginBox">
                        <label class="colorLabel"> Have a Facebook account?</label><br/><br/><br/>


                        <img src="../webImages/FB_Login_Button.png" border="0" style="cursor:pointer;" alt="FacebookLoginButton"
                             onclick="window.open('<?php echo $facebook->getLoginUrl(array(  'display' => 'popup',
                                                                                'fbconnect' => 1,
                                                                                'next' => $PROJECT_PATH.'FBLogin.php?login_success=true',
                                                                                'cancel_url'=> $PROJECT_PATH.'FBLogin.php?close=true',
                                                                                'req_perms' => 'email, read_friendlists'));?>','FacebookLogin','width= 700, height= 350, left= 500, top= 200')" />

                        <!--fb:login-button perms="email" background="dark" length="long" v="2"><fb:intl>Connect with Facebook</fb:intl></fb:login-button>
                        <script type="text/javascript">  FB.init("752f25119c6dc6e9b20f473dee30ee5f", "<?php //echo $PROJECT_PATH;?>xd_receiver.htm"); </script-->
                    </div>
            </div>
        <?php
            include("../footerSection.inc.php");
        ?>
    </body>
</html>
