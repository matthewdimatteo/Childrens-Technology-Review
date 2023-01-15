<?php
require_once 'php/autoload.php';

// PROCESS PASSWORD RECOVERY FORM
if(isset($_POST['validation']))
{
    // GET FORM INPUTS
    $name 	 = test_input($_POST['name']);
	if($publisher == true) { $name = $publisherName; }
	if($license == true)   { $name = $licenseName; }
    $comment = test_input($_POST['comment']);
	$score	 = test_input($_POST['score-num']);
	$type    = test_input($_POST['type']);
	$reviewID= test_input($_POST['reviewID']);
	$redirect= test_input($_POST['redirect']);
	if($subscriber == true or $temp == true) { $usertype = 'Subscriber'; }
	if($publisher == true)	{ $usertype = 'Publisher'; }
	if($license == true)	{ $usertype = 'License'; }
	
	// CONNECT TO COMMENTS DATABASE (parameters set in php/autoload.php)
    $fmreviews = new FileMaker();
    $fmreviews->setProperty('database', 'CSR');
    $fmreviews->setProperty('username', $username);
    $fmreviews->setProperty('password', $password);
    $fmreviews->setProperty('hostspec', $hostspec);
    $fmreviewsLayout = 'comments';
    $layoutreviews = $fmreviews->getLayout($fmreviewsLayout);
	
	// ADD NEW COMMENT
	if($type == 'create' or $type == 'new' or $type == 'add' or $type == 'post')
	{
		$record = $fmreviews->createRecord($fmreviewsLayout);
		$record->setField('commenter', $name);
		$record->setField('comment', $comment);
		$record->setField('rating', $score);
		$record->setField('reviewnumber', $reviewID);
		$record->setField('usertype', $usertype);
		if($subscriber == true or $temp == true) { $record->setField('userID', $subscriberID); }
		if($publisher == true)  { $record->setField('publisherID', $publisherID); }
		if($license == true)	{ $record->setField('orgName', $licenseName); }
		$record->setField('date', $dateConv);
		$record->setField('time', $time);
		$commit = $record->commit();
		if(FileMaker::isError($commit)) { echo 'Error posting comment: '.$commit->getMessage(); exit(); }
		$pageTitle = 'Posting comment...';
	} // end if $type == 'create'
	
	// MODIFY/REMOVE EXISTING COMMENT
	else
	{
		// LOOKUP THE COMMENT BY ITS ID
		$commentID = $_POST['commentID'];
		$findComment = $fmreviews->newFindCommand($fmreviewsLayout);
		$findComment->addFindCriterion('commentID','=='.$commentID);
		$result = $findComment->execute();
		if(FileMaker::isError($result)) { echo 'Error looking up comment: '.$result->getMessage(); exit(); }
		$record = $result->getFirstRecord();
		
		// EDIT
		if ($type == 'edit' or $type == 'update' or $type == 'modify')
		{
			$record->setField('commenter', $name);
			$record->setField('comment', $comment);
			$record->setField('rating', $score);
			$commit = $record->commit();
			if(FileMaker::isError($commit)) { echo 'Error updating comment: '.$commit->getMessage(); exit(); }
			$pageTitle = 'Updating comment...';
		} // end if $type == 'edit'
		
		// DELETE
		else if ($type == 'delete' or $type == 'remove' or $type == 'clear')
		{
			$commit = $record->delete();
			if(FileMaker::isError($commit)) { echo 'Error deleting comment: '.$commit->getMessage(); exit(); }
			$pageTitle = 'Removing comment...';
		} // end if $type == 'delete'
	} // end else
} // end if isset validation
else { $redirect = 'home.php'; }
?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<meta name = "description" content = "Objective reviews of children's apps, toys, games, and other interactive media"/>
<meta name="google-site-verification" content="QifxFlcb5iOlsJFTJF2jL-h3lpo12RQeFuOyK6aak8k" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="refresh" content="0;url=<?php echo $redirect;?>">
<title><?php echo $pageTitle;?></title>
</head>
<body>
</body>
</html>