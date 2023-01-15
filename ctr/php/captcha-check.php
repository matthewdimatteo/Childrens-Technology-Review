<?php
$captcha 	 = test_input($_POST['captcha']);
$solution 	 = test_input($_POST['solution']);
if($captcha != $solution)
{
    $_SESSION['captcha-error'] = true;
    $redirect .= '#captcha';
    $pageTitle = 'Incorrect digits; please try again';
    require_once 'redirect.php'; exit();
} // end if captcha error
?>