<?php
if($redirect == NULL) { $redirect = 'home.php'; }
if($pageTitle == NULL){ $pageTitle = 'Redirecting...'; }
?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<meta name = "description" content = "Objective reviews of children's apps, toys, games, and other interactive media"/>
<meta name="google-site-verification" content="QifxFlcb5iOlsJFTJF2jL-h3lpo12RQeFuOyK6aak8k" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="refresh" content="0;url=<?php echo $redirect;?>">
<title><?php echo $pagetitle;?></title>
</head>
<body>
</body>
</html>