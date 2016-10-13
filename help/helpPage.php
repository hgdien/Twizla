<?php
    session_start();
    include("../mySQL_connection.inc.php");
    include("../login.php");

    include("../loadHome.php");

    //include all the help content
    include("helpContent.inc.php");
?>

<!--
    Document   : helpPage.php
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
                    <div id ="bigHeading">Help Centre</div>
                    <br/>
                    <!display the help content>
                    <?php
                        if(isset($_GET['subPage']))
                        {

                            $subPage = $_GET['subPage'];

                            echo "<div style='font-size:12px;'>";
//                           <!display the path header>
                            echo "<a href='".$PROJECT_PATH."help/'>Help</a> > ".$helpHeading["$subPage"];
                            echo "</div><br>";
                            
                            echo "<div class='colorLabel'>".$helpHeading["$subPage"]."</div><br>";
                            echo "<div id='helpContent'>";
                            echo $helpContent["$subPage"];

                            echo "</div>";
                        }
                        else
                        {
                    ?>
                           <!div id="helpContent">
                                    <label class="colorLabel">Getting Start</label>
                                    <br>
                                    <ul>
                                        <li><a href="<?php echo $PROJECT_PATH;?>help/0">What is Twizla?</a></li>

                                    </ul>
                                    <br>
                                    <label class="colorLabel">Registration and Your Account</label>
                                    <br>
                                    <ul>
                                        <li><a href="<?php echo $PROJECT_PATH;?>help/1">Registering</a></li>
                                        <li><a href="<?php echo $PROJECT_PATH;?>help/2">Problems logging in</a></li>
                                        <li><a href="<?php echo $PROJECT_PATH;?>help/3">Changing your details</a></li>
                                        <li><a href="<?php echo $PROJECT_PATH;?>help/4/1280">Feedbacks & Points</a></li>
                                    </ul>
                                    <br>
                                    <label class="colorLabel">How to Buy</label>
                                    <br>
                                    <ul>
                                        <li><a href="<?php echo $PROJECT_PATH;?>help/5">Search an item</a></li>
                                        <li><a href="<?php echo $PROJECT_PATH;?>help/6">Watch an item</a></li>
                                        <li><a href="<?php echo $PROJECT_PATH;?>help/7">Bidding and Buy Now</a></li>
                                        <li><a href="<?php echo $PROJECT_PATH;?>help/8">Item Ratings</a></li>
                                        <li><a href="<?php echo $PROJECT_PATH;?>help/12/3500">Payment Methods</a></li>
                                    </ul>
                                    <br>
                                    <div style="position: absolute; top:280px; left:350px;">
                                    <label class="colorLabel">How to Sell</label>
                                    <br>
                                    <ul>
                                        <li><a href="<?php echo $PROJECT_PATH;?>help/9/1380">List an item</a></li>
                                        <li><a href="<?php echo $PROJECT_PATH;?>help/10">Manage your listings</a></li>
                                        <li><a href="<?php echo $PROJECT_PATH;?>help/17/1570">How to import a CSV inventory file</a></li>
                                    </ul>
                                    <br>
                                    </div>
                                    <label class="colorLabel">Security</label>
                                    <br>
                                    <ul>
                                        <li><a href="<?php echo $PROJECT_PATH;?>help/11/1380">Safe buying advice</a></li>
                                    </ul>
                                    <br>
                                    <div style="position: absolute; top:446px; left:350px;">
                                    <label class="colorLabel">Policies, terms and conditions</label>
                                    <br>
                                    <ul>
                                        <li><a href="<?php echo $PROJECT_PATH;?>help/13/6700">Terms & Conditions</a></li>
                                        <li><a href="<?php echo $PROJECT_PATH;?>help/14">Fees</a></li>
                                        <li><a href="<?php echo $PROJECT_PATH;?>help/15/1670">Privacy Policy</a></li>
                                        <li><a href="<?php echo $PROJECT_PATH;?>help/16/1680">Terms & Conditions of Draw</a></li>
                                        
                                    </ul>
                                    </div>

                                    <div id="contactBox">
                                        <div class="colorLabel">Still need more help?</div>
                                        <b>or want to advertise your bussiness?</b>
                                        <br>
                                        <b>Contact us by</b><br>
                                        <b>Email:</b> contact@twizla.com.au<br>

                                    </div>
                                    
                    <?php
                        }
                    ?>

                    
                </div>
                <!--label style='color:blue;'>".$item['total_value']." stars.</label-->

            <?php
                if(!isset($_GET['height']))
                {
                    include("../middleRightSection.inc.php");
                }

            ?>
                
            </div>


            <?php
                include("../footerSection.inc.php");
            ?>

            <?php
                if(isset($_GET['height']))
                {
                    ?>
                        <script type="text/javascript">
                            var helpContent = document.getElementById('helpContent');
                            var middleSession = document.getElementById("middleSection");
                            helpContent.style.width = 1100 + "px";


                            var addedHeight = <?php echo $_GET['height'];?>;

                            //case IE, set grassfooter position and increase addedHeight
                            if (/MSIE (\d+\.\d+);/.test(navigator.userAgent)) //test for MSIE x.x;
                            {
                                addedHeight = addedHeight - 20;
                                if(addedHeight > 6000)
                                {
                                    addedHeight += 450;
                                }
                                document.getElementById("footer").style.top =  addedHeight - 80   + "px";
                                var grassFooter = document.getElementById("grassFooter");
                                grassFooter.style.top = addedHeight +  "px";

                            }

                            window.document.body.style.height = addedHeight  + "px";
                            middleSession.style.height = addedHeight - 500  + "px";


                        </script>

                    <?php
                }
            ?>
    </body>
</html>
