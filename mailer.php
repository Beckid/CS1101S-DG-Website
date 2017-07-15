<?php
// To load the email box configuration.
require_once 'config.php';
// To use the auto-loader class for PHPMailer.
require 'phpmailer/PHPMailerAutoload.php';

// Standard email function ready for use.
function email($to, $subject, $body) {
	// Create a new PHPMailer instance
	$mail = new PHPMailer;

	// Tell PHPMailer to use SMTP
	$mail->isSMTP();

	// Enable SMTP debugging (2 => client and server messages)
	// Notice: change it to 0 in the production environment
	$mail->SMTPDebug = 0;

	// Ask for HTML-friendly debug output
	$mail->Debugoutput = 'html';

	// Set the hostname of the mail server
	$mail->Host = 'smtp.gmail.com';

	// Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
	$mail->Port = 587;

	// Set the encryption system to use - ssl (deprecated) or tls
	$mail->SMTPSecure = 'tls';

	// Whether to use SMTP authentication
	$mail->SMTPAuth = true;

	// Username to use for SMTP authentication - use full email address for gmail
	$mail->Username = EMAIL_ADDR;

	// Password to use for SMTP authentication
	$mail->Password = EMAIL_PWORD;

	// Set who the message is to be sent from
	$mail->setFrom(EMAIL_ADDR, 'CS1101S DG Website');

	// Set an alternative reply-to address
	$mail->addReplyTo(EMAIL_ADDR, 'Website Admin');

	// Always BCC'ed to admin's personal email.
	$mail->addBCC(ADMIN_EMAIL);

	// Set who the message is to be sent to
	$mail->addAddress($to);

	// Set the subject line
	$mail->Subject = $subject;

	// Replace the plain text body with one created manually
	$mail->Body = $body;

	// Return true if the email has been sent successfully, otherwise false.
	if ($mail->send()) {
		return true;
	} else {
		echo "Error when sending email: " . $mail->ErrorInfo;
		return false;
	}
}
?>