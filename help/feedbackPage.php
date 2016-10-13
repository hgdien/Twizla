<?php
    session_start();
    include("../mySQL_connection.inc.php");
    include("../login.php");
    include('../loadHome.php');
?>

<!--
    Document   : feedbackPage.php
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
                        if(!$_SESSION['userID'])
                        {
                    ?>
                            <div id="bigHeading">
                                You must login to view this page.<br/>
                                Don't have a Twizla account? <br/>
                               <a href="<?php echo $SECURE_PATH;?>registration/">Register</a> in 30 seconds and start listing and checking products.
                            </div>

                    <?php

                        }
                        else if(isset($_GET['submit']))
                        {
                    ?>
                            <div id="bigHeading" style="margin-left: 10px;"><?php if(isset($_GET['message'])) echo $_GET['message']; ?></div>

                    <?php
                        }
                        else
                        {
                    ?>
                            <form id="saveFeedbackForm" action="saveFeedback.php" method="POST">
                                <input type="hidden" name="submitFeedback" value="true"/>
                                <input id="type" type="hidden" name ="userID" value="<?php echo $_SESSION['userID'];?>"/>
                                <table>
                                    <tr>
                                        <td><div id="bigHeading">Feedback</div></td>

                                    </tr>

                                    <tr>
                                        <td><p style="color: #213155; font-size: 14; margin-top: 5px;">
                                        Please help us to improve Twizla by leaving your feedback below.
                                        </p></td>
                                    </tr>

                                    <tr><td></td></tr>
                                    <tr>
                                        <td class="colorLabel">What you like about Twizla:</td>
                                    </tr>

                                    <tr>
                                        <td  colspan="3"><textarea rows="5" cols="62" id="likeFeedback" name="likeFeedback" onKeyDown="limitText(this.form.likeFeedback,500);"
                                                      onKeyUp="limitText(this.form.likeFeedback,500);"></textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td ><label id="wordCount" style="visibility: hidden; font-size:12px; color:blue; font-style: italic; margin-left: 170px;">500 characters left</label></td>
                                    </tr>
                                    <script language="javascript" type="text/javascript">
                                        //if editing the item, set the remaining number of characters.
                                        var likeFeedback = document.getElementById("likeFeedback");
                                        limitText(likeFeedback,500);

                                    </script>

                                    <tr><td colspan="3"></td></tr>

                                    <tr>
                                        <td class="colorLabel">What you don't like about Twizla:</td>
                                    </tr>

                                    <tr>
                                        <td  colspan="3"><textarea rows="5" cols="62" id="dislikeFeedback" name="dislikeFeedback" onKeyDown="limitText(this.form.dislikeFeedback,500);"
                                                      onKeyUp="limitText(this.form.dislikeFeedback,500);"></textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                    </tr>
                                    <script language="javascript" type="text/javascript">
                                        //if editing the item, set the remaining number of characters.
                                        var dislikeFeedback = document.getElementById("dislikeFeedback");
                                        limitText(dislikeFeedback,500);

                                    </script>

                                    <tr><td colspan="3"></td></tr>

                                    <tr>
                                        <td class="colorLabel">Any bug / issue?</td>
                                    </tr>

                                    <tr>
                                        <td  colspan="3"><textarea rows="5" cols="62" id="bugFeedback" name="bugFeedback" onKeyDown="limitText(this.form.bugFeedback",500);"
                                                      onKeyUp="limitText(this.form.bugFeedback",500);"></textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td ></td>
                                    </tr>
                                    <script language="javascript" type="text/javascript">
                                        //if editing the item, set the remaining number of characters.
                                        var bugFeedback = document.getElementById("bugFeedback");
                                        limitText(bugFeedback,500);

                                    </script>

                                    <tr>
                                        <td ></td>
                                    </tr>
                                    <tr>
                                        <td><img id="buttonImage" src="<?php echo $PROJECT_PATH;?>webImages/submitbutton.png" alt="SubmitButton" onclick="document.getElementById('saveFeedbackForm').submit()" style="margin-left:19px;"/></td>
                                    </tr>
                                </table>
                            </form>
                            <div id="message" style="margin-left: 80px;"><?php if(isset($_GET['message'])) echo $_GET['message']; ?></div>
                    <?php
                        }
                    ?>

                    


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
