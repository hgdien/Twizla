
<?php

    $PROJECT_PATH = "http://www.twizla.com.au/";
    function displayFeedbackList($feedbackList, $user)
    {
        if(count($feedbackList) >  0)
        {
             //Determine the number of feedback to display per page 
            //For the moment the number of item displayed per page is 15.

//            $numberOfPage = ceil(count($feedbackList) / $feedbackPerPage);
//            //set the number of start item to display
//            //if there is no current page set by user, the start item number is 0
            $startNumber = 0;
//            if(isset($_GET['pageNumber']))
//            {
//                $startNumber = ($_GET['pageNumber'] - 1) * $feedbackPerPage;
//            }

            echo "<ul id='feedbackList'>";
            for($count = $startNumber; $count < count($feedbackList); $count ++)
            {
                $feedback = $feedbackList[$count];
                echo "<li style='margin-top:2px;'>";
                echo "<table>";
                    echo "<tr>";
                        echo "<td><div style='width:380px; font-weight:bold; height=25px;'>";
                        //display the emotion icon based on the rating type

                        //display feedback information based on either buyer or seller
                        if($feedback['BuyerID'] == $user['UserID'])
                        {
                            $rateType = $feedback['sellerRating'];
                            $feedbackDate = date('d M Y',strtotime($feedback['sellerFeedbackDate']));
                            $userRole = 'buyer';
                            $comment = $feedback['sellerComment'];
                        }
                        else if($feedback['SellerID'] == $user['UserID'])
                        {
                            $rateType = $feedback['buyerRating'];
                            $feedbackDate = date('d M Y',strtotime($feedback['buyerFeedbackDate']));
                            $userRole = 'seller';
                            $comment = $feedback['buyerComment'];
                        }

                        if($rateType == 1)
                        {
                            echo "<img src='webImages/smileicon.png' alt='smileIcon' style='margin-bottom:-8px;'/>";
                        }
                        else if($rateType == 0)
                        {
                            echo "<img src='webImages/neutralicon.png' alt='neutrailIcon' style='margin-bottom:-8px;'/>";
                        }
                        else
                        {
                            echo "<img src='webImages/negativeicon.png' alt='negativeIcon' style='margin-bottom:-8px;'/>";
                        }

                        echo "  <a target='_blank' href='".$PROJECT_PATH."user/".$feedback['UserName']."/'>";

                        echo $feedback['UserName']."</a> (".$feedback['feedbackPoint'];

                        include_once 'showMemberIcon.inc.php';
                        showIcon($feedback);


                        echo ")</div></td>";

                        echo "<td><div style='width:120px;'>";
                        
                        echo $feedbackDate;


                        echo "</div></td>";
                        
                        echo "<td rowspan='2'><div style='width:170px; text-align:center; padding-bottom:10px;'>".$user['UserName']." was the ";

                        echo $userRole;

                        echo "<br/>(#<a href='displayItemDetailPage.php?ItemID=".$feedback['ItemID']."&ItemName=".str_replace(" ",'-',$feedback['ItemTitle'])."&sold=true&recent=true'>".$feedback['ItemID']."</a>)</div></td>";
                    echo "</tr>";
                    echo "<tr><td colspan='2' style='font-size:12px; padding-top:10px; padding-bottom:10px;'>";
                    echo $comment;
           
                    echo "</td><td></td></tr>";
                    echo "<tr><td colspan='3' bgcolor='#c4c4c4' width='0.5'></td></tr>";
                echo "</table>";
                echo "</li>";
            }
            echo "</ul>";
        }


    }

?>
