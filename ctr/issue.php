<?php
require_once 'php/autoload.php';
$redirect = $archiveSearchURL;
if(isset($_GET['id']))
{
	$archiveID 	= test_input($_GET['id']);
	if($archiveID != NULL) 	
	{
		// CONNECT TO ISSUES DATABASE
        $fmmonthly = new FileMaker();
        $fmmonthly->setProperty('database', 'subbies');
        $fmmonthly->setProperty('username', $username);
        $fmmonthly->setProperty('password', $password);
        $fmmonthly->setProperty('hostspec', $hostspec);
        $fmmonthlyLayout = 'archive-monthly';
        $layoutmonthly = $fmmonthly->getLayout($fmmonthlyLayout);
		
		// LOOKUP ISSUE BY RECORD NUMBER
		$findMonthly = $fmmonthly->newFindCommand($fmmonthlyLayout);
		$findMonthly->addFindCriterion('archiveID',"==".$archiveID);
		$result = $findMonthly->execute();
		if (FileMaker::isError ($result) ) { echo 'Error loading issue: '.$result->getMessage(); exit(); }
		$record = $result->getFirstRecord();
		
		// CHECK THAT ISSUE IS ACTIVE
		$active = $record->getField('issues::active');
		if($active != NULL) { $active = true; } else { $active = false; }
		if($active != true) { require_once 'redirect.php'; } // return to archive if issue not marked active
		
		// GET RECORD DATA
		$archiveDate    = $record->getField('issueDateText');
        $abbr		    = $record->getField('issueDateAbbr');
        $subject        = $record->getField('subjectNotes');
        $volume         = $record->getField('volume');
        $number         = $record->getField('number');
        $issue          = $record->getField('issueNumber');
        $intro          = $record->getField('intro');
        $conclusion     = $record->getField('conclusion');
        $linkPDF        = $record->getField('issues::linkPDF');
        $linkThumb      = $record->getField('issues::linkThumb');
        $linkLarge      = $record->getField('issues::linkLarge');
		$pdf 			= $record->getField('issues::pdf');
		$cover 			= $record->getField('issues::cover');
        $numTitles      = $record->getField('numTitles');
		
    } else { require_once 'redirect.php'; exit(); } // redirect back to archive if archiveID not specified
} else { require_once 'redirect.php'; exit(); } // redirect back to archive if form not set

?>
<!doctype html>
<html>
<head>
<?php require_once 'php/head.php';?>
<title><?php if($abbr != NULL) { echo 'CTR '.$archiveDate; } else { echo 'CTR Issue'; } ?></title>
</head>
<body>
    <div id = "main">
        <?php require_once 'php/header.php';?>
        <div id = "content">
            <div class = "review" id = "issue">
                <?php
				if($linkLarge != NULL) { echo '<div class = "review-body">'; }
				
				// HEADING
                if($archiveDate != NULL) { echo '<div class = "review-title">CTR '.$archiveDate.'</div>'; }
				
				// ISSUE NUMBER
                if($volume != NULL) { echo 'Vol. '.$volume.' '; }
                if($number != NULL) { echo 'No. '.$number.' '; }
                if($issue != NULL)  { echo 'Issue '.$issue; }
				
				// DOWNLOAD AS PDF
				if($pdf != NULL)
				{
					echo '<br/>';
					if($subscriber == true or $temp == true or $license == true or $freeMode == true)
					{ echo '<a href = "pdf.php?-url='.urlencode($pdf).'" target = "_blank">Download this issue as a PDF</a>'; }
					else { echo '<a href = "subscribe.php?redirect='.urlencode($thisURL).'">Log in as a subscriber to download this issue as a PDF</a>';  }
				} // end if $linkPDF
				
				// SUBJECT
				if($subject != NULL) { echo '<div class = "review-heading">'.$subject.'</div>'; }
				
				echo '<div class = "review-text">';
				
                    // INTRO
                    if($intro != NULL) 
                    { 
                        if($subscriber == true or $temp == true or $license == true or $freeMode == true) { echo '<p>'.parseLinks($intro).'</p>'; }
                        else
                        {
                            $introPreviewLength = 300;
                            echo '<p>'.substr($intro, 0, $introPreviewLength).'...</p>';
                            echo '<div class = "review-velvet-rope no-print">';
                                echo '<button type = "button" onclick = "openURL(\'subscribe.php?redirect='.$thisURL.'\')">Log in as a subscriber to see the full issue</button>';
                            echo '</div>';
                        } // end if($velvetRope == true)
                    } // end if $intro != NULL

                    // LIST OF TITLES
                    if($numTitles > 0 and ($subscriber == true or $temp == true or $license == true or $freeMode == true))
                    {
                        echo '<p>';
                        echo '<div class = "t20 mb-10"><a href = "home.php?monthly='.$abbr.'">'.$numTitles.' Feature Reviews</a></div>';
                        $titles = $record->getRelatedSet('CSR'); 
                        foreach($titles as $thisTitle)
                        {
                            $title 		= $thisTitle->getField('CSR::Title');
                            $titleID	= $thisTitle->getField('CSR::reviewnumber');
                            $titleLink	= 'review.php?id='.$titleID;
                            $edChoice	= $thisTitle->getField('CSR::edChoice');
                            if($edChoice != NULL) { $titleText = '*'.$title; } else { $titleText = $title; }
                            echo '<a href = "'.$titleLink.'" title = "Read our review of '.$title.'">'.$titleText.'</a><br/>';
                        } // end foreach title
                        echo '</p>';
                    } // end if($numTitles > 0)

                    // CONCLUSION
                    if($conclusion != NULL and ($subscriber == true or $temp == true or $license == true or $freeMode == true)) { echo '<p>'.parseLinks($conclusion).'</p>'; }
				
				echo '</div>'; // /.review-text
				
				// COVER AND PDF DOWNLOAD
				if($cover != NULL)
				{
					echo '</div>'; // /.review-body
					echo '<div class = "review-images">';
						if($subscriber == true or $temp == true or $license == true or $freeMode == true)
						{
							echo '<a href = "pdf.php?-url='.urlencode($pdf).'" title = "Download this issue as a PDF" target = "_blank">';
								echo '<img src = "img.php?-url='.urlencode($cover).'" alt = "Image not available" style = "max-width:100%; height:auto;">';
                            echo '</a>';
                            echo '<div class = "mt-10 center">';
                                echo '<a href = "pdf.php?-url='.urlencode($pdf).'" title = "Download this issue as a PDF" target = "_blank">';
                                    echo 'Download this issue as a PDF';
                                echo '</a>';
                            echo '</div>'; // /.mt-10 center
						} // end if can download pdf
						else
						{
							echo '<a href = "subscribe.php?redirect='.urlencode($thisURL).'" title = "Log in as a subscriber to download this issue as a PDF">';
								echo '<img src = "img.php?-url='.urlencode($cover).'" alt = "Image not available" style = "max-width:100%; height:auto;">';
                            echo '</a>';
                            echo '<div class = "mt-10 center">';
                                echo '<a href = "subscribe.php?redirect='.urlencode($thisURL).'" title = "Log in as a subscriber to download this issue as a PDF">';
                                    echo 'Log in as a subscriber to download this issue as a PDF';
                                echo '</a>';
                            echo '</div>'; // /.mt-10 center
						} // end else cannot download pdf
					echo '</div>'; // /.review-images
				} // end if $linkLarge
                ?>
            </div><!-- /.review /#issue -->
        </div><!-- /#content -->
        <?php require_once 'php/footer.php';?>
    </div><!-- /#main -->
</body>
</html>