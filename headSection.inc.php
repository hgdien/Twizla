<!--
    Document   : headSection.php
    Created on : Dec 22, 2009, 12:36:45 PM
    Author     : Peter
    Description:
        The top head section of the website, contains logo, search & login box
        and navigation bar

    Updated: 9/1/2010
-->

<!Facebook connection code>
<script src="http://static.ak.connect.facebook.com/js/api_lib/v0.4/FeatureLoader.js.php/en_US" type="text/javascript"></script>

<?php 

    //include this file to run everytime the website is accessed by a user
    include_once 'processFinishedAuctions.inc.php';



?>

<div id="navigator">
        <ul class="main_set">
            <li class="home">
                <div class="home navigator_link">
                    <a href="<?php echo $PROJECT_PATH;?>" >Home</a>
                </div>
            </li>

            <?php
            
            if($me)
            {

            ?>
            <li class="logout" style='width: 180px;'>
                <div class="logout navigator_link">
                    <a href="<?php echo $facebook->getLogoutUrl();?>"  title="Log out">G'day <?php echo $me['first_name']; ?>
                        ! Sign out
                        <img src='<?php echo $PROJECT_PATH?>webImages/fbLogo_small.gif' style='width:16px; height: 16px; top: 2px;' border=0 />
                        <!img src='http://static.ak.fbcdn.net/rsrc.php/z2Y31/hash/cxrz4k7j.gif'  style="width:83px; height:18px;"border=0/>
                    </a>
                </div>
             </li>
            <?php
            }
            else if(isset($_SESSION['username']))
            {
            ?>
            <li class="logout" style='width: 180px;'>
                <div class="logout navigator_link">
                    <a href="<?php echo $PROJECT_PATH;?>logout.php" title="Log out">G'day <?php echo $_SESSION['username']; ?>! Sign out</a>
                </div>
             </li>
            <?php
            }
            else
            {
            ?>
             <li class="login">
                <div class="login navigator_link">
                    <a href="<?php echo $PROJECT_PATH;?>signIn/" title="Have an account or want one?">Login/Register</a>
                </div>
             </li>
            <?php
            }

            ?>
                
             
            <li class="help">
                <div class="help navigator_link">
                    <a href="<?php echo $PROJECT_PATH;?>help/" title="Help Centre">Help</a>
                </div>
             </li>
             <li class="blog">
                <div class="blog navigator_link">
                    <a href="<?php echo $PROJECT_PATH;?>blog/" title="Join our social network">Blog</a>
                </div>
             </li>
             <li class="account">
                <div class="account navigator_link" style="width:90px;">
                    <a href="<?php echo $PROJECT_PATH;?>account/" title="Your Twizla Account">My Twizla</a>
                </div>
             </li>
                <li class="sell">
                 <div class="sell navigator_link">
                     <a href="<?php echo $PROJECT_PATH;?>sell/" title="Sell item in 20 seconds">Sell</a>
                 </div>
             </li>
            <li class="buy">
                 <div class="buy navigator_link">
                    <a href="<?php echo $PROJECT_PATH;?>buy/" title="Check out latest listings or favourite items">Buy</a>
                 </div>
             </li>
            <li class="category" id="categoryMenu" onmouseover="displayCategoryList()"  onmouseout="hideCategoryList()" >
                 <div class="category navigator_link">
                    <a title="Browse available item categories">Categories</a>
                 </div>
             </li>
        </ul>
</div>
    <?php if ($me) { ?>

    <?php } else { ?>
        <div id="fbConnect_top">
            <!--fb:login-button perms="email,read_friendlists" autologout="yes" size="big" background="dark" length="big" v="2"><fb:intl>Connect with Facebook</fb:intl></fb:login-button>
            <script type="text/javascript">  FB.init("752f25119c6dc6e9b20f473dee30ee5f", "<?php //echo $PROJECT_PATH;?>xd_receiver.htm"); </script-->
        
            <img src="<?php echo $PROJECT_PATH;?>webImages/FB_Login_Button.png" border="0" style="cursor:pointer;" alt="FacebookLoginButton"
                 onclick="window.open('<?php echo $facebook->getLoginUrl(array(  'display' => 'popup',
                                                                    'fbconnect' => 1,
                                                                    'next' => $PROJECT_PATH.'FBLogin.php?login_success=true',
                                                                    'cancel_url'=> $PROJECT_PATH.'FBLogin.php?close=true',
                                                                    'req_perms' => 'email, read_friendlists'));?>','FacebookLogin','width= 700, height= 350, left= 500, top= 200')" />

        </div>
    <?php } 
    
    ?>


<!start content div here, shall be closed in other files that include
headSection.inc.php file>
<div id="content">
    <!Insert social network sites's logos>
    <!--div id="socialLogoBox">
        <a href="http://www.facebook.com/people/Twizla-OnlineAuctions/100000639201164"><img src="<?php //echo $PROJECT_PATH;?>webImages/fbsm.png" alt="FaceBookLogo"  border="0"/></a>
        <a href="http://twitter.com/twizlaauctions"><img src="<?php //echo $PROJECT_PATH;?>webImages/twittersm.png" alt="TwitterLogo"  border="0"/></a>
        <a href="http://www.myspace.com/twizlaauction"><img src="<?php //echo $PROJECT_PATH;?>webImages/mySpaceIcon.png" alt="mySpacelogo"  border="0"/></a>
        <a href="http://digg.com/users/TwizlaAuctions"><img src="<?php //echo $PROJECT_PATH;?>webImages/diggsm.png" alt="DiggLogo"  border="0"/></a>
        <a href="http://www.flickr.com"><img src="<?php //echo $PROJECT_PATH;?>webImages/flickrs.png" alt="flickrsLogo"  border="0"/></a>
    </div-->


    <a href="<?php echo $PROJECT_PATH;?>" ><img id="logo" src="<?php echo $PROJECT_PATH;?>webImages/logo_full.png" alt="Online Auctions"  border="0" height="100" width="100"/></a>

    <form id="searchForm" action="<?php echo $PROJECT_PATH;?>buy/searchProductPage.php" method="GET">
        <input type="hidden" name="username" id="username" value="<?php echo $_SESSION['username'];?>" />
        <input type="hidden" name="searchSubmit" value="true" />
        <table>
            <tr>
                <td></td>
                <td><input type="text" name="searchString" id="searchString" value="<?php echo $_GET['searchString'];?>" size="50" onKeyPress="submitEnter(this.form)" /></td>
                <td>
                <select id="searchCategory" name="searchCategory" onchange="" >
                    <option>All Categories</option>
                    <option disabled>======================</option>
                    <?php
                        foreach($categoryList as $category)
                        {
                            echo "<option value='".$category['CategoryName']."'>".$category['CategoryName']."</option>";
                        }
                    ?>
                </select>
                <td/>

                <!input id="button" type="button" name="searchSubmit" value="Search" />
                <td><input type="button" class="pinkButton" value="Search" onclick="document.getElementById('searchForm').submit()"  /></td>
            </tr>
                <?php

                    //set a hidden field for category to apply javascript
                    if(isset($_GET['searchSubmit']))
                    {
                ?>

                        <script type="text/javascript">
                            var searchCategoryBar = document.getElementById("searchCategory");
                            var category = "<?php echo $_GET['searchCategory'];?>";

                            for( i = 0;i < searchCategoryBar.length ; i++)
                            {

                                if(searchCategoryBar.options[i].value== category)
                                {
                                    searchCategoryBar.selectedIndex = i;
                                }
                            }
                        </script>
                <?php
                    }
               ?>
        </table>
    </form>

    <?php
//                    check if there is a user log on
//                    if there is then display the welcome message & log out button
//                        if(isset($_COOKIE['username']))
        if(isset($_SESSION['username']))
        {
            include_once 'account/getUserSummary.inc.php';
    ?>
        <div id="welcomeMesg">
            <b>Bidding:</b> <a href="<?php echo $PROJECT_PATH;?>account/buy/2/"><?php echo $bidAmount ?></a>&nbsp;&nbsp;&nbsp;
            <b>Won:</b> <a href="<?php echo $PROJECT_PATH;?>account/buy/3/"><?php echo $wonAmount; ?></a>&nbsp;&nbsp;&nbsp;
            <b>Selling:</b> <a href="<?php echo $PROJECT_PATH;?>account/sell/1/"><?php echo $sellingAmount; ?></a>&nbsp;&nbsp;&nbsp;
            <b>Sold:</b> <a href="<?php echo $PROJECT_PATH;?>account/sell/2/"><?php echo $soldAmount; ?></a>&nbsp;&nbsp;&nbsp;
            <b>Unsold:</b> <a href="<?php echo $PROJECT_PATH;?>account/sell/3/"><?php echo $unsoldAmount; ?></a>&nbsp;&nbsp;&nbsp;
            <b>Inbox:</b> <a href="<?php echo $PROJECT_PATH;?>account/mail/" <?php if($pendingMailAmount > 0) echo "style='color: red;'"?>><?php echo $pendingMailAmount; ?></a>
        </div>


    <?php
        }
//                   if not then display the log in box
        else
        {?>
        <div id="joinButton">
            <a href="<?php echo $PROJECT_PATH;?>registration/"><img src="<?php echo $PROJECT_PATH;?>webImages/joinfreeButton.png" /></a>
        </div>
       <?php
        }
    ?>

    
                    <div id="categoryListPanel" onmouseover="displayCategoryList()" onmouseout="hideCategoryList()"  >
                            <?php
                                //display categorylist here in a multi-column panel format

                                //Determine the number of category to display per column.
                                //For the moment the number of item displayed per page is 12.
                                //Each column width is 50 px;
                                $ROW_PER_COLUMN = 12;
                                $COLUMN_WIDTH = 205;
                                $numberOfCols = ceil(count($categoryList) / $ROW_PER_COLUMN);
                                
                                for($col = 0; $col < $numberOfCols; $col ++)
                                {
                                    //set the number of start category to display
                                    $start = $col * $ROW_PER_COLUMN;
//                                    $start = 0;
                                    //set the start left position to display
                                    $leftPos = $col * $COLUMN_WIDTH ;
                                    $margin = $col * 250;
                                    echo "<ul id='categoryCol' style='float: left;' >";
                                    for($count = $start; $count < count($categoryList); $count++)
                                    {
                                        //break when reach the set number of items displayed on the column
                                        if($count == ($start + $ROW_PER_COLUMN))
                                        {
                                            break;
                                        }
  
                                        $url = $PROJECT_PATH."category/".formatCategoryName($categoryList[$count]['CategoryName']);
                                        ?>
                                        <li onmouseover="this.style.textDecoration='underline'; this.style.backgroundColor='#eaeaea';" onmouseout="this.style.textDecoration='none';  this.style.backgroundColor='#f4f4f4'; "><a href = "<?php echo $url?>" style='text-decoration: none;'><?php echo $categoryList[$count]['CategoryName']?></a></li>
                                        <?php
                                    }
                                    echo "</ul>";
                                }
                            ?>
                    </div>

                    <?php
                            if(isset($_SESSION['username']) AND $pendingMailAmount > 0)
                            {
                                ?>
                                <img id="newMessageBubble" src="<?php echo $PROJECT_PATH;?>webImages/newmessage.png" alt="New Message Warning"/>
                                <script type="text/javascript">
                                    moveBubbleUp();
                                </script>

                                <?php
                            }

                    ?>

                    <!--div id="middeBorderBoxTop"> </div-->
