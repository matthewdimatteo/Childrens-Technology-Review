<?php
require_once 'php/autoload.php';

// MAKE SURE A PUBLISHER IS LOGGED IN
if($publisher != true or $publisherUsername == NULL)
{
    $redirect = 'home.php';
    $pageTitle = 'Unauthorized access ... returning home';
    require_once 'redirect.php';
    exit();
} // end if !$publisherrUsername

// MAKE SURE THE ACCOUNT UPDATE FORM WAS SUBMITTED
if(isset($_POST['validation']))
{
    $redirect = 'publisher.php';
    
    // GET FORM INPUT FIELDS
    $inputPassword      = test_input($_POST['password']);
	$inputWebsite       = test_input($_POST['website']);
    $inputEmail         = test_input($_POST['email']);
    $inputFname         = test_input($_POST['fname']);
    $inputLname         = test_input($_POST['lname']);
    $inputJobTitle      = test_input($_POST['job']);
    $inputStreet        = test_input($_POST['street']);
    $inputCity          = test_input($_POST['city']);
    $inputState         = test_input($_POST['state']);
    $inputZip           = test_input($_POST['zip']);
    $inputCountry       = test_input($_POST['country']);
    $inputPhone1        = test_input($_POST['phone1']);
    $inputPhone2        = test_input($_POST['phone2']);
    $inputFax           = test_input($_POST['fax']);
	
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
    $findPub->addFindCriterion('username','=='.$publisherUsername);
    $findPub->addFindCriterion('recordID','=='.$publisherID);
    $result = $findPub->execute();
    if(FileMaker::isError($result)) { echo $result->getMessage(); exit(); }
    $record = $result->getFirstRecord();
	
	// UPDATE MODIFIED FIELDS
    if($inputPassword != $publisherPassword)    { $record->setField('password', $inputPassword); }
	if($inputWebsite != $website)               { $record->setField('Web site', $inputWebsite); }
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
        $redirect = 'publisher.php'; require_once 'redirect.php'; exit();
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