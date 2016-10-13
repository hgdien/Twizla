<?php
    session_start();
    include("../mySQL_connection.inc.php");
    include("../login.php");

    include("../loadHome.php");
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
            <div id="middleSection" >
                <div id="middleLeftSection">
                    <?php
                    if(!$_SESSION['username'])
                    {
    //                         var_dump($_GET);
                    ?>
                            <div id="bigHeading">
                                Please login to list items on your personal Twizla store.<br/>
                                Don't have a Twizla account? <br/>
                               <a href="<?php echo $SECURE_PATH;?>registration/">Register</a> in 30 seconds and start listing and checking products.
                            </div>

                    <?php
                    }
                    else
                    {
                    ?>

                            <div id='bigHeading' >
                                All payment methods are unavailable now. <br>
                                Sellers are required to select at least one payment method.<br>
                                Please update your account <a href="<?php echo $SECURE_PATH;?>account/personalinfo/1/listing">postal address</a> and
                                <a href="<?php echo $SECURE_PATH;?>account/personalinfo/3/listing">payment options</a> first to enable the listing.
                            </div>
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