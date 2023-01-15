<?php
require_once 'php/autoload.php';
$redirect = 'password.php';

// PROCESS PASSWORD RECOVERY FORM
if(isset($_POST['validation']))
{
    // GET FORM INPUTS
    $inputUsername 	= test_input($_POST['username']);
    $inputEmail 	= test_input($_POST['email']);
	$inputZip	 	= test_input($_POST['zip']);
	$_SESSION['passwordInput'] = array($inputUsername, $inputEmail, $inputZip);
	require_once 'php/captcha-check.php';
    
	// CONNECT TO SUBSCRIBER DATABASE
    $fmsubs = new FileMaker();
    $fmsubs->setProperty('database', 'subbies');
    $fmsubs->setProperty('username', $username);
    $fmsubs->setProperty('password', $password);
    $fmsubs->setProperty('hostspec', $hostspec);
    $fmsubsLayout = 'subbies';
    $layoutsubs = $fmsubs->getLayout($fmsubsLayout);

    // LOOKUP SUBSCRIBER RECORD IN DATABASE
    $findSub = $fmsubs->newFindCommand($fmsubsLayout);
    $findSub->addFindCriterion('ctrexUsername','=='.$inputUsername);
    $result = $findSub->execute();

    // IF USERNAME NOT FOUND, REDIRECT USER WITH ERROR MESSAGE
    if(FileMaker::isError($result))
    { 
        // set a flag to show error message after redirect
        $_SESSION['error'] 			= true;
        $_SESSION['error-message'] 	= 'Sorry, the username you entered was not found in our records. Please try again.';
    } // end if error
	
	// IF USERNAME FOUND, NEXT CHECK ZIP CODE MATCH
	else
	{
        $findZip = $fmsubs->newFindCommand($fmsubsLayout);
        $findZip->addFindCriterion('ctrexUsername','=='.$inputUsername);
        $findZip->addFindCriterion('Zip','=='.$inputZip);
        $result = $findZip->execute();

        // IF INCORRECT ZIP CODE, REDIRECT USER WITH ERROR MESSAGE
        if(FileMaker::isError($result))
        { 
            // set a flag to show error message after redirect
            $_SESSION['error'] 			= true;
            $_SESSION['error-message'] 	= 'Sorry, the zip code you entered was not found for the account with that username. Please try again.';
        } // end if error
	} // end else
	
	// IF IDENTITY CONFIRMED, LOOKUP PASSWORD, EMAIL IT TO THE ADDRESS SPECIFIED, AND DISPLAY CONFIRMATION MESSAGE
	$error = $_SESSION['error'];
	if($error != true)
	{
		// LOOKUP PASSWORD ON SUBSCRIBER'S RECORD
		$record = $result->getFirstRecord();
		$recordPassword = $record->getField('ctrexPassword');
		
		// FORMAT AND SEND EMAIL TO USER
		$emailTo 	  = $inputEmail;
		$emailSubject = 'Your CTR Password';
		$emailMessage = 'Your CTR password recovery request has been completed. For the username '.$inputUsername.', the password is '.$recordPassword;
		$emailHeaders = 'From: '.$sender.' '."\r\n".
						'Reply-To: '.$sender.' '."\r\n".
						'X-Mailer: PHP/' . phpversion();
		mail($emailTo, $emailSubject, $emailMessage, $emailHeaders);
		
		// SET CONFIRMATION MESSAGE
		$_SESSION['confirmation']	= true;
		$_SESSION['confirmation-message'] = 'Your password has been emailed to '.$inputEmail;
		
		// FORMAT AND SEND EMAIL TO CTR - $ip, $emailUs, $sender set in autoload.php
        $emailSubject = 'CTR Password Recovery Request';
        $emailMessage = 'Username: '.$inputUsername."\r\n".
                        'Email: '.$inputEmail."\r\n".
                        'Zip: '.$inputZip."\r\n".
						'IP: '.$ip."\r\n";
        $emailHeaders = 'From: '.$sender.' ' . "\r\n" .
                        'Reply-To: '.$sender.' ' . "\r\n" .
                        'X-Mailer: PHP/' . phpversion();
        mail($emailUs, $emailSubject, $emailMessage, $emailHeaders);
	} // end if !$error
} // end if isset validation
?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<meta name = "description" content = "Objective reviews of children's apps, toys, games, and other interactive media"/>
<meta name="google-site-verification" content="QifxFlcb5iOlsJFTJF2jL-h3lpo12RQeFuOyK6aak8k" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="refresh" content="0;url=<?php echo $redirect;?>">
<title>Looking up record...</title>
</head>
<body>
</body>
</html>