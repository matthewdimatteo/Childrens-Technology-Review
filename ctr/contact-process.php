<?php
require_once 'php/autoload.php';
$redirect = 'contact.php';

// MAKE SURE THE CONTACT FORM WAS SUBMITTED
if(isset($_POST['validation']))
{
	// GET FORM INPUT FIELDS
    $name 	 = test_input($_POST['name']);
	$email	 = test_input($_POST['email']);
	$message = test_input($_POST['message']);
	$_SESSION['contactInput'] = array($name, $email, $message);
	require_once 'php/captcha-check.php';
	
	// FORMAT AND SEND EMAIL TO CTR
    $emailSubject = 'CTR Contact Form Submission';
    $emailMessage = 'Name: '.$name."\r\n".
					'Email: '.$email."\r\n".
					'Message: '.$message."\r\n".
					"\r\n".
					'IP: '.$ip."\r\n";
	$emailHeaders = 'From: '.$sender.' ' . "\r\n" .
                    'Reply-To: '.$sender.' ' . "\r\n" .
                    'X-Mailer: PHP/' . phpversion();
	mail($emailUs, $emailSubject, $emailMessage, $emailHeaders); // $emailUs set in autoload.php
	
	// FORMAT AND SEND EMAIL TO USER - $ip, $emailUs, $sender set in autoload.php
    $emailTo 	  = $email;
    $emailSubject = 'Your CTR Contact Form Message Has Been Submitted';
    $emailMessage = 'Your CTR contact form submission has been received:'."\r\n".
					"\r\n".
					'Name: '.$name."\r\n".
					'Email: '.$email."\r\n".
					'Message: '.$message."\r\n";
	$emailHeaders = 'From: '.$sender.' ' . "\r\n" .
                    'Reply-To: '.$sender.' ' . "\r\n" .
                    'X-Mailer: PHP/' . phpversion();
    mail($emailTo, $emailSubject, $emailMessage, $emailHeaders);
	
	// SET CONFIRMATION MESSAGE
    $_SESSION['confirmation']	= true;
    $_SESSION['confirmation-message'] = 'Your contact form message has been submitted. A confirmation has been sent to '.$email;
} // end if isset
?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<meta name = "description" content = "Objective reviews of children's apps, toys, games, and other interactive media"/>
<meta name="google-site-verification" content="QifxFlcb5iOlsJFTJF2jL-h3lpo12RQeFuOyK6aak8k" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="refresh" content="0;url=<?php echo $redirect;?>">
<title>Submitting message...</title>
</head>
<body>
</body>
</html>