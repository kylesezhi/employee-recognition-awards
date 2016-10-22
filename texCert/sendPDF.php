<?php
	ini_set('display_errors', 'On');
	
	require "./mailer/PHPMailerAutoload.php";
	 
 function sendPDF($email, $pdfFile, $data){
	 date_default_timezone_set ('Etc/UTC');

	//new mail instance 
	$mail = new PHPMailer(); 
	 
	//sender info  setfrom must be from domain to avoid spam filter. set reply to valid email
	$mail -> setFrom("cskTEch@web.engr.oregonstate.edu", $data['giveName']);
	$mail -> AddReplyTo ("pikec@oregonstate.edu");
		
	//receipent info
	$mail -> addAddress($email, $data['recName']);
	
	//subject line
	$mail -> Subject = $data['titleAward'] . " has been awarded.";
	
	//read html message
	$body = "HTML message here";
	$mail ->MsgHTML($body);
	
	//attachment
	$mail ->AddAttachment($pdfFile);
	
	//send and check for error
	if(!$mail -> Send()){
		echo "Error sending mail. Error Code: " . $mail -> ErrorInfo;
	}
	
	echo "Message sent.";
 }
?>