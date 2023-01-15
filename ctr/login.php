<?php
require_once 'php/autoload.php';

// PROCESS LOGIN FORM
if(isset($_POST['username']))
{
    // GET FORM INPUTS
    $inputUsername = test_input($_POST['username']);
    $inputPassword = test_input($_POST['password']);
	$inputPublisher= test_input($_POST['publisher']);
    $redirect      = test_input($_POST['redirect']);
	
	// HANDLE PUBLISHER LOGIN
	if($inputPublisher != NULL)
	{
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
        $findPub->addFindCriterion('username','=='.$inputUsername);
        $findPub->addFindCriterion('password','=='.$inputPassword);
        $result = $findPub->execute();
		
		// IF INCORRECT CREDENTIALS, REDIRECT USER WITH ERROR MESSAGE
        if(FileMaker::isError($result))
        { 
            // set a flag to show error message after redirect
            $_SESSION['error'] 			= true;
            $_SESSION['error-message'] 	= 'Sorry, the username or password you entered is incorrect. Please try again.';
        } // end if error
		
		// IF VALID CREDENTIALS, GET PUBLISHER RECORD DATA AND VALIDATE LOGIN
		else
		{
			// get profile info from database and save in session
            $record 		   = $result->getFirstRecord();
            $publisherID	   = $record->getField('recordID');
            $publisherUsername = $record->getField('username');
            $publisherName 	   = $record->getField('Company Name');
			
			$_SESSION['login'] 				= true;
			$_SESSION['publisher'] 			= true;
			$_SESSION['publisherID'] 		= $publisherID;
			$_SESSION['publisherUsername'] 	= $publisherUsername;
			$_SESSION['publisherName'] 		= $publisherName;
		} // end else valid login
		
	} // end if logging in as publisher
    
	// HANDLE SUBSCRIBER LOGIN
	else
	{
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
        $findSub->addFindCriterion('ctrexPassword','=='.$inputPassword);
        $result = $findSub->execute(); 

        // IF INCORRECT CREDENTIALS, REDIRECT USER WITH ERROR MESSAGE
        if(FileMaker::isError($result))
        { 
            // set a flag to show error message after redirect
            $_SESSION['error'] 			= true;
            $_SESSION['error-message'] 	= 'Sorry, the username or password you entered is incorrect. Please try again.';
        } // end if error

        // IF ACCOUNT EXISTS
        else
        {
            // GET ACCOUNT INFO
            $record 		    = $result->getFirstRecord();
            $subscriberID 	    = $record->getField('globalID');
            $subscriberUsername = $record->getField('ctrexUsername');
			$temp				= $record->getField('temp');
			$_SESSION['subscriberID']       = $subscriberID;
            $_SESSION['subscriberUsername'] = $subscriberUsername;

            // HANDLE EXPIRED SUBSCRIPTIONS
            $expDate = $record->getField('expDate');
            $expDateTime = strtotime($expDate);
            if($expDateTime < $dateConvTime)
            {
                $_SESSION['error'] 			= true;
                $_SESSION['error-message'] 	= 'Sorry, your subscription has expired, as of '.$expDate.'. <a href = "subscribe.php">Renew</a>';
            } // end if expired

            // HANDLE VALID LOGIN
            else
            {
                $_SESSION['login'] = true;
				if($temp != NULL) { $_SESSION['temp'] = true; }
				else 			  { $_SESSION['subscriber'] = true; }
				$_SESSION['freeMode'] = '';
            } // end success
        } // end eaccount exists
	} // end if subscriber login
} // end if form field isset
else { $redirect = 'home.php'; }
/*
echo '$inputUsername: '.$inputUsername.'<br/>';
echo '$inputPassword: '.$inputPassword.'<br/>';
echo '$login: '.$login.'<br/>';
echo '$subscriberID: '.$subscriberID.'<br/>';
echo '$username: '.$username.'<br/>';
echo '$substatus: '.$substatus.'<br/>';
echo '$expDate: '.$expDate.'<br/>';
*/  
?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<meta name = "description" content = "Objective reviews of children's apps, toys, games, and other interactive media"/>
<meta name="google-site-verification" content="QifxFlcb5iOlsJFTJF2jL-h3lpo12RQeFuOyK6aak8k" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="refresh" content="0;url=<?php echo $redirect;?>">
<title>Logging in...</title>
</head>
<body>
</body>
</html>