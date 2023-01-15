<?php
$captcha = rand(0,9).rand(0,9).rand(0,9);
$error = $_SESSION['captcha-error'];
$_SESSION['captcha-error'] = '';
if($error != NULL) { echo '<div class = "error-message center">The digits you entered were incorrect. Please try again.</div>'; }
?>
<div class = "form-row" id = "captcha">
    <div class = "form-label">*Enter <div class = "captcha"><?php echo $captcha;?></div></div>
    <div class = "form-field-captcha">
        <input type = "text" name = "captcha" required />
        <input type = "hidden" name = "solution" value = "<?php echo $captcha;?>" />
    </div><!-- /.form-row -->
</div><!-- /.form-row /#captcha -->