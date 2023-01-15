<?php
require_once 'php/autoload.php';
$redirect = 'publishers.php';

// PROCESS PUBLISHER ACCOUNT LOOKUP FORM
if(isset($_POST['validation']))
{
    // GET FORM INPUTS
    $inputCompany 	= test_input($_POST['company']);
    $inputEmail 	= test_input($_POST['email']);
	$inputPhone	 	= test_input($_POST['phone']);
	$_SESSION['publisherInput'] = array($inputCompany, $inputEmail, $inputPhone);
	require_once 'php/captcha-check.php';

	// CONNECT TO PUBLISHER DATABASE
    $fmpubs = new FileMaker();
    $fmpubs->setProperty('database', 'Producers');
    $fmpubs->setProperty('username', $username);
    $fmpubs->setProperty('password', $password);
    $fmpubs->setProperty('hostspec', $hostspec);
    $fmpubsLayout = 'php-publishers';
    $layoutpubs = $fmpubs->getLayout($fmpubsLayout);

    // LOOKUP PUBLISHER RECORD IN DATABASE
    $findPub = $fmpubs->newFindCommand($fmpubsLayout);
    $findPub->addFindCriterion('Company Name', '=='.$inputCompany);
	$findPub->addFindCriterion('dup', "=");
    $result = $findPub->execute();
	
	// IF COMPANY NAME NOT FOUND, REDIRECT USER WITH ERROR MESSAGE
    if(FileMaker::isError($result))
    { 
        // set a flag to show error message after redirect
        $_SESSION['error'] 			= true;
        $_SESSION['error-message'] 	= 'Sorry, the company name you entered was not found in our records. Please try again.';
    } // end if error
	
	// IF USERNAME FOUND, NEXT CHECK PHONE NUMBER MATCH
	else
	{
        $findPhoneOne = $fmpubs->newFindCommand($fmpubsLayout);
        $findPhoneOne->addFindCriterion('Company Name', '=='.$inputCompany);
		$findPhoneOne->addFindCriterion('dup', "=");
        $findPhoneOne->addFindCriterion('directory', "=*$inputPhone*");
        $result = $findPhoneOne->execute();

        // IF INCORRECT PHONE NUMBER, REDIRECT USER WITH ERROR MESSAGE
        if(FileMaker::isError($result))
        { 
            // set a flag to show error message after redirect
            $_SESSION['error'] 			= true;
            $_SESSION['error-message'] 	= 'Sorry, the phone number you entered was not found for the account with that company name. Please try again.';
        } // end if error
	} // end else
	// IF IDENTITY CONFIRMED, LOOKUP PASSWORD, EMAIL IT TO THE ADDRESS SPECIFIED, AND DISPLAY CONFIRMATION MESSAGE
	$error = $_SESSION['error'];
	if($error != true)
	{
		// LOOKUP PASSWORD ON SUBSCRIBER'S RECORD
		$record = $result->getFirstRecord();
		$recordUsername = $record->getField('username');
		$recordPassword = $record->getField('password');
		
		// FORMAT AND SEND EMAIL TO USER
		$emailTo 	  = $inputEmail;
		$emailSubject = 'Your CTR Publisher Account';
		$emailMessage = 'Your CTR publisher account has been activated. '."\r\n".
						"\r\n".
						'Username: '.$recordUsername."\r\n".
						'Password: '.$recordPassword."\r\n".
						"\r\n".
						'Remember to check the box for "Log in as publisher" when logging in.';
		$emailHeaders = 'From: '.$sender.' ' . "\r\n" .
						'Reply-To: '.$sender.' ' . "\r\n" .
						'X-Mailer: PHP/' . phpversion();
		mail($emailTo, $emailSubject, $emailMessage, $emailHeaders);
		
		// SET CONFIRMATION MESSAGE
		$_SESSION['confirmation']	= true;
		$_SESSION['confirmation-message'] = 'Your password has been emailed to '.$inputEmail;
		
		// FORMAT AND SEND EMAIL TO CTR - $ip, $emailUs, $sender set in autoload.php
        $emailSubject = 'CTR Publisher Login Request';
        $emailMessage = 'Company: '.$inputCompany."\r\n".
                        'Email: '.$inputEmail."\r\n".
                        'Phone: '.$inputPhone."\r\n".
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