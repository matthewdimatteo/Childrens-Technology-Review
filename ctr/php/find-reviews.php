<?php

// GET FIELD INPUTS
$searchReviewsNumParams = 0;
$searchReviewsParams    = array();
$searchReviewsSort		= test_input($_GET['sort']);

$searchReviewsKeyword 	= test_input($_GET['keyword']);
if($searchReviewsKeyword != NULL)   { $searchReviewsNumParams += 1; array_push($searchReviewsParams, $searchReviewsKeyword); }

$searchReviewsAge		= test_input($_GET['age']);         
if($searchReviewsAge != NULL)       { $searchReviewsNumParams += 1; array_push($searchReviewsParams, $searchReviewsAge); }
                                     
$searchReviewsSubject	= test_input($_GET['subject']);     
if($searchReviewsSubject != NULL)   { $searchReviewsNumParams += 1; array_push($searchReviewsParams, $searchReviewsSubject); }
                                     
$searchReviewsPlatform	= test_input($_GET['platform']);    
if($searchReviewsPlatform != NULL)  { $searchReviewsNumParams += 1; array_push($searchReviewsParams, $searchReviewsPlatform); }
                                     
$searchReviewsTopic		= test_input($_GET['category']);    
if($searchReviewsTopic != NULL)     { $searchReviewsNumParams += 1; array_push($searchReviewsParams, $searchReviewsTopic); }
                                     
$searchReviewsCompany	= test_input($_GET['company']);
if($searchReviewsCompany != NULL)   { $searchReviewsNumParams += 1; array_push($searchReviewsParams, $searchReviewsCompany); }
                                     
$searchReviewsList	    = test_input($_GET['list']);      
if($searchReviewsList != NULL)      { $searchReviewsNumParams += 1; array_push($searchReviewsParams, $searchReviewsList); }

$searchReviewsMonthly	= test_input($_GET['monthly']);     
if($searchReviewsMonthly != NULL)   { $searchReviewsNumParams += 1; array_push($searchReviewsParams, $searchReviewsMonthly); }

$searchReviewsWeekly	= test_input($_GET['weekly']);      
if($searchReviewsWeekly != NULL)    { $searchReviewsNumParams += 1; array_push($searchReviewsParams, $searchReviewsWeekly); }

$searchReviewsAward		= test_input($_GET['award']);       
if($searchReviewsAward != NULL)     { $searchReviewsNumParams += 1; array_push($searchReviewsParams, $searchReviewsAward); }

$searchReviewsYear		= test_input($_GET['year']);        
if($searchReviewsYear != NULL)      { $searchReviewsNumParams += 1; array_push($searchReviewsParams, $searchReviewsYear); }

$searchReviewsLatest    = test_input($_GET['latest']);      
if($searchReviewsLatest != NULL)    { $searchReviewsNumParams += 1; array_push($searchReviewsParams, $searchReviewsLatest); }

$searchReviewsEdChoice  = test_input($_GET['edchoice']);    
if($searchReviewsEdChoice != NULL)  { $searchReviewsNumParams += 1; array_push($searchReviewsParams, $searchReviewsEdChoice); }

$searchReviewsEthical  = test_input($_GET['ethical']);    
if($searchReviewsEthical != NULL)   { $searchReviewsNumParams += 1; array_push($searchReviewsParams, $searchReviewsEthical); }

$searchReviewsWayBack   = test_input($_GET['wayback']);    
if($searchReviewsWayBack != NULL)   { $searchReviewsNumParams += 1; array_push($searchReviewsParams, $searchReviewsWayBack); }

$searchReviewsPage		= test_input($_GET['page']);

// HANDLE SORT RULES
if ($searchReviewsSort == NULL) { $searchReviewsSort = 'new'; } // make new the default
switch($searchReviewsSort)
{
	case 'new'	:	$sortField = 'reviewnumber'; 	$sortLabel = 'by newest';			     $sortOrder = FILEMAKER_SORT_DESCEND;
					break;
    case 'old'  :   $sortField = 'reviewnumber'; 	$sortLabel = 'by oldest';                $sortOrder = FILEMAKER_SORT_ASCEND;
                    break;
	case 'best' :	$sortField = 'standardScore';	$sortLabel = 'by best rating';	         $sortOrder = FILEMAKER_SORT_DESCEND; 
					break;
	case 'abc'  :	$sortField = 'Title';			$sortLabel = 'alphabetically'; 	         $sortOrder = FILEMAKER_SORT_ASCEND; 		
					break;
    case 'zyx'  :	$sortField = 'Title';			$sortLabel = 'reverse alphabetically'; 	 $sortOrder = FILEMAKER_SORT_DESCEND; 		
					break;
	default		:	$sortField = 'reviewnumber'; 	$sortLabel = 'newest';			         $sortOrder = FILEMAKER_SORT_DESCEND; 
					break;
}

// HANDLE AGE FIELD
switch($searchReviewsAge)
{
	case 'B' 	: $searchReviewsAgeLabel = 'Baby';				$searchReviewsAgeField = 'Grade Level';	break;
	case 'T' 	: $searchReviewsAgeLabel = 'Toddler';			$searchReviewsAgeField = 'Grade Level';	break;
	case 'P' 	: $searchReviewsAgeLabel = 'Preschool'; 		$searchReviewsAgeField = 'Grade Level';	break;
	case 'K' 	: $searchReviewsAgeLabel = 'Kindergarten'; 		$searchReviewsAgeField = 'Grade Level';	break;
	case 'E' 	: $searchReviewsAgeLabel = 'Early Elementary'; 	$searchReviewsAgeField = 'ageCodes';	break;
	case 'U' 	: $searchReviewsAgeLabel = 'Upper Elementary'; 	$searchReviewsAgeField = 'ageCodes';	break;
	case 'M' 	: $searchReviewsAgeLabel = 'Middle/High School'; $searchReviewsAgeField = 'ageCodes';	break;
	case '1'	: $searchReviewsAgeLabel = "1st Grade";			$searchReviewsAgeField = 'Grade Level';	break;
	case '2'	: $searchReviewsAgeLabel = "2nd Grade";			$searchReviewsAgeField = 'Grade Level';	break;
	case '3'	: $searchReviewsAgeLabel = "3rd Grade";			$searchReviewsAgeField = 'Grade Level';	break;
	case '4'	: $searchReviewsAgeLabel = "4th Grade";			$searchReviewsAgeField = 'Grade Level';	break;
	case '5'	: $searchReviewsAgeLabel = "5th Grade";			$searchReviewsAgeField = 'Grade Level';	break;
	case '6'	: $searchReviewsAgeLabel = "6th Grade";			$searchReviewsAgeField = 'Grade Level';	break;
	case '7'	: $searchReviewsAgeLabel = "7th Grade";			$searchReviewsAgeField = 'Grade Level';	break;
	case '8'	: $searchReviewsAgeLabel = "8th Grade";			$searchReviewsAgeField = 'Grade Level';	break;
	case '9'	: $searchReviewsAgeLabel = "9th Grade";			$searchReviewsAgeField = 'Grade Level';	break;
	case 'S'	: $searchReviewsAgeLabel = "Sophomore";			$searchReviewsAgeField = 'Grade Level';	break;
	case 'Jr'	: $searchReviewsAgeLabel = "Junior";			$searchReviewsAgeField = 'Grade Level';	break;
	case 'Sr'	: $searchReviewsAgeLabel = "Senior";			$searchReviewsAgeField = 'Grade Level';	break;
	default	 	: $searchReviewsAgeLabel = $searchReviewsAge;	$searchReviewsAgeField = 'Grade Level';	break;
} // end switch

// HANDLE TOPIC LABELS
switch($searchReviewsTopic)
{
	case 'AllTimeBestApps'		: $searchReviewsTopicLabel = 'All Time Best';		
                                  $topicLabel = true; $sortField = 'standardScore';	$sortLabel = 'by best rating'; $sortOrder = FILEMAKER_SORT_DESCEND; break;
	case 'BestAndroid'			: $searchReviewsTopicLabel = 'Android';				$topicLabel = true; break;
	case 'Pioneer'				: $searchReviewsTopicLabel = 'Classics'; 			$topicLabel = true; break;
	case 'isFiction'			: $searchReviewsTopicLabel = 'Fiction'; 			$topicLabel = true; break;
	case 'Library Video Games'	: $searchReviewsTopicLabel = 'Library Videogames'; 	$topicLabel = true; break;
	case 'coop'					: $searchReviewsTopicLabel = 'Co-op';				$topicLabel = true; break;	
	default 					: $searchReviewsTopicLabel = $searchReviewsTopic;	$topicLabel = false; break;
} // end switch

// HANDLE AWARD FIELD
if($searchReviewsAward != NULL)
{
	if($searchReviewsAward == 'brda' or $searchReviewsAward == 'brdp' or $searchReviewsAward == 'bologna' or $searchReviewsAward == 'bolognaragazzi')
	{
		$searchReviewsAwardField = 'bolognaYear';
		$searchReviewsAwardLabel = 'BolognaRagazzi Digital Award '.$searchReviewsYear;
	} // end if $searchReviewsAward == 'brda'
	else if($searchReviewsAward == 'kapi' or $searchReviewsAward == 'kapis')
	{
		$searchReviewsAwardField = 'kapiYear';
		$searchReviewsAwardLabel = 'KAPi Awards '.$searchReviewsYear;
	} // end if $searchReviewsAward == 'kapi'
} // end if $searchReviewsaward

// HANDLE PAGE
if ( $searchReviewsPage < 1 ) { $searchReviewsPage = 1; }
if($searchReviewsPage > 1 and $subscriber != true and $temp != true and $license != true and $freeMode != true and $searchReviewsCompany != $publisherName)
{
	$searchReviewsPage = 1;
}

// CONNECT TO REVIEW DATABASE (parameters set in php/autoload.php)
$fmreviews = new FileMaker();
$fmreviews->setProperty('database', 'CSR');
$fmreviews->setProperty('username', $username);
$fmreviews->setProperty('password', $password);
$fmreviews->setProperty('hostspec', $hostspec);
$fmreviewsLayout = 'php-csr';
$layoutreviews = $fmreviews->getLayout($fmreviewsLayout);

// FIND REVIEWS
$findReviews = $fmreviews->newFindCommand($fmreviewsLayout);

// PAGINATION
$resultSize = 10;
$skip = ($searchReviewsPage - 1) * $resultSize;
$findReviews->setRange($skip, $resultSize);

// SET FIND CRITERIA
$findReviews->addFindCriterion('published',"*");

// KEYWORD
if($searchReviewsKeyword != NULL) { $findReviews->addFindCriterion('deepsearch',"=*$searchReviewsKeyword*"); }

// POWERSEARCH
if($searchReviewsAge != NULL) 		{ $findReviews->addFindCriterion($searchReviewsAgeField, "=*$searchReviewsAge*"); 	  }
if($searchReviewsSubject != NULL) 	{ $findReviews->addFindCriterion('teaches text', "=*$searchReviewsSubject*"); 		  }
if($searchReviewsPlatform != NULL) 	{ $findReviews->addFindCriterion('platform text', "=*$searchReviewsPlatform*"); 	  }
if($searchReviewsTopic != NULL)		{ $findReviews->addFindCriterion('recommendations' , "=*$searchReviewsTopic*"); 	  }

// HIDDEN
if($searchReviewsList != NULL)	    { $findReviews->addFindCriterion('list' , "==".$searchReviewsList); 			      }
if($searchReviewsCompany != NULL)	{ $findReviews->addFindCriterion('Company' , "=*$searchReviewsCompany*"); 		  	  }
if($searchReviewsMonthly != NULL)	{ $findReviews->addFindCriterion('issueAbbr' , "==".$searchReviewsMonthly); 		  }
if($searchReviewsWeekly != NULL)	{ $findReviews->addFindCriterion('weekly' , "==".$searchReviewsWeekly); 			  }
if($searchReviewsAward != NULL)		{ $findReviews->addFindCriterion($searchReviewsAwardField , "=*$searchReviewsYear*"); }
if($searchReviewsEdChoice != NULL)  { $findReviews->addFindCriterion('whereisit', "=Editor\'s Choice");                   }
if($searchReviewsEthical != NULL)   { $findReviews->addFindCriterion('ethical', "=Ethical");                              }
if($searchReviewsAward != NULL)		{ $findReviews->addFindCriterion($searchReviewsAwardField , "=*$searchReviewsYear*"); }

// IF NO PARAMS, CONSTRAIN FOUNDSET TO RECENT REVIEWS TO IMPROVE PERFORMANCE ($currentSet calculated in php/autoload.php)
if(($searchReviewsNumParams < 1 or $searchReviewsLatest == true) and $searchReviewsSort != 'old' and $searchReviewsWayBack != true)
{ 
    //$findReviews->addFindCriterion('Date of Review', ">$currentSet");
    $findReviews->addFindCriterion('reviewnumber', ">19500");
}
//if($searchReviewsSort == 'old' and $searchReviewsWayBack != true){ $findReviews->addFindCriterion('Date of Review', "<1/1/1996"); }
if($searchReviewsSort == 'old' and $searchReviewsWayBack != true){ $findReviews->addFindCriterion('reviewnumber', "<1000"); }

// IF SORTING BY BEST, RETURN ONLY PRODUCTS WITH RATINGS
if($searchReviewsSort == 'best') 	{ $findReviews->addFindCriterion('standardStars', ">0"); }

// SORT RULES
if 		($sortField == 'reviewnumber') 			
{
    $findReviews->addSortRule('Copyright Date', 1, $sortOrder);
    $findReviews->addSortRule('reviewnumber', 2, $sortOrder);
}

else if	($sortField == 'standardScore') 
{
    $findReviews->addSortRule('standardScore', 1, $sortOrder);
    $findReviews->addSortRule('Copyright Date', 2, FILEMAKER_SORT_DESCEND);
    $findReviews->addSortRule('reviewnumber', 3, FILEMAKER_SORT_DESCEND);
}

else if ($sortField == 'Title')
{
    $findReviews->addSortRule('Title', 1, $sortOrder);
    $findReviews->addSortRule('Copyright Date', 2, FILEMAKER_SORT_DESCEND);
    $findReviews->addSortRule('reviewnumber', 3, FILEMAKER_SORT_DESCEND);
}

// DEFAULT: SORT BY MOST RECENT
else
{
    $findReviews->addSortRule('Copyright Date', 1, FILEMAKER_SORT_DESCEND);
    $findReviews->addSortRule('reviewnumber', 2, FILEMAKER_SORT_DESCEND);
}

// EXECUTE FIND
$result = $findReviews->execute();

// ERROR HANDLING - RELOAD PREVIOUS SEARCH AND DISPLAY ERROR MESSAGE
if(FileMaker::isError($result))
{ 
    $redirect = $reviewSearchURL;
    $pageTitle= 'No results found';
    $_SESSION['error'] 			= true;
    $_SESSION['error-message'] 	= 'No results were found for the search terms entered. Displaying previous search results.';
    require_once 'redirect.php'; exit();
    //echo $result->getMessage(); exit(); 
}

// PROCESS RESULTS
$records = $result->getRecords(); // store the found records in the $records object

// ANALYTICS
$rangeStart = 1 + (($searchReviewsPage - 1) * $resultSize);
$rangeEnd = $resultSize + (($searchReviewsPage - 1) * $resultSize);
$foundcount = $result->getFoundSetCount();
$fetchcount = $result->getFetchCount();
$numPages = ceil($foundcount/$resultSize);
if ( $rangeEnd > $foundcount ) { $rangeEnd = $foundcount; }

// SUMMARY
$resultsSummary = $foundcount;
//if($searchReviewsNumParams < 1 or $searchReviewsLatest != NULL) { $resultsSummary .= ' latest'; }
//if($searchReviewsEdChoice != NULL)  { $resultsSummary .= ' editor\'s choice'; }
$resultsSummary .= ' review';
if($foundcount > 1) { $resultsSummary .= 's'; }
//if($searchReviewsKeyword != NULL)   { $resultsSummary .= ' for '.$searchReviewsKeyword; }
$resultsSummary .= ' sorted '.$sortLabel;

$_SESSION['reviewSearchURL'] = $thisURL;
?>