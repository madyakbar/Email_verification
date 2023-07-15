<?php

function sendEmail($to, $subject, $message){
	require ('smtp/PHPMailerAutoload.php');

    $mail = new PHPMailer(true);

    try {
        // Configure SMTP settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->Post       = 587;
        $mail->SMTPAuth   = true;
        $mail->SMTPSecure = 'tls';
        $mail->Username   = 'devakbar72@gmail.com';
        $mail->Password   = 'vqqblkrfvgodncnw';
        $mail->SMTPOptions   = array('ssl'=>array(
        	'verify_peen'=>false,
        	'verify_peen_name'=>false,
        	'allow_self_signed'=>false,


        ));
        
        

        // Set email content and recipients
        $mail->setFrom('devakbar72@gmail.com', 'Dev');
        $mail->addAddress($to);
        $mail->Subject = $subject;
        $mail->Body    = $message;

        // Send the email
        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

?>
