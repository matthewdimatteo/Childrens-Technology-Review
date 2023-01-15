<?php
require_once 'php/autoload.php';
if($subscriber != true and $temp != true and $license != true and $freeMode != true and $publisher != true)
{
	require 'redirect.php'; exit();
} // end velvet rope redirect

if(isset($_GET['validation']))
{
	$scope  = test_input($_GET['scope']);
	$format = test_input($_GET['format']);
	if($scope == NULL) { $scope  = 'search'; }
	if($format == NULL){ $format = 'csv'; }
	
	// EXPORT LIST OF SEARCH RESULTS
	if($scope == 'search')
	{
		require_once 'php/find-reviews.php';
		$n = 0;
		$export = array();
		array_push($export, array('', 'Title', 'Link', 'Copyright', 'Publisher', 'Platform', 'Age Range', 'Subject', 'CTR Rating', '', ''));
		foreach($records as $record)
		{
			$n += 1;
            $reviewID   = $record->getField('reviewnumber');
            $reviewURL  = 'http://reviews.childrenstech.com/ctr/review.php?id='.$reviewID;
            $title      = $record->getField('Title');

            $copyright  = $record->getField('Copyright Date');
            $company    = $record->getField('Company');
            $companyID  = $record->getField('Producers::Company Name');
            $website    = $record->getField('websiteParsed');

            $platform   = $record->getField('platform text');
            $ages       = $record->getField('Age Range');
            $subject    = $record->getField('teaches text');

            $rating     = $record->getField('standardScore');
            $edChoice   = $record->getField('edChoice');
            $ethical    = $record->getField('ethical');
			
			if($rating != NULL and $rating != '?') { $rating .= '%'; }
			if($edChoice != NULL) { $edChoice = 'Editor\'s Choice'; }
			if($ethical != NULL)  { $ethical = 'Ethical'; }
			
			$thisRecord = array($n, $title, $reviewURL, $copyright, $company, $platform, $ages, $subject, $rating, $edChoice, $ethical);
			array_push($export, $thisRecord);
		} // end foreach
		$exportFilename = 'ctr-search-results';
	} // end if $scope == 'search'
	
	// EXPORT SINGLE REVIEW IN MARC FORMAT
	if($scope == 'marc')
	{
		require_once 'php/find-review.php';
		$reviewURL  = 'http://reviews.childrenstech.com/ctr/review.php?id='.$reviewID;
		if($rating != NULL and $rating != '?') { $rating .= '%'; }
		if($rating1 != NULL and $rating1 != 'N') { $rating1 .= '/10'; }
		if($rating2 != NULL and $rating2 != 'N') { $rating2 .= '/10'; }
		if($rating3 != NULL and $rating3 != 'N') { $rating3 .= '/10'; }
		if($rating4 != NULL and $rating4 != 'N') { $rating4 .= '/10'; }
		if($rating5 != NULL and $rating5 != 'N') { $rating5 .= '/10'; }
        if($edChoice != NULL) { $edChoice = 'Editor\'s Choice'; }
        if($ethical != NULL)  { $ethical = 'Ethical'; }
		$export = array();
		//array_push($export, array('', 'Title', 'Link', 'Copyright', 'Publisher', 'Price', 'Platform', 'Age Range', 'Subject', 'Date', 'Review', 'CTR Rating', 'Ease of Use', 'Educational', 'Entertaining', 'Design Features', 'Value', '', ''));
		if($title != NULL) 		{ array_push($export, array('Title', $title)); }
		if($reviewURL != NULL)  { array_push($export, array('Link', $reviewURL)); }
		if($copyright != NULL)  { array_push($export, array('Copyright', strval($copyright))); }
		if($company != NULL) 	{ array_push($export, array('Publisher', $company)); }
		if($price != NULL) 		{ array_push($export, array('Price', strval($price))); }
		if($platform != NULL)   { array_push($export, array('Platform', $platform)); }
		if($ages != NULL) 		{ array_push($export, array('Age Range', $ages)); }
		if($subject != NULL)    { array_push($export, array('Subject', $subject)); }
		if($dateReviewed != NULL){array_push($export, array('Date of Review', $dateReviewed)); }
		if($reviewText != NULL) { array_push($export, array('CTR Review', $reviewText)); }
		if($rating != NULL and $rating != '?') { array_push($export, array('CTR Rating', strval($rating))); }
		if($rating1 != NULL) 	{ array_push($export, array('Ease of Use', $rating1)); }
		if($rating2 != NULL) 	{ array_push($export, array('Educational', $rating2)); }
		if($rating3 != NULL) 	{ array_push($export, array('Entertaining', $rating3)); }
		if($rating4 != NULL) 	{ array_push($export, array('Design Features', $rating4)); }
		if($rating5 != NULL) 	{ array_push($export, array('Value', $rating5)); }
		$exportFilename = 'ctr-review-'.$reviewID;
	} // end if $scope == 'marc'
	
} // end if isset validation
else { require 'redirect.php'; exit(); }

// EXPORT THE FILE
ob_clean();
header("Content-type: text/x-".$format);
header("Content-Transfer-Encoding: binary");
header("Content-Disposition: attachment; filename=".$exportFilename."-".date("Y-m-d").".".$format); // add the current date and the file extension
header("Pragma: no-cache");
header("Expires: 0");
$file = fopen('php://temp/maxmemory:'. (12*1024*1024), 'r+'); // 128MB
fputcsv($file, array_keys(call_user_func_array('array_merge', $array)));
foreach($export as $row) { fputcsv($file, $row); }
rewind($file);
$output = stream_get_contents($file);
fclose($file);
echo $output;
die();

?>