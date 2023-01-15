<?php
require_once 'php/autoload.php';
$redirect = $archiveSearchURL;
if(isset($_GET['id']))
{
	$archiveID 	= test_input($_GET['id']);
	if($archiveID != NULL) 	
	{
		// CONNECT TO WEEKLIES DATABASE
        $fmweekly = new FileMaker();
        $fmweekly->setProperty('database', 'subbies');
        $fmweekly->setProperty('username', $username);
        $fmweekly->setProperty('password', $password);
        $fmweekly->setProperty('hostspec', $hostspec);
        $fmweeklyLayout = 'archive-weekly';
        $layoutweekly = $fmweekly->getLayout($fmweeklyLayout);
		
		// LOOKUP WEEKLY BY RECORD NUMBER
		$findWeekly = $fmweekly->newFindCommand($fmweeklyLayout);
		$findWeekly->addFindCriterion('archiveID',"==".$archiveID);
		$result = $findWeekly->execute();
		if (FileMaker::isError ($result) ) { echo $result->getMessage(); exit(); }
		$record = $result->getFirstRecord();
		
		// CHECK THAT WEEKLY IS ACTIVE
		$active = $record->getField('active');
		if($active != NULL) { $active = true; } else { $active = false; }
		if($active != true) { require_once 'redirect.php'; } // return to archive if weekly not marked active
		
		// GET RECORD DATA
        $archiveDate    = $record->getField('weeklyDate');
        $abbr    		= $record->getField('weeklyMDY');
        $weeklyParam    = $record->getField('weeklyParam');
        $subject        = $record->getField('subjectNotes');
        $intro          = $record->getField('intro');
        $conclusion     = $record->getField('conclusion');
        $numTitles      = $record->getField('numTitles');
		
    } else { require_once 'redirect.php'; exit(); } // redirect back to archive if archiveID not specified
} else { require_once 'redirect.php'; exit(); } // redirect back to archive if form not set

?>
<!doctype html>
<html>
<head>
<?php require_once 'php/head.php';?>
<title>CTR Weekly<?php if($abbr != NULL) { echo ' - '.$abbr; } ?></title>
</head>
<body>
    <div id = "main">
        <?php require_once 'php/header.php';?>
        <div id = "content">
            <div class = "review" id = "issue">
                <?php
				if($numTitles > 0) { echo '<div class = "review-body">'; }
				
				// HEADING
                if($archiveDate != NULL) { echo '<div class = "review-title">CTR Weekly '.$archiveDate.'</div>'; }
				
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
                            echo '<div class = "review-velvet-rope">';
                                echo '<button type = "button" class = "no-print" onclick = "openURL(\'subscribe.php?redirect='.$thisURL.'\')">Log in as a subscriber to keep reading</button>';
                            echo '</div>';
                        } // end if($velvetRope == true)
                    } // end if $intro != NULL
					
					// LIST OF TITLES
                    if($numTitles > 0)
                    {
                        if($subscriber == true or $temp == true or $license == true or $freeMode == true)
						{
							echo '<p>';
                        	echo '<div class = "t20 mb-10"><a href = "home.php?weekly='.$weeklyParam.'">This week\'s noteworthy products:</a></div>';
						}
						$images = array();
                        $titles = $record->getRelatedSet('CSR'); 
                        foreach($titles as $thisTitle)
                        {
							// GET RECORD DATA
                            $title 		   = $thisTitle->getField('CSR::Title');
                            $titleID	   = $thisTitle->getField('CSR::reviewnumber');
							$weeklySummary = $thisTitle->getField('CSR::weeklySummary');
                            $edChoice	   = $thisTitle->getField('CSR::edChoice');
							$thumbnail     = $thisTitle->getField('CSR::Sample Screen');
							
							// FORMAT DATA
							$titleLink	= 'review.php?id='.$titleID;
							if($edChoice != NULL) { $titleText = '*'.$title; } else { $titleText = $title; }
							if($thumbnail != NULL and $thumbnail != '?') { array_push($images, array($thumbnail, $titleLink, $title)); }
                            
							// OUTPUT TITLES AND SUMARIES FOR SUBSCRIBERS
							if($subscriber == true or $temp == true or $license == true or $freeMode == true)
							{
                                echo '<a href = "'.$titleLink.'" title = "Read our review of '.$title.'">'.$titleText.'</a><br/>';
                                echo parseLinksOld(nl2br($weeklySummary)).'<br/><br/>';
                                echo '<hr/>';
							} // end if $subscriber or $license
							
                        } // end foreach title
                        if($subscriber == true or $temp == true or $license == true) { echo '</p>'; }
                    } // end if($numTitles > 0)

                    // CONCLUSION
                    if($conclusion != NULL and ($subscriber == true or $temp == true or $license == true or $freeMode == true)) { echo '<p>'.parseLinks($conclusion).'</p>'; }
					
				echo '</div>'; // /.review-text
				
				// PRODUCT IMAGES
				$imgCount  = count($images);
				if($imgCount > 0)
				{
					echo '</div>'; // /.review-body
					echo '<div class = "review-images">';
					
						$img1 	   = $images[0][0];
						$zoomLink1 = $images[0][1];
						$zoomHover1= 'Read our review of '.$images[0][2];
						
						$img2 	   = $images[1][0];
						$zoomLink2 = $images[1][1];
						$zoomHover2= 'Read our review of '.$images[1][2];
						
						$img3 	   = $images[2][0];
						$zoomLink3 = $images[2][1];
						$zoomHover3= 'Read our review of '.$images[2][2];
						
						// FIRST IMAGE INFOCUS
                        echo '<div class = "review-image-infocus" id = "review-image-infocus-1">';
                        if($img1 != NULL)
                        {
                            echo '<a href = "'.$zoomLink1.'" title = "'.$zoomHover1.'">';
                                echo '<img src = "img.php?-url='.urlencode($img1).'" alt = "Image not available">';
                            echo '</a>';
                        }
                        echo '</div>'; // /.review-image-infocus /#review-image-infocus-1
                    
                        // IMAGE 2 HIDDEN
                        if($img2 != NULL)
                        {
                            echo '<div class = "hide" id = "review-image-infocus-2">';
                                echo '<a href = "'.$zoomLink2.'" title = "'.$zoomHover2.'">';
                                    echo '<img src = "img.php?-url='.urlencode($img2).'" alt = "Image not available">';
                                echo '</a>';
                            echo '</div>'; // /.review-image-infocus /#image-infocus-2
                        } // end if $img2
                        
                        // IMAGE 3 HIDDEN
                        if($img3 != NULL)
                        {
                            echo '<div class = "hide" id = "review-image-infocus-3">';
                                echo '<a href = "'.$zoomLink3.'" title = "'.$zoomHover3.'">';
                                    echo '<img src = "img.php?-url='.urlencode($img3).'" alt = "Image not available">';
                                echo '</a>';
                            echo '</div>'; // /.review-image-infocus /#image-infocus-3
                        } // end if $img3
                    
                        // GALLERY
                        if($imgCount > 1)
                        {
                            echo '<div class = "review-image-gallery">';
                                
                                if($img1 != NULL)
                                {
                                    echo '<div class = "review-image-gallery-item-selected" id = "image1">';
                                        echo '<img src = "img.php?-url='.urlencode($img1).'" alt = "Image not available" onclick = "imgToggle(1)">';
                                    echo '</div>';
                                } // end if $img1
                                
                                if($img2 != NULL)
                                {
                                    echo '<div class = "review-image-gallery-item" id = "image2">';
                                        echo '<img src = "img.php?-url='.urlencode($img2).'" alt = "Image not available" onclick = "imgToggle(2)">';
                                    echo '</div>';
                                } // end if $img2
                                
                                if($img3 != NULL)
                                {
                                    echo '<div class = "review-image-gallery-item" id = "image3">';
                                        echo '<img src = "img.php?-url='.urlencode($img3).'" alt = "Image not available" onclick = "imgToggle(3)">';
                                    echo '</div>';
                                } // end if $img3
                                
                            echo '</div>'; // /.review-images-gallery
                        } // end if $imgCount > 1
					
					echo '</div>'; // /.review-images
				} // end if $numTitles > 0
				?>
			</div><!-- /.review /#issue -->
        </div><!-- /#content -->
        <?php require_once 'php/footer.php';?>
    </div><!-- /#main -->
</body>
</html>