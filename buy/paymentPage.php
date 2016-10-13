<?php
    session_start();
    include("../mySQL_connection.inc.php");
    include("../login.php");
    include('../loadHome.php');
    include ("getItemDetail.inc.php");


    //create connection and connect to the Twizla database
    $conn = dbConnect();


//    var_dump($currentUser);
    $sql = "SELECT * FROM sale WHERE ItemID = ".$item['ItemID'];
    
    $result = mysql_query($sql) or die(mysql_error());
    $sale =  mysql_fetch_array($result);

    //check if the user is the one who won this item to prevent frauds
    if($sale['BuyerID'] == $_SESSION['userID'])
    {
        $sql = "SELECT * FROM user, state_country, userpayment WHERE user.state_country = state_country.state_countryID AND
                                                                user.UserID = userpayment.UserID AND
                                                                user.UserID = ".$_SESSION['userID'];


        $result = mysql_query($sql) or die(mysql_error());
        $currentUser =  mysql_fetch_array($result);

    

        if(($currentUser['AddressLine1'] == "" AND $currentUser['AddressLine2'] == "") OR
                                        $currentUser['Suburb_City'] == ""  OR $currentUser['State_CountryName'] == "")
        {
            $hasAddress = false;
        }
        else
        {
            $hasAddress = true;
        }

        //if is on the select payment method page or payment completed page, get the seller information to display
        if(isset($_GET['confirm']) OR isset($_GET['paymentMethod']))
        {
            $sql = "SELECT * FROM user, state_country, userpayment WHERE user.state_country = state_country.state_countryID AND
                                                                        user.UserID = userpayment.UserID AND
                                                                        user.UserID = ".$item['SellerID'];

            $result = mysql_query($sql) or die(mysql_error());
            $seller =  mysql_fetch_array($result);
        }



        //if the payment method is selected, send an email to inform the seller about this
        if(isset($_GET['paymentMethod']))
        {
            //update the paid status of the sale

            $sql = "UPDATE sale SET Paid = 1, PaymentMethod = '".$_GET['paymentMethod']."' WHERE SaleID = ".$sale['SaleID'];

            mysql_query($sql) or die(mysql_error());


            $subject = "Twizla Payment Notification";

            //set verification message

            $content = "<a href='".$PROJECT_PATH."'><img src='".$PROJECT_PATH."webImages/logo.png' alt='Twizla Logo' style='border: 0;'/></a>
                        <br><br><br>
                        Dear ".$seller['FirstName'].",<br>
                        The buyer of Item Number ".$item['ItemID']." ( ".$item['ItemTitle']." ) has chosen the option ".$_GET['paymentMethod']." to pay for this item.<br>
                        Please be patient and wait for your payment in the next few days.<br>
                        Thank you. We look forward to seeing you around the site.<br><br>
                        Sincerely,<br>
                        <b>The Twizla Team</b>";
        //        echo $email;

            include_once '../sendEmail.inc.php';
            sendEmail($seller['Email'], $subject, $content);
        }
    }

    mysql_close($conn);
?>

<!--
    Document   : paymentPage.php
    Created on : Feb 11, 2010, 12:36:45 PM
    Author     : Peter
    Description:
        The main page.

    Updated: 11/2/2010
-->


<!Include php files for login, sign up function>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">


<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

        <link rel="stylesheet" type="text/css" href="<?php echo $PROJECT_PATH;?>css/payment.css">
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

                        if(!isset($_SESSION['username']))
                        {
                        ?>
                            <div id="bigHeading">
                                You must login to view this page.<br/>
                                Don't have a Twizla account? <br/>
                               <a href="<?php echo $SECURE_PATH;?>registration/">Register</a> in 30 seconds and start listing and checking products.
                            </div>
                    <?php
                        }
                        else if($sale['BuyerID'] != $_SESSION['userID']) //check if the user is the one who won this item to prevent frauds
                        {
                        ?>
                            <div id="bigHeading">
                                The item you are trying to find is not available.<br/>
                            </div>
                        <?php

                        }
                        else if($sale['Paid'] AND !$_GET['paymentMethod']) //check if the item has been paid and this is not the payment conplete page
                        {
                            ?>
                            <script type="text/javascript">
                                window.location = projectPath + "account/myAccountPage.php?page=Buy&tab=3";
                            </script>
                            <?php
                        }
                        else if(isset($_GET['paymentMethod'])) //if the payment method is selected, display the message to inform the user
                        {

                            ?>
                            <div id="bigHeading">Thank you! The payment process has been completed.</div><br>
                            You can also <a href="<?php echo $PROJECT_PATH."user/".$seller['UserName']."/";?>contact" class="helpLink">ask for an invoice</a>
                            from the seller or <a href="<?php echo $SECURE_PATH?>account/personalinfo//2/" class="helpLink">give feedback</a> about this sale.
                            <?php

                        }
                        else if(isset($_GET['confirm'])) //if the item is confirm, start display available payment option
                        {
                            ?>
                            <label id="bigHeading">Select a Payment Method:</label>
                            <a href="paymentPage.php?ItemID=<?php echo $item['ItemID'];?>" style="font-size: 12px; float: right;margin-top: 7px; margin-right:50px;">
                                >> Back
                            </a>
                            <br><br>
                            <div id="paymentMethodBox">
                            <?php
                            foreach($itemPayment as $method)
                            {
                                ?>
                                <input type='radio' name='method' onclick="displayPaymentMethod('<?php echo $method['MethodName'];?>')"/>
                                <label class='colorLabel'><?php echo $method['MethodName'];?></label><br><br>
                                <?php
                            }
                            ?>
                            </div>
                            <div id="paymentDetail">

                                <div id="PayPalDetail" style="display: none;">
                                    You will be direct to a secure Paypal Payment Form to make the payment with either your
                                    /debit card or your PayPal Account.
                                </div>

                                <div id="bankDetail" style="display: none;">
                                    <b>Seller Bank Account Details:</b><br><br>
                                    <?php
                                        echo "Account Holder: ".$seller['AccountHolder']."<br>";

                                        echo "Bank: ".$seller['BankName']."<br>";

                                        echo "BBS: ".$seller['BBS1']." ".$seller['BBS2']."<br>";

                                        echo "Account Number: ".$seller['AccountNo']."<br>";
                                    ?>

                                    <br>
                                    Please deposit the payment to this bank account.<br>
                                </div>

                                <div id="otherMethodDetail" style="display: none;">
                                    <b>Seller Postage Details:</b><br><br>
                                    <?php
                                        echo $seller['FirstName']." ".$seller['LastName']."<br>";

                                        echo $seller['AddressLine1']." ";

                                        echo $seller['AddressLine2']."<br>";

                                        echo $seller['Suburb_City']." ".$seller['State_CountryName']." ".$seller['$Postcode']."<br>";

                                        echo $seller['ContactNumber']."<br>";
                                    ?>

                                    <br>
                                    Please post the payment to this address. Payment must be made payable to the seller.<br>
                                </div>
                            </div>

                            <div id="confirmPaymentButton">
                                <form action="https://www.paypal.com/cgi-bin/webscr" method="post" id="paypalForm" style="visibility:hidden; position: absolute;">
                                    <!-- Identify your business so that you can collect the payments. -->
                                    <input type="hidden" name="business" value="<?php echo $seller['PaypalEmail'];?>">
                                    <!-- Specify a Buy Now button. --> <input type="hidden" name="cmd" value="_xclick">
                                    <!-- Specify details about the item that buyers will purchase. -->
                                    <input type="hidden" name="ItemID" value="<?php echo $item['ItemID'];?>">
                                    <input type="hidden" name="item_name" value="<?php echo $item['ItemTitle'];?>">
                                    <input type="hidden" name="amount" value="<?php echo $_GET['total'];?>">
                                    <input type="hidden" name="currency_code" value="AUD">
                                    <input type="hidden" name="image_url" value="<?php echo $PROJECT_PATH."webImages/logo.png";?>" />
                                    <input type="hidden" name="cpp_header_image" value="<?php echo $PROJECT_PATH."webImages/logo.png";?>" />
                                    <input type="hidden" name="return" value="<?php echo $PROJECT_PATH."updatePaymentStatus.php";?>" >
                                    <input type="hidden" name="rm" value="1" />
                                    <input type="hidden" name="cancel_return" value="<?php echo $PROJECT_PATH."paymentPage.php?ItemID=".$item['ItemID']."&confirm=true&total=".$_GET['total'];?>" >
                                    <input type="hidden" name="cbt" value="Back to Twizla - Item Number <?php echo $item['ItemID'];?>" />
                                    <!-- Display the payment button. -->
                                    <input type="image" name="submit" src="<?php echo $PROJECT_PATH."webImages/confirmpaymentbutton.png";?>" alt="PayPaButton">
                                    <img alt="" border="0" width="1" height="1" src="https://www.paypal.com/en_US/i/scr/pixel.gif" >
                                </form>
                                <!https://www.paypal.com/en_US/i/btn/btn_buynow_LG.gif>
                                <a id="confirmPaymentLink" href="paymentPage.php?ItemID=<?php echo $item['ItemID'];?>" style="text-decoration:none;"><img id="buttonImage" src="<?php echo $PROJECT_PATH."webImages/confirmpaymentbutton.png";?>" alt="ConfirmPaymentButton" /> </a>
                            </div>
                            <?php
                        }
                        else
                        {
                    ?>
                            <label id="bigHeading">Review and Confirm your purchasse</label>
                            <a href="<?php echo $PROJECT_PATH;?>account/buy/3/" style="font-size: 12px; float: right;margin-top: 7px;">
                                >> Back to My Account
                            </a>
                            <br><br>

                            <div id="colorHeading">Shipping Details</div>
                            <br>
                            
                            <?php
                            if(!$hasAddress)
                            {
                                echo "Your shipping address are currently missing.<br> You must <a target='blank' href='".$SECURE_PATH."account/personalinfo/'>update your address</a> before confirm the purchase. ";
                            }
                            else
                            {
                            
                                echo "<b>".$currentUser['UserName']."</b><br>";
                                
                                echo $currentUser['AddressLine1']." ";
                                
                                echo $currentUser['AddressLine2']."<br>";

                                echo $currentUser['Suburb_City']." ".$currentUser['State_CountryName']." ".$currentUser['$Postcode']."<br>";

                                echo $currentUser['ContactNumber']."<br>";

                            }
                            ?>
                            <br><br>

                            <div id="colorHeading">Purchase Details</div>
                            <br>
                            <div class="tableHeader" style="width:650px; font-size: 12px; margin-top: 5px; ">
                                <label style="left:25px;">Item</label>
                                <label style="left:200px;">Seller</label>
                                <label style="left:245px;">Shipping Cost</label>
                                <label style="left:350px;">Price</label>
                            </div>
                            <table style="font-size:13px; margin-left: 33px;" >
                            <?php
                                echo "<td><div style='width:195px;'>";
                                echo "Item Number: ".$item['ItemID']."<br/><b>";
                                if(strlen($item['ItemTitle']) > 30)
                                {
                                    echo substr($item['ItemTitle'], 0, 26)."...<br/>";
                                }
                                else
                                {
                                    echo $item['ItemTitle']."<br/>";
                                }

                                echo "</b><a target='_blank' href='".$PROJECT_PATH."listing/".$item['ItemID']."/".formatItemTitle($item['ItemTitle'])."/view'>View the item </a>";
                                echo "</div></td>";
                                echo "<td><div style='width:100px; text-align:center;'>";
                                echo "<a target='_blank' href='".$PROJECT_PATH."user/".$item['UserName']."/'>";
                                if(strlen($item['UserName']) > 8)
                                {
                                    echo substr($item['UserName'], 0, 5)."...<br/>";
                                }
                                else
                                {
                                    echo $item['UserName']."<br/>";
                                }
                                echo "</a> (".$item['feedbackPoint'];

                                include_once '../account/showMemberIcon.inc.php';
                                showIcon($item);

                                echo " )";
                                echo "</div></td>";
                                echo "<td style='padding-left: 15px; width:185px; '>".$item['Postage']."</td>";

                                //get the price of the item depend on processing buy now / bid winner
                                if($sale['BidAmount'] == null OR  $sale['BidAmount'] == 0)
                                {
                                    $price = $item['Price'];
                                }
                                else
                                {
                                    $price = $sale['BidAmount'];
                                }
                                echo "<td style='padding-left:10px;'>AU $".$price."</td>";

                                echo "</tr>";

                            ?>
                            </table>

                            <div style="position: absolute; bottom: 60px; right:25px; border: 1px solid #c4c4c4;">
                                <table style=" width: 200px; height: 90px; font-size: 14px;">
                                    <tr>
                                        <td class="label">Subtotal:</td>
                                        <td><pre> </pre></td>
                                        <td><b>AU $<?php echo $price;?></b>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="label">Shipping Cost:</td>
                                        <td><pre> </pre></td>
                                        <td><b>AU $<?php
                                            $shippingCost = 0;

                                            if(substr($item['Postage'],0,11) == "Fixed Price")
                                            {
                                                $shippingCost = substr($item['Postage'], 17, strlen($item['Postage']));
                                                setlocale(LC_MONETARY, 'en_AU');
                                                echo number_format($shippingCost,2)."<br>";
                                                
                                            }
                                            else
                                            {
                                                echo "0.00";
                                            }

                                            $total = $price + $shippingCost;
                                        ?></b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" style="padding-left:20px;"><div style="border-top: 1px solid #c4c4c4; width: 180px; "></div></td>
                                    </tr>
                                    <tr>
                                        <td class="label"><b>Total :</b></td>
                                        <td><pre> </pre></td>
                                        <td><b>AU $<?php echo number_format($total,2);?></b>
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <?php
                                if($hasAddress)
                                {
                                    ?>
                                 <img src="<?php echo $PROJECT_PATH;?>webImages/confirmpurchasebutton.png" id="buttonImage" alt="ConfirmPurchaseButton" style="position: absolute; bottom: 20px; right:37px;"
                                    onclick="window.location='<?php echo $PROJECT_PATH;?>buy/paymentPage.php?ItemID=<?php echo $item['ItemID'];?>&confirm=true&total=<?php echo $total;?> ';" />

                                <?php
                                }
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
