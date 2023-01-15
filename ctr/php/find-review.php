<?php
$reviewID 	= test_input($_GET['id']);
if($reviewID != NULL) 	
{ 
    // CONNECT TO REVIEW DATABASE (parameters set in php/autoload.php)
    $fmreviews = new FileMaker();
    $fmreviews->setProperty('database', 'CSR');
    $fmreviews->setProperty('username', $username);
    $fmreviews->setProperty('password', $password);
    $fmreviews->setProperty('hostspec', $hostspec);
    $fmreviewsLayout = 'php-csr';
    $layoutreviews = $fmreviews->getLayout($fmreviewsLayout);

    // LOOKUP REVIEW BY RECORD NUMBER
    // note: cannot use getRecordById method, as CSR::reviewnumber (field used for links) does not correspond to the actual recordID
    $findReview = $fmreviews->newFindCommand($fmreviewsLayout);
    $findReview->addFindCriterion('reviewnumber',"==".$reviewID);
    $result = $findReview->execute();
    if (FileMaker::isError ($result) ) { echo $result->getMessage(); exit(); }
    $record = $result->getFirstRecord();

    // GET FIELD DATA
    $published 	= $record->getField('published');
    $title      = $record->getField('Title');
    $reviewID	= $record->getField('reviewnumber');

    // PUBLISHER
    $copyright  = $record->getField('Copyright Date');
    $company    = $record->getField('Company');
    $companyID  = $record->getField('Producers::Company Name');
    if($publisher == true and ($company == $publisherName or $companyID == $publisherID)) { $publisherAccess = true; }
    $website    = $record->getField('websiteParsed');

    // PRODUCT INFO
    $price      = $record->getField('Price');
    $platform   = $record->getField('platform text');
    $ages       = $record->getField('Age Range');
    $subject    = $record->getField('teaches text');

    // RATING
    $rating     = $record->getField('standardScore');
    $edChoice   = $record->getField('edChoice');
    $ethical    = $record->getField('ethical');
    $rating1    = $record->getField('rating1');
    $rating2    = $record->getField('rating2');
    $rating3    = $record->getField('rating3');
    $rating4    = $record->getField('rating4');
    $rating5    = $record->getField('rating5');

    // IMAGES
    $imgCount   = $record->getField('imgCount');
    $img1       = $record->getField('Sample Screen');
    $img2       = $record->getField('sample screen2');
    $img3       = $record->getField('Image3');

    // VIDEO
    $video      = $record->getField('video');
    if($video != NULL)
    {
        $videoLink 		= videoLink($video);
        $vidURL 		= $videoLink[0];
        $video 			= $videoLink[1];
    }

    // CTR REVIEW
    $dateEntered= $record->getField('Date of Review');
    $reviewText = $record->getField('Web Site Comments Field');
    $commentCount=$record->getField('commentCount');

    // DOWNLOAD LINKS
    $downloadLinks  = array();
    $numDownloadLinks = 0;
    $linkItunes     = $record->getField('itunes code');
    $linkAndroid    = $record->getField('Android code');
    $linkAmazon     = $record->getField('amazon');
    $linkSteam      = $record->getField('steam code');
    if($linkItunes != NULL)  { array_push($downloadLinks, array('itunes', $linkItunes));    $numDownloadLinks += 1; }
    if($linkAndroid != NULL) { array_push($downloadLinks, array('android', $linkAndroid));  $numDownloadLinks += 1; }
    if($linkAmazon != NULL)  { array_push($downloadLinks, array('amazon', $linkAmazon));    $numDownloadLinks += 1; }
    if($linkSteam != NULL)   { array_push($downloadLinks, array('steam', $linkSteam));      $numDownloadLinks += 1; }

} else { require_once 'redirect.php'; exit(); } // redirect home if review ID not specified
?>