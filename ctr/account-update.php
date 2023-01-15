<?php
require_once 'php/autoload.php';

// MAKE SURE A SUBSCRIBER IS LOGGED IN
if($login != true or $subscriberUsername == NULL)
{
    $redirect = 'home.php';
    $pageTitle = 'Unauthorized access ... returning home';
    require_once 'redirect.php';
    exit();
} // end if $subscriberUsername

// MAKE SURE THE ACCOUNT UPDATE FORM WAS SUBMITTED
if(isset($_POST['validation']))
{
    $redirect = 'account.php';
    
    // GET FORM INPUT FIELDS
    $inputUsername      = test_input($_POST['username']);
    $inputPassword      = test_input($_POST['password']);
    $inputEmail         = test_input($_POST['email']);
    $inputFname         = test_input($_POST['fname']);
    $inputLname         = test_input($_POST['lname']);
    $inputOrganization  = test_input($_POST['organization']);
    $inputJobTitle      = test_input($_POST['job']);
    $inputStreet        = test_input($_POST['street']);
    $inputCity          = test_input($_POST['city']);
    $inputState         = test_input($_POST['state']);
    $inputZip           = test_input($_POST['zip']);
    $inputCountry       = test_input($_POST['country']);
    $inputPhone1        = test_input($_POST['phone1']);
    $inputPhone2        = test_input($_POST['phone2']);
    $inputFax           = test_input($_POST['fax']);
    
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
    $findSub->addFindCriterion('globalID','=='.$subscriberID);
    $result = $findSub->execute();
    if(FileMaker::isError($result)) { echo $result->getMessage(); exit(); }
    $record = $result->getFirstRecord();

    // GET ACCOUNT INFO
    $recordUsername     = $record->getField('ctrexUsername');
    $subscriberPassword = $record->getField('ctrexPassword');
    $email              = $record->getField('EMail');
    $fname              = $record->getField('Contact First Name');
    $lname              = $record->getField('Contact Last Name');
    $organization       = $record->getField('Company Name');
    $jobTitle           = $record->getField('Contact Title');
    $street             = $record->getField('Address');
    $city               = $record->getField('City');
    $state              = $record->getField('State');
    $zip                = $record->getField('Zip');
    $country            = $record->getField('Country');
    $phone1             = $record->getField('PhoneOne');
    $phone2             = $record->getField('PhoneTwo');
    $fax                = $record->getField('Fax');
    
    // UPDATE USERNAME
    if($inputUsername != $recordUsername)
    {
        // CHECK WHETHER THE INPUTTED USERNAME IS AVAILABLE
        $findUsername = $fmsubs->newFindCommand('subbies');
        $findUsername->addFindCriterion('ctrexUsername','=='.$inputUsername);
        $usernameResults = $findUsername->execute();
        
        // IF INPUTTED USERNAME IS AVAILABLE, FM RETURNS AN ERROR BC THERE ARE NO RESULTS
        if(FileMaker::isError($usernameResults)) 
        { 
            // LOOKUP SUBSCRIBER RECORD BY ID AND COMMIT THE USERNAME CHANGE
            $findSub = $fmsubs->newFindCommand('subbies');
            $findSub->addFindCriterion('globalID','=='.$subscriberID);
            $result = $findSub->execute();
            if(FileMaker::isError($result)) { echo $result->getMessage(); exit(); }
            $record = $result->getFirstRecord();
            $record->setField('ctrexUsername', $inputUsername);
            $result = $record->commit();
            if ( FileMaker::isError ($result) )
            {
                $redirect = 'account.php'; require_once 'redirect.php'; exit();
            }
            $_SESSION['subscriberUsername'] = $inputUsername; // update the session variable with the new username once data is committed
        } // end if username available

        // IF NO ERROR, THE USERNAME ALREADY EXISTS - SET AN ERROR FLAG
        else
        {
            //echo 'username unavailable'; exit();
            $_SESSION['error'] = true;
            $_SESSION['error-message'] = 'Sorry, the username "'.$inputUsername.'" is already taken. Please try another username.';
        } // end else 1 or more results
    } // end if $inputUsername != $recordUsername
    
    // UPDATE MODIFIED FIELDS
    if($inputPassword != $subscriberPassword)   { $record->setField('ctrexPassword', $inputPassword); }
    if($inputEmail != $email)                   { $record->setField('EMail', $inputEmail); }
    if($inputFname != $fname)                   { $record->setField('Contact First Name', $inputFname); }
    if($inputLname != $lname)                   { $record->setField('Contact Last Name', $inputLname); }
    if($inputOrganization != $organization)     { $record->setField('Company Name', $inputOrganization); }
    if($inputJobTitle != $jobTitle)             { $record->setField('Contact Title', $inputJobTitle); }
    if($inputStreet != $street)                 { $record->setField('Address', $inputStreet); }
    if($inputCity != $city)                     { $record->setField('City', $inputCity); }
    if($inputState != $state)                   { $record->setField('State', $inputState); }
    if($inputZip != $zip)                       { $record->setField('Zip', $inputZip); }
    if($inputCountry != $country)               { $record->setField('Country', $inputCountry); }
    if($inputPhone1 != $phone1)                 { $record->setField('PhoneOne', $inputPhone1); }
    if($inputPhone2 != $phone2)                 { $record->setField('PhoneTwo', $inputPhone2); }
    if($inputFax != $fax)                       { $record->setField('Fax', $inputFax); }
    $result = $record->commit();
	if ( FileMaker::isError ($result) )
    {
        $redirect = 'account.php'; require_once 'redirect.php'; exit();
    }
} else { $redirect = 'home.php'; }
?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<meta name = "description" content = "Objective reviews of children's apps, toys, games, and other interactive media"/>
<meta name="google-site-verification" content="QifxFlcb5iOlsJFTJF2jL-h3lpo12RQeFuOyK6aak8k" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="refresh" content="0;url=<?php echo $redirect;?>">
<title>Updating account information...</title>
</head>
<body>
</body>
</html>