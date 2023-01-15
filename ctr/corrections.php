<?php
require_once 'php/autoload.php';

// CONNECT TO CORRECTIONS DATABASE
$fmcorrections = new FileMaker();
$fmcorrections->setProperty('database', 'CSR');
$fmcorrections->setProperty('username', $username);
$fmcorrections->setProperty('password', $password);
$fmcorrections->setProperty('hostspec', $hostspec);
$fmcorrectionsLayout = 'corrections';
$layoutcorrections = $fmcorrections->getLayout($fmcorrectionsLayout);

// LOOKUP CORRECTIONS RECORDS
$findCorrections = $fmcorrections->newFindCommand($fmcorrectionsLayout);
$findCorrections->addFindCriterion('correction', '*');
$findCorrections->addSortRule('recordID', 1, FILEMAKER_SORT_DESCEND);
$correctionsResult = $findCorrections->execute();
if(FileMaker::isError($correctionsResult)) { echo 'Error: '.$correctionsResult->getMessage(); exit(); }
$correctionsRecords = $correctionsResult->getRecords();
?>

<!doctype html>
<html>
<head>
    <?php require_once 'php/head.php';?>
    <title>Children's Technology Review - Corrections</title>
</head>

<body>
    <div id = "main">
        <?php require_once 'php/header.php';?>
        <div id = "content">
            <div class = "center">
                <h1>Corrections</h1>
                <div class = "paragraph">
                    <p>
                        This is where we post corrections. We also may make notes in the body of the review. If you notice an error or would like to suggest a correction, please <a href = "about.php#contact">contact us</a>.
                    </p>
                    <?php
                    // OUTPUT CORRECTIONS
                    foreach($correctionsRecords as $correctionsRecord)
                    {
                        $correction = $correctionsRecord->getField('correction');
                        echo '<p>'.parseLinks($correction).'</p>';
                    } // end foreach $correctionsRecord
                    ?>
                </div><!-- /.paragraph -->
            </div><!-- /.center -->
        </div><!-- /#content -->
        <?php require_once 'php/footer.php';?>
    </div><!-- /#main -->
</body>
</html>