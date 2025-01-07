<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;
use \ReCaptcha\ReCaptcha;

require './vendor/autoload.php';


if (!empty($_POST['website']))
	die();

if (isset($_POST['email']) && !empty($_POST['email'])) {

	$timestamp_capture = time();
	//$reg_time = date('d-m-Y h:i:s a', time());
	$remoteip = $_SERVER['REMOTE_ADDR'];
	//$reg_ip_proxy = $_SERVER['HTTP_X_FORWARDED_FOR'];
	$hostname = $_SERVER['SERVER_NAME'];

	$siteurl = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on'
		? "https://{$hostname}"
		: "http://{$hostname}";



	$email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
	$name = $_POST["name"];
	$message = $_POST["message"];
	$g_recaptcha_response = $_POST["g-recaptcha-response"];
	$g_recaptcha_secret = "6LcU1a8qAAAAAMmn7yqkQsk8jQdb6UW13wUbIFC6";

	$recaptcha = new ReCaptcha($g_recaptcha_secret, null);

	$recaptcha_result = $recaptcha->setExpectedHostname($hostname)
		->setExpectedAction("submit")
		->setScoreThreshold(0.5)
		->verify($g_recaptcha_response, $remoteip);

	if (!($recaptcha_result->isSuccess())) {
		$response['status'] = 'Error';
		$response['msg'] = 'Our sources have detected unusual traffic. Rejecting. Error Code 3';
		$response['score'] = $recaptcha_result->getScore();
		echo json_encode($response);
		return;
	}






	// $to = "acousticalinsightswebsite@gmail.com";
	$to = "cmrinal16@gmail.com";
	$mail_subject = "Contact Request From $name | Message ID " . $timestamp_capture;
	$mail_message = "
		<br>
		<p>A contact request is made from $name. Details are as below:</p>
		<br>
		<p><strong>Name:</strong> $name</p> 
		<p><strong>Email:</strong> $email</p> 
		<p><strong>Message:</strong></p>
		<p>$message</p>
		<br><br><br>...<br>
		This message is sent from $siteurl using a contact form.
		";
	$headers = "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
	// More headers
	$headers .= 'From: ' . $name . ' <noreply@' . $_SERVER['SERVER_NAME'] . '>' . "\r\n" . 'Reply-To: ' . $email . "\r\n";
	$mail = new PHPMailer(true);

	try {
		//Server settings
		// $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
		$mail->isSMTP();                                            //Send using SMTP
		$mail->Host = 'smtp.gmail.com';                     //Set the SMTP server to send through
		$mail->SMTPAuth = true;                                   //Enable SMTP authentication
		$mail->Username = 'acousticalinsightswebsite@gmail.com';                     //SMTP username
		$mail->Password = 'eqsp iptj zngg ppzl';                               //SMTP password
		// $mail->Password = 'eqsp iptj zngg ppzlee';                               //SMTP password

		$mail->SMTPSecure = "ssl";            //Enable implicit TLS encryption
		$mail->Port = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

		//Recipients
		$mail->setFrom($email, $name);
		$mail->addAddress($to, 'Acoustical Insights');     //Add a recipient


		//Content
		$mail->isHTML(true);                                  //Set email format to HTML
		$mail->Subject = $mail_subject;
		$mail->Body = $mail_message;

		$mail->send();
		$response['status'] = 'OK';
		$response['msg'] = 'Message Sent Successfully.';
		echo json_encode($response);
	} catch (Exception $e) {
		echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
		$response['status'] = 'ERROR';
		$response['msg'] = 'Something Went Wrong. Error Code: 2';
		echo json_encode($response);
	}



} else {
	$response['status'] = 'Error';
	$response['msg'] = 'Something Went Wrong. Error Code: 1';
	echo json_encode($response);
}
?>