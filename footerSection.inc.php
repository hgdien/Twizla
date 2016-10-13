    <!--div id="middeBorderBoxBottom" ></div-->

    </div>
    <?php if($me)
    {
    ?>
        <div id="FBFriendPanel">
            
        <?php


        echo count($FBFriendList)." of your friends is selling on Twizla.";

            
        if(count($FBFriendList) >0)
        {
            echo "<a href='".$PROJECT_PATH."buy/searchProductPage.php?searchSubmit=true&"."FBFriendSelling=true'> See what they are selling</a>";
            echo "<br/><br/>";
            $count = 0;
            foreach($FBFriendList as $friend)
            {
                if($count > 2)
                {
                    break;
                }

                $profile = $facebook->api('/'.$friend[0]['id'].'?fields=id,name,picture,link');

                echo "<a href='".$profile['link']."'><img src='".$profile['picture']."' border=0 /></a>";
                $count++;
            }
        }

        ?>
        </div>
    <?php
    }


    ?>

<div id="footer">

    <ul id="footerMenu" style="margin-left:240px;">
        <label class="colorLabel" style="font-size: 12px;">Help</label>
        <li><a href="<?php echo $PROJECT_PATH;?>help/feedbackPage.php">Feedback & Ideas</a></li>
        <li><a href="<?php echo $SECURE_PATH?>help/17/1570/">CSV Impoter</a></li>
        <li><a href="<?php echo $PROJECT_PATH;?>help/11/1380">Safe Buying Advices</a></li>

    </ul>

    <ul id="footerMenu">
        <label class="colorLabel" style="font-size: 12px;">About Us</label>
        <li><a href="<?php echo $PROJECT_PATH;?>help/0/">About Twizla</a></li>
        <li><a href="<?php echo $SECURE_PATH?>blog/">Blog</a></li>
        <li><a href="<?php echo $PROJECT_PATH;?>contact/">Contact Us</a></li>
    </ul>
    <div style="float: right; margin-right: 240px;">&copy; 2010 twizla P/L.</div>
    <img src="<?php echo $PROJECT_PATH;?>webImages/securepaymentbanner.jpg" alt="SecureBanner" style="float: right; margin-right: 240px;"/>

</div>




    <!Put end div tag here to complete the div tags start in the included
    file headSection.php for content div>

<!--div id="fb-root"></div>
<script type="text/javascript" src="http://connect.facebook.net/en_US/all.js"></script>
<script type="text/javascript">
  FB.init({appId: '107886915933327', status: true, cookie: true, xfbml: true});
  FB.Event.subscribe('auth.sessionChange', function(response) {
    if (response.session) {

      window.location="https://graph.facebook.com/oauth/authorize?client_id=<?php echo FACEBOOK_APP_ID;?>&redirect_uri=<?php echo $PROJECT_PATH;?>requestFBPermission.php&display=popup&scope=email,read_friendlists";
    } else {
      // The user has logged out, and the cookie has been cleared

    }
  });
</script-->

<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-17408163-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

<script type="text/javascript" src="http://dnn506yrbagrg.cloudfront.net/pages/scripts/0010/8282.js"> </script>
