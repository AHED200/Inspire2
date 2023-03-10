<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

//Get sender information from request
$name = $_POST['name'];
$subject = $_POST['subject'];
$email = $_POST['email'];
$phoneNumber = $_POST['phone-number'];

if (!isset($_POST['phone-number'])) {
    $phoneNumber = 'null';
}

$emailMessage = "
<strong>Name: </strong>
" . $name . "

<br>
<strong>Phone number: </strong>
" . $phoneNumber . "

<br>
<strong>Sender email: </strong>
" . $email . "

<br>
<strong>Subject: </strong>
" . $subject . "

<br>
<strong>Message: </strong>
" . $_POST['email-message'];



try {
    //Server settings
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp-relay.sendinblue.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'AhmedDeve@hotmail.com';                     //SMTP username
    $mail->Password   = '6QqIDvj30skdW9yY';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
    $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('contactform.itechno@sendinblue.com', 'Contact Request');
    $mail->addAddress('Ahmed.iTechno.services@gmail.com', 'Ahmed Nasser');     //Add a recipient

    // //Attachments
    // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = $subject;
    $mail->Body    = $emailMessage;
    // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();

    header("Location: https://itechno.rf.gd?status=success#contact");
    exit;
} catch (Exception $e) {
    // echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    header("Location: https://itechno.rf.gd?status=failed#contact");
}
