<?php
// CONNECT TO SAMPLES DATABASE
$fmsamples = new FileMaker();
$fmsamples->setProperty('database', 'CSR');
$fmsamples->setProperty('username', $username);
$fmsamples->setProperty('password', $password);
$fmsamples->setProperty('hostspec', $hostspec);
$fmsamplesLayout = 'php-find-sample';
$layoutsamples = $fmsamples->getLayout($fmsamplesLayout);

// LOOKUP LATEST PUBLISHED CSR REVIEW WITH VIDEO AND RATING
$findSampleReview = $fmsamples->newFindCommand($fmsamplesLayout);
$findSampleReview->setRange(0,1);
$findSampleReview->addFindCriterion('published', "*");
$findSampleReview->addFindCriterion('video', "*");
$findSampleReview->addFindCriterion('rubricStars', ">0");
$findSampleReview->addSortRule('reviewnumber', 1, FILEMAKER_SORT_DESCEND);
$result = $findSampleReview->execute();
if (FileMaker::isError ($result) ) { echo $result->getMessage(); exit(); }
$record 			= $result->getFirstRecord();
$thumbdata			= $record->getField('thumbData');	
$thumbnail			= $record->getField('thumbnail');	
$samplesReviewsImg	= $record->getField('Sample Screen');	
$firstSampleTitle 	= $record->getField('Title');
$reviewnumber 		= $record->getField('reviewnumber');
$samplesReviewsLink = 'fullreview.php?id='.$reviewnumber;
$redirect 			= $samplesReviewsLink;

// CONNECT TO REVIEW DATABASE (parameters set in php/autoload.php)
$fmreviews = new FileMaker();
$fmreviews->setProperty('database', 'CSR');
$fmreviews->setProperty('username', $username);
$fmreviews->setProperty('password', $password);
$fmreviews->setProperty('hostspec', $hostspec);
$fmreviewsLayout = 'php-csr';
$layoutreviews = $fmreviews->getLayout($fmreviewsLayout);

// GET THREE LATEST REVIEWS
$findThree = $fmreviews->newFindCommand($fmreviewsLayout);
$findThree->setRange(0,3);
$findThree->addFindCriterion('published', "*");
$findThree->addSortRule('reviewnumber', 1, FILEMAKER_SORT_DESCEND);
$threeResult = $findThree->execute();
if (FileMaker::isError ($threeResult) ) { echo $threeResult->getMessage(); exit(); }
$threeRecords = $threeResult->getRecords();
$firstThree = array();
$threeN = -1;
foreach($threeRecords as $eachOfThree)
{
	$threeN += 1;
	$title 			= $eachOfThree->getField('Title');
	$reviewnumber 	= $eachOfThree->getField('reviewnumber');
	$link 			= 'review.php?id='.$reviewnumber;
	$firstThree[$threeN] = array($title, $link);
	
	// LATEST REVIEW LINK
	if($threeN == 0) { $latestReviewLink = 'review.php?id='.$reviewnumber; $latestReviewFullLink = 'fullreview.php?id='.$reviewnumber; } 
} // end foreach threeRecords

// CONNECT TO ISSUES DATABASE
$fmissues = new FileMaker();
$fmissues->setProperty('database', 'CSR');
$fmissues->setProperty('username', $username);
$fmissues->setProperty('password', $password);
$fmissues->setProperty('hostspec', $hostspec);
$fmissuesLayout = 'ISSUE DETAILS';
$layoutissues = $fmissues->getLayout($fmissuesLayout);

// LOOKUP LATEST ISSUE - ALL ACTIVE, SORT BY YEAR, MONTH, GET FIRST RECORD FOR LATEST ISSUE
$findIssue = $fmissues->newFindCommand('ISSUE DETAILS');
$findIssue->addFindCriterion('active', "*");
$findIssue->addSortRule('issueYearNumber', 1, FILEMAKER_SORT_DESCEND);
$findIssue->addSortRule('issueMonthNumber', 2, FILEMAKER_SORT_DESCEND);
$issueResult 	= $findIssue->execute();
if (FileMaker::isError ($issueResult) ) { echo $issueResult->getMessage(); exit(); }
$issueRecord 	= $issueResult->getFirstRecord(); 
$issuePDF 		= $issueRecord->getField('linkPDF');
$issueThumb 	= $issueRecord->getField('linkThumb');
$issueLgImg		= $issueRecord->getField('linkLarge');
$issueMonthName	= $issueRecord->getField('issueMonthName');
$issueYear		= $issueRecord->getField('issueYearNumber');
$issueContents	= $issueRecord->getField('toc');
$issueID		= $issueRecord->getField('monthly::archiveID');

// LATEST MONTHLY LINK
$issueArchiveURL		= 'issue.php?id='.$issueID;
$latestMonthlyLink 		= 'issue.php?id='.$issueID;
$latestMonthlyFullLink 	= 'fullissue.php?id='.$issueID;

if($issueLgImg != NULL) 
{ 
	$issuePreview 			= $issueLgImg; 
	$samplesMonthlyThumb 	= $issueLgImg;
	$samplesMonthlyImg		= $issueLgImg;
} 
else 
{ 
	$issuePreview 			= $issueThumb; 
	$samplesMonthlyThumb 	= $issueThumb;
	$samplesMonthlyImg		= $samplesMonthlyThumb;
}

$samplesMonthlyHeader 	= 'View the '.$issueMonthName.' Issue';
if($velvetRope != true) { $samplesMonthlyHeaderLink = $issuePDF; } 	else { $samplesMonthlyHeaderLink 	= $issuePreview; }

$samplesMonthlyImgType 	= 'URL';
if($velvetRope != true) { $samplesMonthlyThumbLink = $issuePDF; } 	else { $samplesMonthlyThumbLink 	= $issuePreview; }

if($issueID != NULL) { $samplesMonthlyHeaderLink = $issueArchiveURL; $samplesMonthlyThumbLink = $issueArchiveURL; }

// defaults
if($samplesReviewsHeaderLink == NULL)	{ $samplesReviewsHeaderLink = 'home.php'; }
if($samplesReviewsHeader == NULL)		{ $samplesReviewsHeader 	= 'Latest Reviews'; }
if($samplesMonthlyHeader == NULL)		{ $samplesMonthlyHeader 	= 'View the Monthly Issue'; }
if($samplesWeeklyHeader == NULL)		{ $samplesWeeklyHeader 		= 'Weekly News & Picks'; }

?>

<h1>Sample What You Get:</h1>

<div class = "center">
	
    <!-- REVIEWS -->
	<div id = "sample-review" class = "thirds">
    	<div class = "subheader">
			<?php if ($samplesReviewsHeaderLink != NULL) { echo '<a href = "'.$samplesReviewsHeaderLink.'" class = "btn-text-24px" title = "See our latest reviews">'; } ?>
			<?php echo $samplesReviewsHeader;?>
        	<?php if ($samplesReviewsHeaderLink != NULL) { echo '</a>'; } ?>
		</div><!-- /.subheader -->
        <div><?php echo $samplesReviewsSubheader;?></div>
    	<?php if($samplesReviewsImg != NULL)
		{
			if($samplesReviewsLink != NULL) { echo '<a href = "'.$samplesReviewsLink.'" title = "Read our review of '.$firstSampleTitle.'">'; }
				echo '<img src = "img.php?-url='.urlencode($samplesReviewsImg).'" />'; 
			if($samplesReviewsLink != NULL) { echo '</a>'; }
			echo '<br/><br/>'; 
		} 
		?>
        <div>
        <?php
		// DYNAMICALLY LIST THREE LATEST REVIEWS
		foreach($firstThree as $oneOfThree)
		{
			$title 	= $oneOfThree[0];
			$link 	= $oneOfThree[1];
			echo '<a href = "'.$link.'" title = "Read our review of '.$title.'">'.$title.'</a><br/>';
		}
		?>
        </div><!-- end sample-sublabel (reviews) -->
    </div><!-- end reviews-col -->
    
    <!-- MONTHLY -->
    <div id = "sample-issue" class = "thirds">
		<div class = "subheader">
			<?php if ($samplesMonthlyHeaderLink != NULL) { echo '<a href = "'.$samplesMonthlyHeaderLink.'">'; } ?>
			<?php echo $samplesMonthlyHeader;?>
			<?php if ($samplesMonthlyHeaderLink != NULL) { echo '</a>'; } ?>
		</div><!-- /.subheader -->
        <div><?php echo $samplesMonthlySubheader;?></div>
        <?php if($samplesMonthlyImg != NULL)
		{
			if($samplesMonthlyThumbLink != NULL) { echo '<a href = "'.$samplesMonthlyThumbLink.'">'; }
				echo '<img src = "'.$samplesMonthlyImg.'" title = "'.$samplesMonthlyHeader.'">';
			if($samplesMonthlyThumbLink != NULL) { echo '</a>'; }
			echo '<br/><br/>'; 
		} 
		?>
        <div><?php if($splashIssueContents != NULL) { echo nl2br($splashIssueContents); } ?></div><!-- end sample-sublabel (monthly) -->
    </div><!-- end monthly-col -->
    
    <!-- WEEKLY -->
    <div id = "sample-weekly" class = "thirds">
    	<div class = "subheader">
			<?php if ($latestWeeklyLink != NULL) { echo '<a href = "'.$latestWeeklyLink.'">'; } ?>
			<?php echo $samplesWeeklyHeader;?>
        	<?php if ($latestWeeklyLink != NULL) { echo '</a>'; } ?>
		</div><!-- /.subheader -->
        <div><?php echo $samplesWeeklySubheader;?></div>
        <?php 
		// IMAGE FROM FIRST CSR RECORD FOUND FOR MOST RECENT WEEKLY DATE
		if($samplesWeeklyImage != NULL)
		{
			echo '<div class = "width-70 inline center top-5">';
				echo '<a href = "'.$latestWeeklyLink.'" title = "Read the latest CTR Weekly Newsletter">';
					echo '<img src = "img.php?-url='.urlencode($samplesWeeklyImage).'">';
				echo '</a>';
			echo '</div>'; // .width-70 inline center top-5
		} // end if $samplesWeeklyImage
		?>
        <div>
        </div><!-- end sample-sublabel (weekly) -->
    </div><!-- end weekly-col -->
</div><!-- /.center -->