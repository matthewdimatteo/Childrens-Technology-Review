<?php
require_once 'php/autoload.php';

$searchArchivePage = test_input($_GET['page']);
if($searchArchivePage == NULL or $searchArchivePage < 1) { $searchArchivePage = 1; }
if($searchArchivePage > 1 and $subscriber != true and $temp != true and $license != true and $freeMode != true) { $searchArchivePage = 1; }

// CONNECT TO ISSUES DATABASE
$fmmonthly = new FileMaker();
$fmmonthly->setProperty('database', 'subbies');
$fmmonthly->setProperty('username', $username);
$fmmonthly->setProperty('password', $password);
$fmmonthly->setProperty('hostspec', $hostspec);
$fmmonthlyLayout = 'archive-monthly';
$layoutmonthly = $fmmonthly->getLayout($fmmonthlyLayout);

// LOOK UP MOST RECENTLY PUBLISHED ISSUES
$findArchive = $fmmonthly->newFindCommand($fmmonthlyLayout);
$resultSize = 10;
$skip = ($searchArchivePage - 1) * $resultSize;
$findArchive->setRange($skip, $resultSize);
$findArchive->addFindCriterion('issues::active', "*");
$findArchive->addSortRule('year', 1, FILEMAKER_SORT_DESCEND); 
$findArchive->addSortRule('month', 2, FILEMAKER_SORT_DESCEND);
$result = $findArchive->execute();
if(FileMaker::isError($result)) { echo 'Error loading issues: '.$result->getMessage(); exit(); }
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
                <div class = "inline archive-btn-active no-print"><button type = "button" onclick = "openURL('archive.php')">Issues</button></div>
                <div class = "inline archive-btn no-print"><button type = "button" onclick = "openURL('weeklies.php')">Weeklies</button></div>
                <div class = "inline archive-btn no-print"><button type = "button" onclick = "openURL('articles.php')">Articles</button></div>
                <div class = "no-print"><br/><br/></div>
                <div class = "left">
                <?php
                // GET RECORD DATA
                foreach($records as $record)
                {
                    $archiveID      = $record->getField('archiveID');
                    $archiveLink    = 'issue.php?id='.$archiveID;
                    $archiveDate    = $record->getField('issueDateText');
                    $abbr    = $record->getField('issueDateAbbr');
                    $subject        = $record->getField('subjectNotes');
                    $volume         = $record->getField('volume');
                    $number         = $record->getField('number');
                    $issue          = $record->getField('issueNumber');
                    $intro          = $record->getField('intro');
                    $conclusion     = $record->getField('conclusion');
                    $linkPDF        = $record->getField('issues::linkPDF');
                    $linkPreview    = $record->getField('issues::linkPreview');
                    $linkThumb      = $record->getField('issues::linkThumb');
                    $linkLarge      = $record->getField('issues::linkLarge');
                    $linkSquare     = $record->getField('issues::linkSquare');
					$pdf 			= $record->getField('issues::pdf');
					$cover 			= $record->getField('issues::cover');
                    $numTitles      = $record->getField('numTitles');
                    
                    // DATE AND SUBJECT HEADING
                    echo '<div class = "result-item">';
                    
                        // HEADING
                        $issueHeading = 'CTR '.$archiveDate; if($subject != NULL) { $issueHeading.= ' - '.$subject; }
                        $issueHeadingMax = 100;
                        echo '<a href = "'.$archiveLink.'" title = "View the full issue">';
                            echo '<div class = "result-title archive-heading">';
                                if((strlen($issueHeading) > $issueHeadingMax)) { echo trimText($issueHeading, $issueHeadingMax); }
                                else { echo $issueHeading; }
                            echo '</div>'; // /.title
                        echo '</a>';
                    
                        // BODY
                        echo '<div class = "archive-body">';
                            
                            // COVER
                            echo '<div class = "archive-cover">';
                                if($cover != NULL)
                                {
                                    echo '<a href = "'.$archiveLink.'">';
                                        echo '<img src = "img.php?-url='.urlencode($cover).'" alt = "Image not available" width = "100" height = "130">';
                                    echo '</a>';
                                } // end if $cover
                                
                                // NUMBER
                                echo '<div class = "caption">';
                                    if($volume != NULL) { echo 'Vol. '.$volume.' '; }
                                    if($number != NULL) { echo 'No. '.$number.' '; }
                                    if($issue != NULL)  { echo 'Issue '.$issue; }
                                    echo '<br/><a href = "'.$archiveLink.'" class = "no-print">View the full issue</a>';
                                echo '</div>'; // /.caption
                                if($numTitles > 0)
                                {
                                    echo '<div><a href = "home.php?monthly='.$abbr.'">'.$numTitles.' Feature Reviews</a></div>';
                                    echo '<div class = "caption"><em>* Denotes Editor\'s Choice</em></div>';
                                }
                                
                            echo '</div>'; // /.archive-cover
                            
                            // TITLES
                            echo '<div class = "archive-titles">';
                                echo '<div class = "center">';
                                if($numTitles > 0) 
                                { 
                                    $gridTitles = array();
                                    $gridTitleMax 		= 36;
                                    $gridTitleMax1025	= 30;
                                    $gridTitleMax769	= 20;
                                    $gridTitleMax480	= 9;
                                    $titles = $record->getRelatedSet('CSR'); 
                                    foreach($titles as $thisTitle)
                                    {
                                        $title 		= $thisTitle->getField('CSR::Title');
                                        $titleID	= $thisTitle->getField('CSR::reviewnumber');
                                        $titleLink	= 'review.php?id='.$titleID;
                                        $edChoice	= $thisTitle->getField('CSR::edChoice');
                                        if($edChoice != NULL) { $title = '*'.$title; }
                                        $titleText 		= trimText($title, $gridTitleMax);
                                        $titleText1025 	= trimText($title, $gridTitleMax1025);
                                        $titleText769 	= trimText($title, $gridTitleMax769);
                                        $titleText480 	= trimText($title, $gridTitleMax480);
                                        $thisTitleInfo = array($title, $titleLink);
                                        array_push($gridTitles, array($title, $titleLink, $titleText, $titleText1025, $titleText769, $titleText480));
                                        //echo $title.'<br/>';
                                    } // end foreach title

                                    $numCols = 3; // number of columns per row
                                    $numRows = $numTitles/$numCols; // number of rows

                                    $tg = -1; // counter for result grid records
                                    for($row = 0; $row < $numRows; $row++)
                                    {
                                        echo '<div class = "left">';
                                            for($col = 0; $col < $numCols; $col++)
                                            {
                                                $tg++; // increment the titles array counter with each column
                                                echo '<div class = "archive-title-col">';
                                                    // prevent from outputting empty containers after the last result
                                                    if($tg < $numTitles)
                                                    {
                                                        $gridTitleInfo 		= $gridTitles[$tg];
                                                        $gridTitle 			= $gridTitleInfo[0];
                                                        $gridTitleLink 		= $gridTitleInfo[1];
                                                        $gridTitleText		= $gridTitleInfo[2];
                                                        $gridTitleText1025	= $gridTitleInfo[3];
                                                        $gridTitleText769	= $gridTitleInfo[4];
                                                        $gridTitleText480	= $gridTitleInfo[5];
                                                        echo '<a href = "'.$gridTitleLink.'" title = "See our review of '.$gridTitle.'">'.$gridTitleText.'</a>';
                                                        /*
                                                        echo '<div class = "show-only-desktop">';
                                                            echo '<a href = "'.$gridTitleLink.'" title = "See our review of '.$gridTitle.'">'.$gridTitleText.'</a>';
                                                        echo '</div>';
                                                        echo '<div class = "show-only-1025">';
                                                            echo '<a href = "'.$gridTitleLink.'" title = "See our review of '.$gridTitle.'">'.$gridTitleText1025.'</a>';
                                                        echo '</div>';
                                                        echo '<div class = "show-only-769">';
                                                            echo '<a href = "'.$gridTitleLink.'" title = "See our review of '.$gridTitle.'">'.$gridTitleText769.'</a>';
                                                        echo '</div>';
                                                        echo '<div class = "show-only-480">';
                                                            echo '<a href = "'.$gridTitleLink.'" title = "See our review of '.$gridTitle.'">'.$gridTitleText480.'</a>';
                                                        echo '</div>';
                                                        */
                                                    } // end if $tg < $numTitles
                                                echo '</div>'; // /.archive-item-title-col
                                            } // end for col
                                        echo '</div>'; // /row
                                    } // end for row
                                } // end if $numTitles != NULL
                                echo '</div>'; // /.center
                            echo '</div>'; // /.archive-titles
                        
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