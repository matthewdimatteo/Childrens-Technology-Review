<?php

// VALIDATE FORM INPUT
function test_input($input)
{
	$input = trim($input);
	$input = stripslashes($input);
	$input = htmlspecialchars($input);
	return $input;
} // end test_input()

// TRIM TEXT
function trimText($text, $max)
{
	if(strlen($text) > $max) { $text = substr($text, 0, $max).'...'; } 
	else { $text = $text; }
	return($text);
}

// ADD HYPERLINKS TO TEXT
function parseLinks($text) 
{
	/*
	this function (adapted from http://krasimirtsonev.com/blog/article/php--find-links-in-a-string-and-replace-them-with-actual-html-link-tags)
	handles duplicate urls, but still can be broken by periods followed by line breaks, and does not handle plain 'www' instances
	*/
    $reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
    $urls = array();
    $urlsToReplace = array();
	
	// REPLACE ALL INSTANCES OF "WWW" WITH "HTTP://WWW" SO THAT PARSING FUNCTION WILL HANDLE ALL CASES
	$numWWW = substr_count($text, ' www.');
	if($numWWW > 0) { $text = str_replace ( ' www', ' http://www', $text, $numWWW ); }
	$numBRWWW = substr_count($text, "\n".'www.');
	if($numBRWWW > 0) { $text = str_replace ( "\n".'www.', "\n".'http://www.', $text, $numBRWWW ); }
		
    if(preg_match_all($reg_exUrl, $text, $urls))
	{
        $numMatches = count($urls[0]);
        $numOfUrlsToReplace = 0;
        for($i = 0; $i < $numMatches; $i++)
		{
            $alreadyAdded = false;
            $numOfUrlsToReplace = count($urlsToReplace);
            for($j = 0; $j < $numOfUrlsToReplace; $j++)
			{
				if($urlsToReplace[$j] == $urls[0][$i]) { $alreadyAdded = true; }  
			}
            if($alreadyAdded != true) { array_push($urlsToReplace, $urls[0][$i]); }
        } // end for i < $numMatches
		
        $numOfUrlsToReplace = count($urlsToReplace);
        for($i = 0; $i < $numOfUrlsToReplace; $i++)
		{
            $text = str_replace($urlsToReplace[$i], "<a href=\"".$urlsToReplace[$i]."\" target = \"_blank\">".$urlsToReplace[$i]."</a> ", $text);
        }
        
    } // end if preg_match_all
	
	$text = nl2br($text);
	return($text);
	
} // end function parseLinks()

// PARSE LINKS IN A BODY OF TEXT -----------------------------------------------------------------------------
function parseLinksOld($text)
{
	// ADD LINE BREAKS
	$text = nl2br($text);
	
	/*
	the counting method doesn't work - if there is, for example, a case with 1 instance of plain www and 3 instances of https://www,
	then the count is < 0 and the www will not get replaced
	*/
	// COUNT THE NUMBER OF OCCURRENCES OF "WWW" WITHOUT A PRECEEDING "HTTP"
	$numWWW 	= substr_count ( $text, 'www.' );
	$numHTTPWWW = substr_count ( $text, '://www.' );
	$numHTTPSWWW = substr_count($text, 'https://www');
	$w = $numWWW - $numHTTPWWW - $numHTTPSWWW;

	// REPLACE ALL INSTANCES OF "WWW" WITH "HTTP://WWW" SO THAT PARSING FUNCTION WILL HANDLE ALL CASES
	if ($w > 0) { $text = str_replace ( 'www', 'http://www', $text, $w ); }
	
	// BEGIN PARSING
	$needle = 'http';
	$needleLength = strlen($needle);
	$needleCount = substr_count ( $text, $needle );
	
	// DECLARE ARRAYS FOR THE LINKS
	$needles = array();
	$tags = array();
	$hyperlinks = array();

	// LOOP THROUGH ALL LINKS AND PARSE THEM
	for ( $i = 0; $i < $needleCount; $i++ )
	{
		// DETERMINE START POS OF LINK
		$needleStart = strpos($text, $needle, $needleStart + $needleLength );

		// DETERMINE ENDPOINT OF LINK - EITHER A SPACE OR LINE BREAK
		$distSpace 	= abs(stripos($text, ' ', $needleStart) - $needleStart); 
		$distNL 	= abs(stripos($text, "\n", $needleStart) - $needleStart); 
		$distBR		= abs(stripos($text, '<br>', $needleStart) - $needleStart);
		if ($distSpace <= $distNL) { $needleLength = $distSpace; } else { $needleLength = $distNL; } $needleLength += 0;

		// PARSE OUT THE LINK FROM BETWEEN THE START POS AND ENDPOINT
		$needleParsed = substr($text, $needleStart, $needleLength);
		$needleUntrimmed = $needleParsed;

		// TRIM EXTRA CHARACTERS ( periods or parentheses or <br> tags from end of string )
		$needleTrim1 = substr($needleParsed, 0, strlen($needleParsed)-1);
		$needleTrim2 = substr($needleParsed, 0, strlen($needleParsed)-2);

		$lastChar 		= substr($needleParsed, -1);
		$secondLastChar = substr($needleParsed, -2, 1);

		if ($lastChar == '.' or $lastChar == ',' or $lastChar == ')') 						{ $needleParsed = $needleTrim1; }
		if ($secondLastChar == '.' or $secondLastChar == ',' or $secondLastChar == ')') 	{ $needleParsed = $needleTrim2; }

		$needleTrimBR 	= substr($needleParsed, 0, strlen($needleParsed)-3);
		if ( substr_count ( $needleParsed, '<br') > 0 )										{ $needleParsed = $needleTrimBR; }

		// THE LINK SHOULD NOW BE PROPERLY PARSED	

		// CONSTRUCT THE <a> TAG
		$needleTag = '<a href = "'.$needleParsed.'" target = "_blank">'.$needleParsed.'</a>'; 
		// COULD EVENTUALLY DEFINE A VALUE FOR HREF AND DISPLAY TEXT SEPARATELY?

		// UPDATE THE LINK ARRAYS
		$needles[$i] = $needleParsed;
		$tags[$i] = $needleTag;
		$hyperlinks[$i] = array($needleParsed, $needleTag);
		
	} // END FOR LOOP

	// REPLACE THE LINK TEXT WITH THE <a> TAGS (USING THE ARRAYS AS PARAMS IN THE STR REPLACE FUNCTION)
	$parsed = str_replace($needles, $tags, $text);
	return $parsed;

} // END function parseLinksOld($text)

// CONVERT A VIDEO URL TO COMPATIBLE IFRAME FORMAT -----------------------------------------------------------------------------
function videoLink($video)
{
			if ( substr_count ( $video, 'http://youtu.be/' ) 				> 0 )
			{
				$vidIDStart 	= strpos($video, 'http://youtu.be/') + strlen('http://youtu.be');
				$vidID			= substr($video, $vidIDStart);
				$vidURL 		= "https://youtube.com/embed".$vidID;
			}
	else	if ( substr_count ( $video, 'https://youtu.be/' ) 				> 0 )
			{
				$vidIDStart 	= strpos($video, 'https://youtu.be/') + strlen('https://youtu.be');
				$vidID			= substr($video, $vidIDStart);
				$vidURL 		= "https://youtube.com/embed".$vidID;
			}
	else	if ( substr_count ( $video,	'https://www.youtube.com/watch?v=') > 0 )
			{
				$vidIDStart 	= strpos($video, 'https://www.youtube.com/watch?v=') + strlen('https://www.youtube.com/watch?v=');
				$vidID			= substr($video, $vidIDStart);
				$vidURL 		= "https://youtube.com/embed/".$vidID;
			}	
	else	if ( substr_count ( $video,	'http://www.youtube.com/watch?v=') 	> 0 )
			{
				$vidIDStart 	= strpos($video, 'http://www.youtube.com/watch?v=') + strlen('http://www.youtube.com/watch?v=');
				$vidID			= substr($video, $vidIDStart);
				$vidURL 		= "https://youtube.com/embed/".$vidID;
			}			
	else	if ( substr_count ( $video, 'http://vimeo.com/')							> 0 )
			{
				$vidIDStart 	= strpos($video, 'http://vimeo.com/') + strlen('http://vimeo.com/');
				$vidID			= substr($video, $vidIDStart);
				$vidURL 		= "https://player.vimeo.com/video/".$vidID;
			}
	else	if ( substr_count ( $video, 'https://vimeo.com/')							> 0 )
			{			
				$vidIDStart 	= strpos($video, 'https://vimeo.com/') + strlen('https://vimeo.com/');
				$vidID			= substr($video, $vidIDStart);
				$vidURL 		= "https://player.vimeo.com/video/".$vidID;
			}
	else
			{
				$video = '';
				$vidURL = '';
			}	
	$vid = array($vidURL, $video);
	return $vid;
} // end videoLink()

// FORMAT A FULL NAME, REMOVING EXTRA SPACES
function formatFullName($fname, $lname)
{
	$fnameLastChar 	= substr($fname, -1, 1);	// get last character of first name
	$lnameFirstChar = substr($lname, 1, 1);		// get first character of last name
	if($fnameLastChar == ' ') 	{ $fnameLength = strlen($fname); $fname = substr($fname, 0, $fnameLength - 1); }
	if($lnameFirstChar == ' ') 	{ $lnameLength = strlen($lname); $lname = substr($lname, 1, $fnameLength - 1); }
	$fullName = $fname.' '.$lname;
	return ($fullName);
}

// FORMAT A STREET ADDRESS
function formatAddress($street, $city, $state, $zip, $country)
{
	$fullAddress;

	if($street != NULL) 	{ $fullAddress .= $street; }
	if($street != NULL and ($city != NULL or $state != NULL or $zip != NULL or $country != NULL) ) 
							{ $fullAddress .= '<br>'; }
	if($city != NULL)		{ $fullAddress .= $city; }
	if($city != NULL and $state != NULL) 
							{ $fullAddress .= ', '; }
	if($state != NULL)		{ $fullAddress .= $state; }
	if($state != NULL and $zip != NULL) 
							{ $fullAddress .= ' '; }
	if($zip != NULL)		{ $fullAddress .= $zip; }
	if($zip != NULL and $country != NULL)
							{ $fullAddress .= ' '; }
	if($country != NULL)	{ $fullAddress .= $country; }

	return($fullAddress);
} // end formatAddress()

// format text to be compatible with string comparison functions
function cleanText($text)
{
	$text = strtolower($text);
	//$text = iconv('utf-8', 'ascii//TRANSLIT', $text);
	$text = preg_replace("/&([a-z])[a-z]+;/i", "$1", htmlentities($text));
	$text = preg_replace("#[[:punct:]]#", "", $text);
	return ($text);
}

// GET TEXT AS AN ARRAY OF WORDS
function getTextArray($text)
{
	$numWords = str_word_count($text, 0, '1234567890');
	if($numWords > 1) { $wordsArray = explode(' ', $text); } else { $wordsArray = array($text); $word = $text; }
	return(array('words'=>$wordsArray, 'wordcount'=>$numWords, 'word'=>$word));
}

// GET LIST ITEMS
function getListItems($record, $field, $size)
{
	$listItemsArray = array();
	for($li = 0; $li <= $size; $li ++)
	{
		$thisListItem = $record->getField($field, $li);
		//if($thisListItem != NULL) { array_push($listItemsArray, $thisListItem); }
		array_push($listItemsArray, $thisListItem);
	} // end for
	return($listItemsArray);
}
?>