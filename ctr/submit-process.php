<?php
require_once 'php/autoload.php';
$redirect = 'submit.php';

// MAKE SURE THE PRODUCT SUBMISSION FORM WAS SUBMITTED
if(isset($_POST['validation']))
{
	// GET FORM INPUT FIELDS
    $product 	 = test_input($_POST['product']);
	$description = test_input($_POST['description']);
	$price 		 = test_input($_POST['price']);
	$platform 	 = test_input($_POST['platform']);
	$age 		 = test_input($_POST['age']);
	$dates 		 = test_input($_POST['dates']);
	$link 		 = test_input($_POST['link']);
	$codes 		 = test_input($_POST['codes']);
	$img1 		 = test_input($_POST['img1']);
	$img2 		 = test_input($_POST['img2']);
	$img3 		 = test_input($_POST['img3']);
	$company 	 = test_input($_POST['company']);
	$website 	 = test_input($_POST['website']);
	$address 	 = test_input($_POST['address']);
	$contact 	 = test_input($_POST['contact']);
	$email 		 = test_input($_POST['email']);
	$phone 		 = test_input($_POST['phone']);
	$fax 		 = test_input($_POST['fax']);
	$facebook 	 = test_input($_POST['facebook']);
	$twitter 	 = test_input($_POST['twitter']);
	$youtube 	 = test_input($_POST['youtube']);
	$info 		 = test_input($_POST['info']);
	
	// STORE THE SUBMISSION DETAILS IN THE SESSION
	$productSubmission = array();
    array_push($productSubmission, $product);
    array_push($productSubmission, $description);
    array_push($productSubmission, $price);
    array_push($productSubmission, $platform);
    array_push($productSubmission, $age);
    array_push($productSubmission, $dates);
    array_push($productSubmission, $link);
    array_push($productSubmission, $codes);
    array_push($productSubmission, $img1);
    array_push($productSubmission, $img2);
    array_push($productSubmission, $img3);
    array_push($productSubmission, $company);
    array_push($productSubmission, $website);
    array_push($productSubmission, $address);
    array_push($productSubmission, $contact);
    array_push($productSubmission, $email);
    array_push($productSubmission, $phone);
    array_push($productSubmission, $fax);
    array_push($productSubmission, $facebook);
    array_push($productSubmission, $twitter);
    array_push($productSubmission, $youtube);
    array_push($productSubmission, $info);
    $_SESSION['product-submission'] = $productSubmission;
	
	require_once 'php/captcha-check.php';
	
	// FORMAT AND SEND EMAIL TO CTR - $ip, $emailUs, $sender set in autoload.php
    $emailSubject = 'CTR Product Submission';
    $emailMessage = 'Product Name: '.$product."\r\n".
					'Description: '.$description."\r\n".
					'Price: '.$price."\r\n".
					'Platform: '.$platform."\r\n".
					'Age: '.$age."\r\n".
					'Key Dates: '.$dates."\r\n".
					'Link: '.$link."\r\n".
					'Codes: '.$codes."\r\n".
					"\r\n".
					'Image 1: '.$img1."\r\n".
					'Image 2: '.$img2."\r\n".
					'Image 3: '.$img3."\r\n".
					"\r\n".
					'Company Name: '.$company."\r\n".
					'Website: '.$website."\r\n".
					'Address: '.$address."\r\n".
					'Email: '.$email."\r\n".
					'Contact Name: '.$contact."\r\n".
					'Phone: '.$phone."\r\n".
					'Fax: '.$fax."\r\n".
					'Facebook: '.$facebook."\r\n".
					'Twitter: '.$twitter."\r\n".
					'YouTube: '.$youtube."\r\n".
					"\r\n".
					'Additional Information: '.$info."\r\n".
					"\r\n".
					'IP: '.$ip."\r\n";
    $emailHeaders = 'From: '.$sender.' ' . "\r\n" .
                    'Reply-To: '.$sender.' ' . "\r\n" .
                    'X-Mailer: PHP/' . phpversion();
	mail($emailUs, $emailSubject, $emailMessage, $emailHeaders);
	
	// FORMAT AND SEND EMAIL TO USER
    $emailTo 	  = $email;
    $emailSubject = 'Your Product Has Been Submitted to CTR for Review';
    $emailMessage = 'Your product, '.$product.', has been submitted to CTR for review. Details below:'."\r\n".
					"\r\n".
					'Product Name: '.$product."\r\n".
					'Description: '.$description."\r\n".
					'Price: '.$price."\r\n".
					'Platform: '.$platform."\r\n".
					'Age: '.$age."\r\n".
					'Key Dates: '.$dates."\r\n".
					'Link: '.$link."\r\n".
					'Codes: '.$codes."\r\n".
					"\r\n".
					'Image 1: '.$img1."\r\n".
					'Image 2: '.$img2."\r\n".
					'Image 3: '.$img3."\r\n".
					"\r\n".
					'Company Name: '.$company."\r\n".
					'Website: '.$website."\r\n".
					'Address: '.$address."\r\n".
					'Email: '.$email."\r\n".
					'Contact Name: '.$contact."\r\n".
					'Phone: '.$phone."\r\n".
					'Fax: '.$fax."\r\n".
					'Facebook: '.$facebook."\r\n".
					'Twitter: '.$twitter."\r\n".
					'YouTube: '.$youtube."\r\n".
					"\r\n".
					'Additional Information: '.$info."\r\n";
    $emailHeaders = 'From: '.$sender.' ' . "\r\n" .
                    'Reply-To: '.$sender.' ' . "\r\n" .
                    'X-Mailer: PHP/' . phpversion();
    mail($emailTo, $emailSubject, $emailMessage, $emailHeaders);

    // SET CONFIRMATION MESSAGE
    $_SESSION['confirmation']	= true;
    $_SESSION['confirmation-message'] = 'Your product has been submitted for review. A confirmation has been sent to '.$email;
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
<title>Submitting product information...</title>
</head>
<body>
</body>
</html>