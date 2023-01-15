<?php

switch($thisPage)
{
	case 'home.php' 	: $searchPage = $searchReviewsPage; break;
	case 'archive.php'  : $searchPage = $searchArchivePage; break;
	case 'issues.php'   : $searchPage = $searchArchivePage; break;
	case 'weeklies.php' : $searchPage = $searchArchivePage; break;
	case 'articles.php' : $searchPage = $searchArchivePage; break;
	default 			: $searchPage = $searchReviewsPage; break;
}

// PAGENAV CALC
// calculate the page number for each button
$firstPage 				= 1;
$lastPage 				= $numPages;
$lastPageVelvet 		= ceil($foundcount/$numResults);
if($searchPage < 2)		     { $prevPage = 1; }
else 						 { $prevPage = $searchPage - 1; }
if($searchPage >= $numPages) { $nextPage = $numPages; }
else						 { $nextPage = $searchPage + 1; }

// parse the current url and replace the value of the page parameter with that of the page value for each button
// if there is a query string with a page parameter
if($thisQuery != NULL and substr_count($thisURL, 'page=') > 0)
{
	$pageStart 			= strpos($thisURL, 'page=') + strlen('page=');
	$thisPageFirst 		= substr_replace($thisURL, $firstPage, $pageStart);
	$thisPagePrev 		= substr_replace($thisURL, $prevPage, $pageStart);
	$thisPageNext 		= substr_replace($thisURL, $nextPage, $pageStart);
	$thisPageLast 		= substr_replace($thisURL, $lastPage, $pageStart); 
	$thisPageLastVelvet = substr_replace($thisURL, $lastPageVelvet, $pageStart);
}
// if there is a query string, append an & to it with page parameter
else if($thisQuery != NULL and substr_count($thisURL, 'page=') < 1)
{
	$thisPageFirst		= $thisURL.'&page='.$firstPage;
	$thisPagePrev		= $thisURL.'&page='.$prevPage;
	$thisPageNext		= $thisURL.'&page='.$nextPage;
	$thisPageLast		= $thisURL.'&page='.$lastPage;
	$thisPageLastVelvet	= $thisURL.'&page='.$lastPageVelvet;
}
// if there is no query string, append a ? to begin one
else
{
	$thisPageFirst		= $thisPage.'?page='.$firstPage;
	$thisPagePrev		= $thisPage.'?page='.$prevPage;
	$thisPageNext		= $thisPage.'?page='.$nextPage;
	$thisPageLast		= $thisPage.'?page='.$lastPage;
	$thisPageLastVelvet	= $thisPage.'?page='.$lastPageVelvet;
}
// velvet rope override (includes target destination as url for redirection after login)
if($subscriber != true and $temp != true and $license != true and $freeMode != true and $searchReviewsCompany != $publisherName)
{
	$thisPageNext = 'subscribe.php?redirect='.urlencode($thisPageNext);
	$thisPageLast = 'subscribe.php?redirect='.urlencode($thisPageLastVelvet);
}

// FORMAT THOUSANDS SEPARATOR - foundcount, numPages, rangeStart, rangeEnd
if($foundcount > 1000) 	{ $foundcountStr 	= number_format($foundcount, 0, '.', ','); }	else { $foundcountStr 	= $foundcount; }
if($numPages > 1000) 	{ $numPagesStr 		= number_format($numPages, 0, '.', ','); }		else { $numPagesStr 	= $numPages; }
if($rangeStart > 1000) 	{ $rangeStartStr 	= number_format($rangeStart, 0, '.', ','); }	else { $rangeStartStr 	= $rangeStart; }
if($rangeEnd > 1000) 	{ $rangeEndStr 		= number_format($rangeEnd, 0, '.', ','); } 		else { $rangeEndStr 	= $rangeEnd; }

// SET PAGE NAVIGATION STRING
$rangeEndLabel = $rangeEndStr; 
$numPagesLabel = $numPagesStr;
if($foundcount < $resultSize) { $rangeEndLabel = $foundcount; }
$pagenav = 'Page ';
$pagenav .= $searchPage.' of '.$numPagesLabel;
$pagenav .= ' - Results '.$rangeStartStr.' to '.$rangeEndLabel.' of '.$foundcountStr;
?>
<div class = "pagenav">
    <div class = "pagenav-col">
        <?php if($searchPage > 1)
        {
            echo '<button type = "button" onclick = "openURL(\''.$thisPageFirst.'\')">First</button>';
        }
        ?>
    </div>
    <div class = "pagenav-col">
        <?php if($searchPage > 1)
        {
            echo '<button type = "button" onclick = "openURL(\''.$thisPagePrev.'\')">Prev</button>';
        }
        ?>
    </div>
    <div class = "pagenav-col" id = "pagenav-string"><?php echo $pagenav;?></div>
    <div class = "pagenav-col">
        <button type = "button" onclick = "openURL('<?php echo $thisPageNext;?>')" <?php if($searchPage >= $numPages){echo 'class="hide"';}?>>Next</button>
    </div>
    <div class = "pagenav-col">
        <button type = "button" onclick = "openURL('<?php echo $thisPageLast;?>')" <?php if($searchPage >= $numPages){echo 'class="hide"';}?>>Last</button>
    </div>
</div><!-- /.pagenav -->