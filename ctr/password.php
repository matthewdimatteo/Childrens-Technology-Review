<?php
require_once 'php/autoload.php';
$passwordInput = $_SESSION['passwordInput'];
$inputUsername = $passwordInput[0];
$inputEmail	   = $passwordInput[1];
$inputZip	   = $passwordInput[2];
?>
<!doctype html>
<html>
<head>
    <?php require_once 'php/head.php';?>
    <title>Children's Technology Review - Password Recovery</title>
</head>
<body>
    <div id = "main">
        <?php require_once 'php/header.php';?>
        <div id = "content">
            <div class = "center" id = "password-recovery">
				<h1>Recover a Password</h1>
                <div class = "paragraph">
					<h3>
						Enter your CTR username and provide an email address to receive your password. To verify your identity, we ask that you please provide your zip code as well.
					</h3>
					<form name = "password-recovery-form" id = "password-recovery-form" method = "POST" action = "password-recovery.php">
						<div class = "form-row">
							<div class = "form-label">Username:</div>
							<div class = "form-field"><input type = "text" name = "username" required placeholder = "username" value = "<?php echo $inputUsername;?>" /></div>
						</div><!-- /.form-row -->
						<div class = "form-row">
							<div class = "form-label">Email:</div>
							<div class = "form-field"><input type = "email" name = "email" required placeholder = "yourname@yourdomain.com" value = "<?php echo $inputEmail;?>"/></div>
						</div><!-- /.form-row -->
						<div class = "form-row">
							<div class = "form-label">Zip:</div>
							<div class = "form-field"><input type = "text" name = "zip" required placeholder = "xxxxx" value = "<?php echo $inputZip;?>"/></div>
						</div><!-- /.form-row -->
						<?php require_once 'php/captcha.php'; ?>
						<div class = "form-row-submit no-print">
							<input type = "hidden" name = "validation" value = "true" />
							<input type = "submit" name = "submit" value = "Lookup Password" />
						</div><!-- /.form-row-submit -->
					</form>
                </div><!-- /.paragraph -->
				<h3>Don't know your username?</h3>
				<p>
					Try using the email address associated with your CTR subscription.<br/>
					You can also contact us by email at <a href = "mailto:info@childrenstech.com">info@childrenstech.com</a> or call us at 908-284-0404
				</p>
				<h3>Zip code not working?</h3>
				<p>
					Email us <a href = "mailto:info@childrenstech.com">info@childrenstech.com</a> or call us at 908-284-0404 for a manual reset.
				</p>
            </div><!-- /.center /#password-recovery -->
        </div><!-- /#content -->
        <?php require_once 'php/footer.php';?>
    </div><!-- /#main -->
</body>
</html>