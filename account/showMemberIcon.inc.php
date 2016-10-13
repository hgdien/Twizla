<?php

    //display the star icon based on the number of feedback point of the user
    function showIcon($user)
    {
        $point = $user['feedbackPoint'];
        $verify = $user['verifyStatus'];
        $star ="";
        if($point < 10)
        {
            //don't display the icon
        }
        else
        {
            if($point > 9 AND $point < 75)
            {
                $star = "starball-1";
            }
            else if($point > 74 AND $point < 150)
            {
                $star = "starball-2";
            }
            else if($point > 149 AND $point < 550)
            {
                $star = "starball-3";
            }
            else if($point > 549 AND $point < 1500)
            {
                $star = "starball-4";
            }
            else if($point > 1499 AND $point < 3500)
            {
                $star = "starball-5";
            }
            else if($point > 3499 AND $point < 10000)
            {
                $star = "starball-6";
            }
            else if($point > 9999 AND $point < 35000)
            {
                $star = "starball-7";
            }
            else if($point > 34999 AND $point <= 50000)
            {
                $star = "starball-8";
            }
            else
            {
                $star = "starball-9";
            }

            echo "<img src='webImages/$star.png' alt='starIcon' style='margin-bottom:-7px; margin-left:5px; margin-right:5px; border: none;'/>";
        }

        if($verify == 'yes')
        {
            echo "<img src='webImages/verifyIcon.png' alt='verifyIcon' style='margin-bottom:-5px;  border: none;'/>";
        }

    }


?>
