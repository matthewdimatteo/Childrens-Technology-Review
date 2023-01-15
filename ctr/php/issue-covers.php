<?php
// CONNECT TO ISSUES DATABASE
$fmmonthly = new FileMaker();
$fmmonthly->setProperty('database', 'subbies');
$fmmonthly->setProperty('username', $username);
$fmmonthly->setProperty('password', $password);
$fmmonthly->setProperty('hostspec', $hostspec);
$fmmonthlyLayout = 'archive-monthly';
$layoutmonthly = $fmmonthly->getLayout($fmmonthlyLayout);

// LOOK UP 6 MOST RECENTLY PUBLISHED ISSUES
$findArchive = $fmmonthly->newFindCommand($fmmonthlyLayout);
$findArchive->setRange(0, 12);
$findArchive->addFindCriterion('issues::active', "*");
$findArchive->addSortRule('year', 1, FILEMAKER_SORT_DESCEND); 
$findArchive->addSortRule('month', 2, FILEMAKER_SORT_DESCEND);
$result = $findArchive->execute();
if(FileMaker::isError($result)) 
{ 
    echo 'Error loading issues';
    exit();
}
$records = $result->getRecords();
$gridRecords = array();

// GET RECORD DATA AND STORE IN SEPARATE ARRAY
foreach($records as $record)
{
    $archiveID      = $record->getField('archiveID');
    $archiveLink    = 'issue.php?id='.$archiveID;
    $archiveDate    = $record->getField('issueDateText');
    $monthlyAbbr    = $record->getField('issueDateAbbr');
    $subject        = $record->getField('subjectNotes');
    $volume         = $record->getField('volume');
    $number         = $record->getField('number');
    $issue          = $record->getField('issue');
    $intro          = $record->getField('intro');
    $conclusion     = $record->getField('conclusion');
    $linkPDF        = $record->getField('issues::linkPDF');
    $linkPreview    = $record->getField('issues::linkPreview');
    $linkThumb      = $record->getField('issues::linkThumb');
    $linkLarge      = $record->getField('issues::linkLarge');
    $linkSquare     = $record->getField('issues::linkSquare');
	$pdf 			= $record->getField('issues::pdf');
	$cover 			= $record->getField('issues::cover');
    $numTitles      = $record->getField('issues::numTitles');
    array_push($gridRecords, array($archiveLink, $monthlyAbbr, $cover));
} // end foreach $record

// OUTPUT GRID OF COVER THUMBS
$numCols = 6; // number of columns per row
$numRows = 2; // number of rows
$ag = -1;
for($row = 0; $row < $numRows; $row++)
{
    echo '<div class = "mb-10">';
        for($col = 0; $col < $numCols; $col++)
        {
            $ag++; // increment the records array counter with each column
            $item = $gridRecords[$ag];// locate the record by index number
            $archiveLink = $item[0];
            $monthlyAbbr = $item[1];
            $cover       = $item[2];
            echo '<div class = "sixths">';
                //echo '<div class = "result-item-grid">';

                    // output the grid item
                    echo '<div><a href = "'.$archiveLink.'">'.$monthlyAbbr.'</a></div>';
                    echo '<div class = "archive-item-image">';
                        echo '<a href = "'.$archiveLink.'">';
                            echo '<img src = "img.php?-url='.urlencode($cover).'" alt = "Image not available" width = "100" height = "130">';
                        echo '</a>';
                    echo '</div>'; // /.archive-item-image

                //echo '</div>'; // /.result-item-grid
            echo '</div>'; // /.result-item-archive-grid-col
        } // end for col
    echo '</div>'; // /.bottom-20
} // end for row
?>