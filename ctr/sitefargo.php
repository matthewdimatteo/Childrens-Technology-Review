<?php
/*
HOW TO USE THIS FILE:

The file should be named to correspond with the Portal URL specified for the Site Admin's record in the subbies database
For example, if the Portal URL reads "https://reviews.childrenstech.com/ctr/sitectr.php", this file should be named "sitectr.php"

All you need to modify is the $recordID value below. Enter the value from the globalID field for the Site Admin's record in the subbies database
*/
$recordID = '71963'; // this value should be the globalID field on the site admin's record in subbies

/* 
HOW THIS FILE WORKS:

The following code will lookup the Site Admin's record to check whether the Site License is currently active
If active, the user will be redirected to the CTR home page with a validated login (if expired, an error message will inform the user of this)
The site will show that they are logged in under their organization name as entered in the Company Name field on the Site Admin's record in the subbies database
If no Company Name is provided, the text will default to "Site License"
The user will not have access to any profile page but will have full access to the review database as a subscriber would
The Site Admin will have subscriber access and access to their personal CTR account using the login on their subbies record
*/

/* *************** DO NOT MODFIFY PAST THIS POINT ***************  */
require_once 'php/autoload.php';

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
$findSub->addFindCriterion('globalID','=='.$recordID);
$result = $findSub->execute();
if(FileMaker::isError($result))
{ 
    // set a flag to show error message after redirect
    $_SESSION['error'] 			= true;
    $_SESSION['error-message'] 	= 'Sorry, the record ID for this license has not been configured correctly.<br/><a href = "about.php#contact">Contact us</a> to resolve this error.';
    $redirect = 'home.php'; require_once 'redirect.php'; exit();
} // end if error
$record = $result->getFirstRecord();

// HANDLE EXPIRED LICENSES
$expDate = $record->getField('expDate');
$expDateTime = strtotime($expDate);
if($expDateTime < $dateConvTime)
{
    $_SESSION['error'] 			= true;
    $_SESSION['error-message'] 	= 'Sorry, your site license has expired, as of '.$expDate.'. <a href = "licenses.php">Renew</a>';
} // end if expired

// VALIDATE THE LOGIN FOR ACTIVE LICENSES
else
{
    $companyName = $record->getField('Company Name');
    $_SESSION['licenseName'] = $companyName;
    $_SESSION['login']   = true;
    $_SESSION['license'] = true;
}

$redirect = 'home.php';
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