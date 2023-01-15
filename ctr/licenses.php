<?php
require_once 'php/autoload.php';

// SET FORM TEXT
$linkID   = 'ca966d00-ebb6-4517-bded-b353892e77fa';
$header   = '$260 per year';
$btnLabel = 'Subscription Form';
$hoverText= 'Proceed to secure order form';
?>

<!doctype html>
<html>
<head>
    <?php require_once 'php/head.php';?>
    <title>CTR Site Licenses</title>
</head>

<body>
    <div id = "main">
        <?php require_once 'php/header.php';?>
        <div id = "content" class = "center">
            
            <h1>CTR Site Licenses</h1>
            <h2>Get full database access for your organization</h2>
            
            <div class = "subscribe-form">
                <form id = "site-license-form" name = "site-license-form" method = "POST" action = "https://Simplecheckout.authorize.net/payment/CatalogPayment.aspx" target = "_blank">
                    <input type = "hidden" name = "LinkId" value ="<?php echo $linkID;?>" />
                    <div class = "subscribe-form-header" title = "<?php echo $hoverText;?>" onclick = "submitForm('site-license-form')">
                        <?php echo $header;?>
                    </div><!-- /#subscribe-form-header -->
                    <div class = "subscribe-form-details">Full database access with custom URL for your organization</div>
                    <input type = "submit" value = "<?php echo $btnLabel;?>" title = "<?php echo $hoverText;?>" class = "no-print"/>
                </form><!-- /#site-license-form -->
            </div><!-- /.subscribe-form -->
            
            <!-- SUBSCRIPTION DETAILS -->
            <h2>Included in your subscription:</h2>
            <div class = "subscription-details">
                <ul>
                    <li>A vast archive of 13,000+ reviews from 2,000+ publishers.</li>
                    <li>Fast, accurate sorting, by grade, subject, platform and rating.</li>
                    <li>A password-free, custom URL for your organization</li>
                    <!--<li>CTR Weekly (sent by email every Wednesday) and CTR Quarterly Issues</li>-->
                    <li>No advertising, gimmicks, or affiliate links. We don't accept money for reviewing products. Like Consumer Reports, our mission is to inform — not sell.</li>
                    <li>A no questions, money-back guarantee.</li>
                </ul>
            </div><!-- /.subscription-details -->
            
        </div><!-- /#content -->
        <?php require_once 'php/footer.php';?>
    </div><!-- /#main -->
</body>
</html>