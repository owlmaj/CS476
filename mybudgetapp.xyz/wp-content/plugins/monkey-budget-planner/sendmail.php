<?php
header('Location: ' . $_SERVER['HTTP_REFERER'] . '?status=1');


error_reporting(E_ALL);
ini_set('display_errors', 1);






if($_POST["email"]==""){
echo "Fill All Fields..";
}else{
	$to = "brian@nmcreative.co.uk";
	$email=$_POST['email'];
	$name=$_POST['name'];
	// Sanitize E-mail Address
	$email =filter_var($email, FILTER_SANITIZE_EMAIL);
	// Validate E-mail Address
	$email= filter_var($email, FILTER_VALIDATE_EMAIL);
	if (!$email){
	echo "Invalid Sender's Email";
	}
	else
	{
		
	
			$subject = ''.$name.' - Your Budget Form Result';
			$data = $_POST['data'];
			$message = "
			    <html>
			    	$data
			    </html>
			    ";
			// Set content-type header for sending HTML email
			$headers = "MIME-Version: 1.0" . "\r\n";
			$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
			$headers .= "To: $email\r\n";
			
			
			
			// Send Mail By PHP Mail Function
			mail($email, $subject, $message, $headers);

	
		
	}
}







?>