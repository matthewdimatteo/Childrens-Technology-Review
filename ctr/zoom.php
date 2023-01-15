<?php
require_once 'php/autoload.php';
$redirect = $reviewSearchURL;
if(isset($_GET['id']) and isset($_GET['image']))
{
    $reviewID 	= test_input($_GET['id']);
    $imageNumber= test_input($_GET['image']);
	if($reviewID != NULL) 	
	{ 
        // CONNECT TO REVIEW DATABASE (parameters set in php/autoload.php)
        $fmreviews = new FileMaker();
        $fmreviews->setProperty('database', 'CSR');
        $fmreviews->setProperty('username', $username);
        $fmreviews->setProperty('password', $password);
        $fmreviews->setProperty('hostspec', $hostspec);
        $fmreviewsLayout = 'php-csr';
        $layoutreviews = $fmreviews->getLayout($fmreviewsLayout);
        
        // LOOKUP REVIEW BY RECORDS NUMBER
        // note: cannot use getRecordById method, as CSR::reviewnumber (field used for CTREX links) does not correspond to the actual recordID
		$findReview = $fmreviews->newFindCommand($fmreviewsLayout);
		$findReview->addFindCriterion('reviewnumber',"==".$reviewID);
		$result = $findReview->execute();
		if (FileMaker::isError ($result) ) { echo $result->getMessage(); exit(); }
		$record = $result->getFirstRecord();
        
        // GET FIELD DATA
        $published 	= $record->getField('published');
        $title      = $record->getField('Title');
        
        // GET IMAGE
        if($imageNumber == NULL) { $imageNumber = 1; }
        switch($imageNumber)
        {
            case 1 : $imageField = 'Sample Screen';  break;
            case 2 : $imageField = 'sample screen2'; break;
            case 3 : $imageField = 'Image3';         break;
            default: $imageField = 'Sample Screen';  break;
        }
        $image = $record->getField($imageField);
                
    } else { require_once 'redirect.php'; exit(); } // redirect home if review ID not specified
} else { require_once 'redirect.php'; exit(); } // redirect home if form not set
?>
<!doctype html>
<html>
<head>
    <?php require_once 'php/head.php';?>
    <title>CTREX Review<?php if($title != NULL) { echo ' - '.$title; } ?></title>
</head>

<body>
    <div id = "main">
        <?php require_once 'php/header.php';?>
        <div id = "content">
            <div class = "back-to-review no-print">
                <a href = "review.php?id=<?php echo $reviewID;?>">Back to review</a>
            </div>
            <div class = "full-size-image">
                <?php echo '<img src = "img.php?-url='.urlencode($image).'" alt = "Image not available">'; ?>
            </div>
        </div><!-- /#content -->
        <?php require_once 'php/footer.php';?>
    </div><!-- /#main -->
</body>
</html>