<?php
require_once 'php/autoload.php';

// SET FORM TEXT
$linkID = 'd8be7918-42b9-41b7-b35a-c147d8d68942';
$subscriptionPrice = 30;
$header   = '$'.$subscriptionPrice.' per year';
$btnLabel = 'Subscription Form';
$hoverText= 'Proceed to secure order form';

// OBTAIN VELVET ROPE REDIRECT LINK
if(isset($_GET['redirect']))
{
    $velvetRopeRedirect = test_input($_GET['redirect']);
}
?>

<!doctype html>
<html>
<head>
    <?php require_once 'php/head.php';?>
    <title>CTR Subscriptions</title>
</head>

<body>
    <div id = "main">
        <?php require_once 'php/header.php';?>
        <div id = "content" class = "center">
            <?php //echo $velvetRopeRedirect.'<br/>'; ?>
			
			<!-- MOBILE LOGIN -->
			<?php if($subscriber != true and $license != true)
			{
				echo '
                <h1 class = "mobile-only">Subscriber Login</h1>
                <form name = "login-form" class = "mobile-only" method = "POST" action = "login.php">
                    <div class = "login-form-row"><input type = "text" name = "username" required placeholder = "username" /></div>
                    <div class = "login-form-row"><input type = "password" name = "password" required placeholder = "password" /></div>
                    <div class = "login-form-row">
                        <div class = "inline"><input type = "checkbox" name = "publisher" id = "login-as-publisher-mobile" /></div>
                        <div class = "inline" id = "publisher-login-label-mobile" onclick = "toggleCheckmark(\'login-as-publisher-mobile\')">Log in as publisher</div>
                    </div>
                    <div class = "login-form-row">
                        <input type = "hidden"   name = "redirect" value = "home.php" />
                        <input type = "submit"   name = "submit"            value = "Log In" />
                    </div>
                </form>
                ';
			} // end if !$subscriber and !$license
			?>
			
            <!-- SUBSCRIPTION FORM -->
            <h1>Subscribe to CTR</h1>
            <div class = "subscribe-form">
                <form id = "subscription-form" name = "subscription-form" method = "POST" action = "https://Simplecheckout.authorize.net/payment/CatalogPayment.aspx" target = "_blank">
                    <input type = "hidden" name = "LinkId" value ="<?php echo $linkID;?>" />
                    <div class = "subscribe-form-header" title = "<?php echo $hoverText;?>" onclick = "submitForm('subscription-form')">
                        <?php echo $header;?>
                    </div><!-- /#subscribe-form-header -->
                    <div class = "subscribe-form-details">Full database access</div>
                    <input class = "no-print" type = "submit" value = "<?php echo $btnLabel;?>" title = "<?php echo $hoverText;?>" />
                </form><!-- /#subscription-form -->
            </div><!-- /.subscribe-form -->
            
            <?php //require_once 'php/sample-issue.php';?>
            
            <!-- SUBSCRIPTION DETAILS -->
            <h2>Included in your subscription:</h2>
            <div class = "subscription-details">
                <ul>
                    <li>A vast archive of 13,000+ reviews from 2,000+ publishers.</li>
                    <li>Fast, accurate sorting, by grade, subject, platform and rating.</li>
                    <!--<li>CTR Weekly (sent by email every Wednesday) and CTR Quarterly Issues</li>-->
                    <li>No advertising, gimmicks, or affiliate links. We don't accept money for reviewing products. Like Consumer Reports, our mission is to inform — not sell.</li>
                    <li>A no questions, money-back guarantee.</li>
                </ul>
            </div><!-- /.subscription-details -->
            
            <p class = "paragraph bold">
                <a href = "licenses.php">Site licenses</a> are also available at $260/year to get access for your entire school or library with a custom URL for your organization.
            </p>
            
        </div><!-- /#content -->
        <?php require_once 'php/footer.php';?>
    </div><!-- /#main -->
</body>
</html>