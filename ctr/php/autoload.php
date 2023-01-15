<?php
// START SESSION
session_name("CTR_WIP");
session_start();
header('Cache-Control: max-age=28800'); // defines timeout for cache storage

// DETERMINE URL
$ip 		= $_SERVER['REMOTE_ADDR'];
$server 	= $_SERVER['PHP_SELF'];
$directory 	= str_replace('/', '', dirname($server));
$thisPage 	= basename($server); 		// this variable is referenced frequently for context-specific conditions
$thisQuery	= $_SERVER['QUERY_STRING'];	// this variable contains the parameters or form input values of the page url
if($thisQuery != NULL) { $thisURL = $thisPage.'?'.$thisQuery; } else { $thisURL = $thisPage; } // concatenation to define the entire url

// SET EMAIL ADDRESSES
$sender  = 'matt@childrenstech.com'; // specify email account with which to use mail() function
$emailUs = 'info@childrenstech.com'; // specify which CTR email account to send notifications to

// CONFIGURE DATE
date_default_timezone_set('America/New_York');
$time 	= date('g').":".date('i A');
$hour 	= date('g');
$minute = date('i');
$second = date('s');
$ampm 	= date('A');
$hour24	= date('G');
$date 		= date('F j').', '.date('Y');
$dateConv 	= date('n').'/'.date('j').'/'.date('Y');
$dateConvTime= strtotime($dateConv);
$year 		= date('Y'); // used in 'footer.php' to display copyright dynamically
$month		= date('n');
$monthName 	= date('F');
$day		= date('j');
$time = $hour.':'.$minute.':'.$second.' '.$ampm;
$timestamp = $dateConv.' '.$hour.':'.$minute.':'.$second.' '.$ampm;

// defines a date in the recent past to use as a cutoff for filtering review searches by the 'current' parameter
$pastyear 	= $year - 1;
$cutoffYear	= $year - 5;
$oneyearago	= $month.'/'.$day.'/'.$pastyear;
$currentSet	= $month.'/'.$day.'/'.$cutoffYear;

// SPECIFY DATABASE CONNECTION PARAMETERS
$username = 'webctr';
$password = 'webctrpassword';
$hostspec = 'http://fms5312.triple8.net';

require_once 'FileMaker.php';
require_once 'php/functions.php';

// GET SESSION VARIABLES
$login       = $_SESSION['login'];
$subscriber  = $_SESSION['subscriber'];
$temp		 = $_SESSION['temp'];
$publisher   = $_SESSION['publisher'];
$license     = $_SESSION['license'];

if($subscriber != NULL or $temp != NULL)
{
    $subscriberID       = $_SESSION['subscriberID'];
    $subscriberUsername = $_SESSION['subscriberUsername'];
    $substatus          = $_SESSION['substatus'];
    $expDate            = $_SESSION['expDate'];
}

if($publisher != NULL)
{
    $publisherID        = $_SESSION['publisherID'];
    $publisherUsername  = $_SESSION['publisherUsername'];
    $publisherName  	= $_SESSION['publisherName'];
}

if($license != NULL)
{
    $licenseName = $_SESSION['licenseName'];
    if($licenseName == NULL) { $licenseName = 'Site License'; }
}

// LAST SEARCH URL
$reviewSearchURL    = $_SESSION['reviewSearchURL'];
$archiveSearchURL   = $_SESSION['archiveSearchURL'];

// FREE MODE
if($subscriber != true and $temp != true and $license != true and $thisPage != 'login.php' and $thisPage != 'logout.php')
{
    $fmdashboard = new FileMaker();
    $fmdashboard->setProperty('database', 'CSR');
    $fmdashboard->setProperty('username', $username);
    $fmdashboard->setProperty('password', $password);
    $fmdashboard->setProperty('hostspec', $hostspec);
    $fmdashboardLayout = 'dashboard-master';
    $layoutdashboard   = $fmdashboard->getLayout($fmdashboardLayout);
    $findDashboard     = $fmdashboard->newFindCommand($fmdashboardLayout);
    $findDashboard->addFindCriterion('recordnumber',"==".'1');
    $dashboardResult = $findDashboard->execute();
    if (FileMaker::isError ($dashboardResult) ) { echo 'Error retrieving website settings: '.$dashboardResult->getMessage(); exit(); }
    $dashboardRecord = $dashboardResult->getFirstRecord();
	$freeModeStatus  = $dashboardRecord->getField('freeMode');
	if($freeModeStatus != NULL)
	{
		$freeMode = true;
		$_SESSION['freeMode'] = $freeMode;
	} // end if $freeModeStatus
} // end if !$login
?>