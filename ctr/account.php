<?php
require_once 'php/autoload.php';

// MAKE SURE A SUBSCRIBER IS LOGGED IN
if($subscriber != true or $subscriberUsername == NULL)
{
    $redirect = 'home.php';
    $pageTitle = 'Unauthorized access ... returning home';
    require_once 'redirect.php';
    exit();
} // end if !$subscriberUsername

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
$subscriberPassword = $record->getField('ctrexPassword');
$email              = $record->getField('EMail');
$startDate          = $record->getField('startDate');
$expDate            = $record->getField('expDate');
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
?>

<!doctype html>
<html>
<head>
    <?php require_once 'php/head.php';?>
    <title><?php echo $subscriberUsername.'\'s CTR Account';?></title>
</head>

<body>
    <div id = "main">
        <?php require_once 'php/header.php';?>
        <div id = "content">
            <div class = "center" id = "account">
                <h1><?php echo $subscriberUsername;?>'s CTR Account</h1>
            
                <div class = "paragraph">
                    <p>
                        This information is only used for managing your preferences associated with your CTR subcription. To update your information, modify the corresponding fields and select "Update Account Information" at the bottom of this page.
                    </p>
                    
                    <!-- FORM START -->
                    <form name = "account-update-form" method = "POST" action = "account-update.php">
                        
                        <!-- SUBSCRIPTION INFO -->
                        <div class = "form-row">
                            <div class = "form-label">Username:</div>
                            <div class = "form-field"><input type = "text" name = "username" value = "<?php echo $subscriberUsername;?>"/></div>
                        </div><!-- /.form-row -->
                        <div class = "form-row">
                            <div class = "form-label">Password:</div>
                            <div class = "form-field"><input type = "text" name = "password" value = "<?php echo $subscriberPassword;?>"/></div>
                        </div><!-- /.form-row -->
                        <div class = "form-row">
                            <div class = "form-label">Email:</div>
                            <div class = "form-field"><input type = "text" name = "email" value = "<?php echo $email;?>"/></div>
                        </div><!-- /.form-row -->
                        <div class = "form-row-static">
                            <div class = "form-label-static">Start Date:</div><div class = "form-field-static"><?php echo $startDate;?></div>
                        </div><!-- /.form-row -->
                        <div class = "form-row-static">
                            <div class = "form-label-static">Exp. Date:</div><div class = "form-field-static"><?php echo $expDate;?> <a href = "subscribe.php">Add 1 Year</a></div>
                        </div><!-- /.form-row -->
                        
                        <!-- CONTACT INFO -->
                        <div class = "form-row">
                            <div class = "form-label">First Name:</div>
                            <div class = "form-field"><input type = "text" name = "fname" value = "<?php echo $fname;?>"/></div>
                        </div><!-- /.form-row -->
                        <div class = "form-row">
                            <div class = "form-label">Last Name:</div>
                            <div class = "form-field"><input type = "text" name = "lname" value = "<?php echo $lname;?>"/></div>
                        </div><!-- /.form-row -->
                        <div class = "form-row">
                            <div class = "form-label">Organization:</div>
                            <div class = "form-field"><input type = "text" name = "organization" value = "<?php echo $organization;?>"/></div>
                        </div><!-- /.form-row -->
                        <div class = "form-row">
                            <div class = "form-label">Job Title:</div>
                            <div class = "form-field"><input type = "text" name = "job" value = "<?php echo $jobTitle;?>"/></div>
                        </div><!-- /.form-row -->
                        <div class = "form-row">
                            <div class = "form-label">Street Address:</div>
                            <div class = "form-field"><input type = "text" name = "street" value = "<?php echo $street;?>"/></div>
                        </div><!-- /.form-row -->
                        <div class = "form-row">
                            <div class = "form-label">City:</div>
                            <div class = "form-field"><input type = "text" name = "city" value = "<?php echo $city;?>"/></div>
                        </div><!-- /.form-row -->
                        <div class = "form-row">
                            <div class = "form-label">State:</div>
                            <div class = "form-field"><input type = "text" name = "state" value = "<?php echo $state;?>"/></div>
                        </div><!-- /.form-row -->
                        <div class = "form-row">
                            <div class = "form-label">Zip:</div>
                            <div class = "form-field"><input type = "text" name = "zip" value = "<?php echo $zip;?>"/></div>
                        </div><!-- /.form-row -->
                        <div class = "form-row">
                            <div class = "form-label">Country:</div>
                            <div class = "form-field"><input type = "text" name = "country" value = "<?php echo $country;?>"/></div>
                        </div><!-- /.form-row -->
                        <div class = "form-row">
                            <div class = "form-label">Phone 1:</div>
                            <div class = "form-field"><input type = "text" name = "phone1" value = "<?php echo $phone1;?>"/></div>
                        </div><!-- /.form-row -->
                        <div class = "form-row">
                            <div class = "form-label">Phone 2:</div>
                            <div class = "form-field"><input type = "text" name = "phone2" value = "<?php echo $phone2;?>"/></div>
                        </div><!-- /.form-row -->
                        <div class = "form-row">
                            <div class = "form-label">Fax:</div>
                            <div class = "form-field"><input type = "text" name = "fax" value = "<?php echo $fax;?>"/></div>
                        </div><!-- /.form-row -->
                        
                        <input type = "hidden" name = "validation" value = "true" />
                        <div class = "form-row-submit">
                            <div class = "center"><input type = "submit" value = "Update Account Information" /></div>
                        </div><!-- /.form-row -->
                    </form>
                    
                </div><!-- /.paragraph -->
            </div><!-- /.center /#account -->
        </div><!-- /#content -->
        <?php require_once 'php/footer.php';?>
    </div><!-- /#main -->
</body>
</html>