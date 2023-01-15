<?php
require_once 'php/autoload.php';
$contactInput = $_SESSION['contactInput'];
$name    = $contactInput[0];
$email   = $contactInput[1];
$message = $contactInput[2];
?>
<!doctype html>
<html>
<head>
    <?php require_once 'php/head.php';?>
    <title>Children's Technology Review - Contact</title>
</head>
<body>
    <div id = "main">
        <?php require_once 'php/header.php';?>
        <div id = "content">
            <div class = "center" id = "contact">
                <h1>Contact Us</h1>
				<strong><em>* Indicates required field</em></strong>
                <div class = "paragraph">
					<form name = "contact-form" method = "POST" action = "contact-process.php">
						<div class = "form-row">
							<div class = "form-label">*Name:</div>
							<div class = "form-field"><input type = "text" name = "name" required placeholder = "Name" value = "<?php echo $name;?>" /></div>
						</div><!-- /.form-row -->
						<div class = "form-row">
							<div class = "form-label">*Email:</div>
							<div class = "form-field"><input type = "email" name = "email" required placeholder = "yourname@yourdomain.com" value = "<?php echo $email;?>" /></div>
						</div><!-- /.form-row -->
						<div class = "form-row">
                            <div class = "form-label">*Message</div>
                            <div class = "form-field">
								<textarea name = "message" rows = "10" required placeholder = "Message..."><?php echo $message;?></textarea>
							</div><!-- /.form-row -->
                        </div><!-- /.form-row -->
						<?php require_once 'php/captcha.php'; ?>
						<input type = "hidden" name = "validation" value = "true" />
                        <div class = "form-row-submit no-print">
                            <div class = "center no-print"><input type = "submit" value = "Submit Message" /></div>
                        </div><!-- /.form-row -->
					</form>
					<div class = "form-info mt-20"><?php require_once 'php/contact-info.php';?></div>
                </div><!-- /.paragraph -->
            </div><!-- /.center /#contact -->
        </div><!-- /#content -->
        <?php require_once 'php/footer.php';?>
    </div><!-- /#main -->
</body>
</html>