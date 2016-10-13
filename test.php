<?php
        phpinfo();
        include("mySQL_connection.inc.php");
        $subject = "Twizla Account Verification";

        //set verification message

        $content = "<html><head>
                      <title>Registration Email</title>
                    </head><body><a href='".$PROJECT_PATH."'><img src='".$PROJECT_PATH."webImages/logo.png' alt='Twizla Logo' style='border: 0;'/></a>
                    <br><br><br>
                    Dear a,<br>
                    Welcome and thanks for joining the <b>Twizla</b> ! Now that you are a member, you can easily sell and buy products, or give feedback and have your voice heard.<br>
                    To find and edit your reviews or update your contact information, go to your <a href='".$SECURE_PATH."myAccountPage.php?page=Account'>profile page</a>.<br>
                    Need help? Still have questions? Try our <a href='".$PROJECT_PATH."helpPage.php'>Help Page</a>.<br>
                    We look forward to seeing you around the site.<br><br>
                    Sincerely,<br>
                    <b>The Twizla Team</b></body></html>";
    //        echo $email;

        include_once 'sendEmail.inc.php';
        sendEmail("devilbat7688@yahoo.com", $subject, $content);

?>