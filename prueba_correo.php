<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'Recursos/phpMailer/Exception.php';
require 'Recursos/phpMailer/PHPMailer.php';
require 'Recursos/phpMailer/SMTP.php';

function enviar_email($email, $nombre, $asunto, $cuerpo){
	// Instantiation and passing `true` enables exceptions
	$mail = new PHPMailer(true);

	try {
	    $mail->SMTPDebug = 5;                      // Enable verbose debug output
	    $mail->isSMTP();                                            // Send using SMTP
	    $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
	    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
	    $mail->Username   = 's0p0rt3linea@gmail.com';                     // SMTP username
	    $mail->Password   = 'kevin110590';                               // SMTP password
	    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
	    $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

	    //Recipients
	    $mail->setFrom('s0p0rt3linea@gmail.com', 'KodePrint');
	    $mail->addAddress($email, $nombre);     // Add a recipient
//	    $mail->addAddress('ellen@example.com');               // Name is optional
//	    $mail->addReplyTo('info@example.com', 'Information');
//	    $mail->addCC('cc@example.com');
//	    $mail->addBCC('bcc@example.com');

	    // Attachments
//	    $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//	    $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

	    // Content
	    $mail->isHTML(true);                                  // Set email format to HTML
	    $mail->Subject = $asunto;
	    $mail->Body    = $cuerpo;
//	    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

	    $mail->send();
		return true;
	} catch (Exception $e) {
		return false;
	}
}
