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

// GET RECORD DATA
$publisherPassword  = $record->getField('password');
$website            = $record->getField('Web site');
$websiteParsed      = $record->getField('websiteParsed');
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
$dateEntered		= $record->getField('date created');
$numTitlesReviewed	= $record->getField('publishedCount');
$numTitlesSubmitted = $record->getField('titleCount');
?>
<!doctype html>
<html>
<head>
    <?php require_once 'php/head.php';?>
    <title><?php echo $publisherName.'\'s CTR Account';?></title>
</head>

<body>
    <div id = "main">
        <?php require_once 'php/header.php';?>
        <div id = "content">
            <div class = "center" id = "account">
                <h1><?php echo $publisherName;?>'s CTR Account</h1>
            
                <div class = "paragraph">
                    <p>
                        This information (aside from your company website, which appears with any reviews of your products) is only used for managing your preferences associated with your CTR publisher account. To update your information, modify the corresponding fields and select "Update Account Information" at the bottom of this page.
                    </p>
                    
                    <!-- FORM START -->
                    <form name = "account-update-form" method = "POST" action = "publisher-update.php">
                        
                        <!-- ACCOUNT INFO -->
                        <div class = "form-row-static">
                            <div class = "form-label-static">Username:</div>
                            <div class = "form-field-static"><?php echo $publisherUsername;?></div>
                        </div><!-- /.form-row -->
                        <div class = "form-row">
                            <div class = "form-label">Password:</div>
                            <div class = "form-field"><input type = "text" name = "password" value = "<?php echo $publisherPassword;?>"/></div>
                        </div><!-- /.form-row -->
						<div class = "form-row">
                            <div class = "form-label"><a href = "http://<?php echo $websiteParsed;?>" target = "_blank">Website</a>:</div>
                            <div class = "form-field"><input type = "text" name = "website" value = "<?php echo $website;?>"/></div>
                        </div><!-- /.form-row -->
                        
                        <!-- CONTACT INFO -->
						<div class = "form-row">
                            <div class = "form-label">Contact Email:</div>
                            <div class = "form-field"><input type = "text" name = "email" value = "<?php echo $email;?>"/></div>
                        </div><!-- /.form-row -->
                        <div class = "form-row">
                            <div class = "form-label">Contact First Name:</div>
                            <div class = "form-field"><input type = "text" name = "fname" value = "<?php echo $fname;?>"/></div>
                        </div><!-- /.form-row -->
                        <div class = "form-row">
                            <div class = "form-label">Contact Last Name:</div>
                            <div class = "form-field"><input type = "text" name = "lname" value = "<?php echo $lname;?>"/></div>
                        </div><!-- /.form-row -->
                        <div class = "form-row">
                            <div class = "form-label">Contact Title:</div>
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
					<h3 class = "center"><a href = "submit.php" title = "Submit a product for review using our online form">Submit a product for review</a></h3>
                    <?php
					if($numTitlesReviewed > 0)
                    { 
                        echo '<h3 class = "center"><a href = "home.php?company='.$publisherName.'">See all CTR reviews of your products</a></h3>';
                    }
					if($numTitlesSubmitted > 0)
                    {
						echo '<br/><br/>';
						echo '<h2 class = "center">Your Submitted Products:</h2>';
						
                        $products = $record->getRelatedSet('CSR');
						echo '<table class = "publisher-titles">';
							echo '<tr class = "tr-heading">';
								echo '<td>Date</td>';
								echo '<td>Title</td>';
								echo '<td>Status</td>';
							echo '</tr>';
							foreach($products as $product)
							{
								$dateReviewed = $product->getField('CSR::Date of Review');
								$title 		 = $product->getField('CSR::Title');
								$reviewID 	 = $product->getField('CSR::reviewnumber');
								$reviewURL   = 'review.php?id='.$reviewID;
								$published   = $product->getField('CSR::published');
								if($published != NULL) { $trClass = 'tr-published'; } else { $trClass = 'tr-unpublished'; }
								echo '<tr class = "'.$trClass.'">';
									echo '<td>'.$dateReviewed.'</td>';
									echo '<td>';
										if($published != NULL) { echo '<a href = "'.$reviewURL.'" title = "View the CTR review for '.$title.'">'; }
										echo $title;
										if($published != NULL) { echo '</a>'; }
									echo '</td>';
									echo '<td>';
										if($published != NULL) { echo 'Published'; } else { echo 'Unpublished'; }
									echo '</td>';
								echo '</tr>';
							} // end foreach $product
						echo '</table>';
                    } // end if $numTitlesSubmitted > 0
					?>
                </div><!-- /.paragraph -->
            </div><!-- /.center /#account -->
        </div><!-- /#content -->
        <?php require_once 'php/footer.php';?>
    </div><!-- /#main -->
</body>
</html>