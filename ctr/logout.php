<?php
require_once 'php/autoload.php';
session_unset(); // clear the previous php session data
session_destroy();
session_write_close();
session_start(); // start a new session to store the logout flag
//$logout = true;	$_SESSION['logout'] = true; 
$redirect = "home.php";
//echo 'You have been logged out. <a href = "'.$redirect.'">Return home</a>'; exit();
?>

<!doctype html>
<html>
<head>
<!-- META -->
<meta charset="UTF-8">
<meta name = "description" content = "Objective reviews of children's apps, toys, games, and other interactive media"/>
<meta name="google-site-verification" content="QifxFlcb5iOlsJFTJF2jL-h3lpo12RQeFuOyK6aak8k" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="refresh" content="0;url=<?php echo $redirect;?>">
<title>Logging out...</title>
</head>

<body>
</body>
</html>