<?php
/*  bolero-web3 CS'419 F'16
** project group: Candis Pike, Shaun Sluman, Kyle Bedell
*/
	ini_set('display_errors', 'On');
	
	require "./mailer/PHPMailerAutoload.php";
	 
 function sendPDF($email, $pdfFile, $data){
	 date_default_timezone_set ('Etc/UTC');

	//new mail instance 
	$mail = new PHPMailer(); 
	 
	//sender info setfrom must be from domain to avoid spam filter. set reply to valid email
	$mail -> setFrom("cskTech@web.engr.oregonstate.edu", $data['giveName']);
	$mail -> AddReplyTo ("pikec@oregonstate.edu");
		
	//receipent info
	$mail -> addAddress($email, $data['recName']);
	
	//subject line
	$mail -> Subject = $data['titleAward'] . " has been awarded.";
	
	//read html message
	$msg = file_get_contents("./template/email_template.html");
	
	//replace placeholders with data
	$msg = str_replace ("%recName%", $data["recName"], $msg);
	$msg = str_replace ("%awardTitle%", $data["titleAward"], $msg);
	$msg = str_replace ("%giveName%", $data["giveName"], $msg);
	
	//set body of email as the html message
	$mail -> isHTML (true);
	$mail -> MsgHTML ($msg);
	$mail -> AltBody = "Congratulations, ". $data["recName"]. "! You have been awarded ". $data["titleAward"] . "by" . $data["giveName"];
	
	//attachment
	$mail ->AddAttachment($pdfFile);
	
	//send and check for error
	if(!$mail -> Send()){
		echo "Error sending mail. Error Code: " . $mail -> ErrorInfo;
	}
	
	echo "Message sent.";
 }
?>