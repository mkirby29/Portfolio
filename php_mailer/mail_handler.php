<?php
require_once('email_config.php');
require('phpmailer/PHPMailer/PHPMailerAutoload.php'); //loading code for object doing all the work

foreach($_POST as $key => $value){
    $_POST[$key] = htmlentities(addslashes($value));
}




$mail = new PHPMailer;          //instantiating a new objectin PHPMailer
$mail->SMTPDebug = 3;           // Enable verbose debug output. Change to 0 to disable debugging output.

$mail->isSMTP();                // Set mailer to use SMTP.
$mail->Host = 'smtp.gmail.com'; // Specify main and backup SMTP servers.
$mail->SMTPAuth = true;         // Enable SMTP authentication


$mail->Username = EMAIL_USER;   // SMTP username
$mail->Password = EMAIL_PASS;   // SMTP password
$mail->SMTPSecure = 'tls';      // Enable TLS encryption, `ssl` also accepted, but TLS is a newer more-secure encryption
$mail->Port = 587;              // TCP port to connect to
$options = array(
    'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
    )
);
$mail->smtpConnect($options);
$mail->From = 'bhillscop29@gmail.com';  // sender's email address (shows in "From" field)
$mail->FromName = 'Example Name';   // sender's name (shows in "From" field)
$mail->addAddress('mattkir@aol.com', 'First Recipient');  // Add a recipient
//$mail->addAddress('ellen@example.com');                        // Name is optional
$mail->addReplyTo($_POST['email']);                          // Add a reply-to address
//$mail->addCC('cc@example.com');
//$mail->addBCC('bcc@example.com');

//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = 'mailer message from '.$_POST['name'];
$mail->Body    = "  
    time: ".date('Y-m-d H:is:s')."<br>
    from: {$_SERVER['REMOTE_ADDR']}<br>
    name: {$_POST['name']}</b>
    email: {$_POST['email']}<br>
    subject: {$_POST['subject']}<br>
    message: {$_POST['body']}
";
$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

if(!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message has been sent';
}
?>
