<?php


    function sendEmail($email, $subject, $content)
    {

            require_once('class.phpmailer.php');

            $mail = new PHPMailer(); // defaults to using php "mail()"

            $mail->AddReplyTo("contact@twizla.com","Twizla Online Auction");

            $mail->SetFrom('contact@twizla.com', 'Twizla Online Auction');

            $mail->AddReplyTo("contact@twizla.com","Twizla Online Auction");


            $mail->AddAddress($email, "");

            $mail->Subject = $subject;

            $mail->MsgHTML($content);

            $mail->Send();

    }
?>
