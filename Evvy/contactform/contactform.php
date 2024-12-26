<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require './src/Exception.php';
require './src/PHPMailer.php';
require './src/SMTP.php';

if(empty($_SESSION['captcha_code'] ) || strcasecmp($_SESSION['captcha_code'], $_POST['captcha_code']) != 0){  
	$msg="<span style='color:red'>The Validation code does not match!</span>";// Captcha verification is incorrect.             
}else{// Captcha verification is Correct. Final Code Execute here!              
	$msg="<span style='color:green'>The Validation code has been matched.</span>";              
}

if(isset($_POST['email']) && !empty($_POST['email'])){

		// $name = filter_var($_POST["name"], FILTER_SANITIZE_STRING);
		$email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
		// $message = filter_var($_POST["message"], FILTER_SANITIZE_STRING);
		$name = $_POST["name"];
		$message = $_POST["message"];


		//date_default_timezone_set('Asia/Kolkata');
		$timestamp_capture = time();
		//$reg_time = date('d-m-Y h:i:s a', time());
		//$reg_ip = $_SERVER['REMOTE_ADDR'];
		//$reg_ip_proxy = $_SERVER['HTTP_X_FORWARDED_FOR'];

		if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on'){
	    	$siteurl = "https://".$_SERVER['SERVER_NAME'];
	    }else{
	    	$siteurl = "http://".$_SERVER['SERVER_NAME'];
	    }

	
		$to = "acousticalinsightswebsite@gmail.com";
		$mail_subject = "Contact Request From $name | Message ID ".$timestamp_capture;
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
		$headers .= 'From: '.$name.' <noreply@'.$_SERVER['SERVER_NAME'].'>' . "\r\n" . 'Reply-To: '.$email."\r\n";
		$mail = new PHPMailer(true);

		try {
			//Server settings
			// $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
			$mail->isSMTP();                                            //Send using SMTP
			$mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
			$mail->SMTPAuth   = true;                                   //Enable SMTP authentication
			$mail->Username   = 'acousticalinsightswebsite@gmail.com';                     //SMTP username
			$mail->Password   = 'eqsp iptj zngg ppzl';                               //SMTP password

			$mail->SMTPSecure = "ssl";            //Enable implicit TLS encryption
			$mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

			//Recipients
			$mail->setFrom($email, $name);
			$mail->addAddress($to, 'Acoustical Insights');     //Add a recipient


			//Content
			$mail->isHTML(true);                                  //Set email format to HTML
			$mail->Subject = $mail_subject;
			$mail->Body    = $mail_message;

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
	
			

}else{
	$response['status'] = 'Error';
	$response['msg'] = 'Something Went Wrong. Error Code: 1';
	echo json_encode($response);
}
?>