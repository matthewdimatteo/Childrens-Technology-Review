<?php
require_once 'php/autoload.php';

$searchArchivePage = test_input($_GET['page']);
if($searchArchivePage == NULL or $searchArchivePage < 1) { $searchArchivePage = 1; }
if($searchArchivePage > 1 and $subscriber != true and $temp != true and $license != true and $freeMode != true) { $searchArchivePage = 1; }

// CONNECT TO WEEKLIES DATABASE
$fmweekly = new FileMaker();
$fmweekly->setProperty('database', 'subbies');
$fmweekly->setProperty('username', $username);
$fmweekly->setProperty('password', $password);
$fmweekly->setProperty('hostspec', $hostspec);
$fmweeklyLayout = 'archive-weekly';
$layoutweekly = $fmweekly->getLayout($fmweeklyLayout);

// LOOK UP MOST RECENTLY PUBLISHED ISSUES
$findArchive = $fmweekly->newFindCommand($fmweeklyLayout);
$resultSize = 10;
$skip = ($searchArchivePage - 1) * $resultSize;
$findArchive->setRange($skip, $resultSize);
$findArchive->addFindCriterion('weekly::active', "*");
$findArchive->addSortRule('weeklyDate', 1, FILEMAKER_SORT_DESCEND);
$result = $findArchive->execute();
if(FileMaker::isError($result)) { echo 'Error loading weeklies: '.$result->getMessage(); exit(); }
$records = $result->getRecords();

// ANALYTICS
$rangeStart = 1 + (($searchArchivePage - 1) * $resultSize);
$rangeEnd = $resultSize + (($searchArchivePage - 1) * $resultSize);
$foundcount = $result->getFoundSetCount();
$fetchcount = $result->getFetchCount();
$numPages = ceil($foundcount/$resultSize);
if ( $rangeEnd > $foundcount ) { $rangeEnd = $foundcount; }

$_SESSION['archiveSearchURL'] = $thisURL;
?>
<!doctype html>
<html>
<head>
<?php require_once 'php/head.php';?>
<title>Children's Technology Review - Archive</title>
</head>
<body>
    <div id = "main">
        <?php require_once 'php/header.php';?>
        <div id = "content">
            <div class = "center" id = "archive">
                <h1>Archive</h1>
                <div class = "inline archive-btn no-print"><button type = "button" onclick = "openURL('archive.php')">Issues</button></div>
                <div class = "inline archive-btn-active no-print"><button type = "button" onclick = "openURL('weeklies.php')">Weeklies</button></div>
                <div class = "inline archive-btn no-print"><button type = "button" onclick = "openURL('articles.php')">Articles</button></div>
                <div class = "no-print"><br/><br/></div>
                <div class = "left">
                <?php
				// GET RECORD DATA
                foreach($records as $record)
                {
                    $archiveID      = $record->getField('archiveID');
                    $archiveLink    = 'weekly.php?id='.$archiveID;
                    $archiveDate    = $record->getField('weeklyDate');
                    $abbr    		= $record->getField('weeklyMDY');
					$weeklyParam    = $record->getField('weeklyParam');
                    $subject        = $record->getField('subjectNotes');
                    $intro          = $record->getField('intro');
                    $conclusion     = $record->getField('conclusion');
                    $numTitles      = $record->getField('numTitles');
                    
                    // DATE AND SUBJECT HEADING
                    echo '<div class = "result-item">';
                    
                        // HEADING
                        $issueHeading = $archiveDate; if($subject != NULL) { $issueHeading.= ' - '.$subject; }
                        $issueHeadingMax = 100;
                        echo '<a href = "'.$archiveLink.'" title = "View the full issue">';
                            echo '<div class = "result-title archive-heading">';
                                if((strlen($issueHeading) > $issueHeadingMax)) { echo trimText($issueHeading, $issueHeadingMax); }
                                else { echo $issueHeading; }
                            echo '</div>'; // /.title
                        echo '</a>';
                    
                        // BODY
                        echo '<div class = "archive-body center">';
							echo '<br/><br/>';
                            $relatedTitleFieldsArchive = array
                            (
                                array('title'		, 'CSR::Title'),
                                array('titleID'		, 'CSR::reviewnumber'),
                                array('permalink'	, 'CSR::permalink'),
                                array('published'	, 'CSR::published'),
                                array('copyright'	, 'CSR::Copyright'),
                                array('dateEntered'	, 'CSR::Date of Review'),
                                array('titleImg'	, 'CSR::Sample Screen'),
                                array('titleImgData', 'CSR::imgData'),
                                array('edChoice'	, 'CSR::edChoice'),
                                array('weeklySummary', 'CSR::weeklySummary'),
                            );

                            if($numTitles > 0)
							{
								$titles = $record->getRelatedSet('CSR'); 
								foreach($titles as $thisTitle)
                                {
                                    $title 		= $thisTitle->getField('CSR::Title');
                                    $titleID	= $thisTitle->getField('CSR::reviewnumber');
									$titleImg	= $thisTitle->getField('CSR::Sample Screen');
                                    $titleLink	= 'review.php?id='.$titleID;
									
									$gridTitleMax 		= 36;
                                    $gridTitleMax1025	= 30;
                                    $gridTitleMax769	= 20;
                                    $gridTitleMax480	= 9;
                                    $titleText 		= trimText($title, $gridTitleMax);
                                    $titleText1025 	= trimText($title, $gridTitleMax1025);
                                    $titleText769 	= trimText($title, $gridTitleMax769);
                                    $titleText480 	= trimText($title, $gridTitleMax480);
                                    $thisTitleInfo = array($title, $titleLink);
									
									echo '<div class = "weekly-img">';
										echo '<a href = "'.$titleLink.'">';
										if($titleImg != NULL and $titleImg != '?')
										{
											echo '<img src = "img.php?-url='.urlencode($titleImg).'"><br/>';
										} // end if $titleImg
										else
                                        {
                                            echo '<div class = "no-image">';
                                                echo '<div class = "no-image-text">Image not available</div>';
                                            echo '</div>';
                                        } // end else no img
										echo '</a>';
										echo '<a href = "'.$titleLink.'">'.$titleText.'</a>';
									echo '</div>'; // /.weekly-img
									
                                } // end foreach title
							} // end if $numTitles > 0
                        	echo '<br/><br/>';
                        echo '</div>'; // /.archive-body
                    
                    echo '</div>'; // /.result-item

                } // end foreach $record
                ?>
                </div><!-- /.left -->
				
				<!-- HIDDEN PAGINATION FORM -->
				<div class = "hide">
					<form name = "browse-archive-form" method = "GET" action = "<?php echo $thisPage;?>">
						<input type = "hidden" name = "page" value = "<?php echo $searchArchivePage;?>"/>
					</form>
				</div><!-- /.hide -->
				
				<?php
				if($subscriber == true or $temp == true or $license == true or $freeMode == true) { require 'php/pagenav.php'; }
				else
				{
					echo '<div id = "more-results" class = "center mt-20">';
						echo '<button type = "button" onclick = "openURL(\'subscribe.php?redirect='.urlencode($thisURL).'\')">Log in as a subscriber for more results</button>';
					echo '</div>';
				}
				?>
				
			</div><!-- /.center /#archive -->
        </div><!-- /#content -->
        <?php require_once 'php/footer.php';?>
    </div><!-- /#main -->
</body>
</html>