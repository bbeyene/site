<!doctype html>
<?php
$ip = $_SERVER["REMOTE_ADDR"];
system("./record $ip code");

header("Cache-Control: no-store, must-revalidate, max-age=0");
header("Cache-Control: post-check=0", false);
header("Pragma: no-cache");
?>



<html>
    <head>
        <title>Code</title>
	<meta http-equiv="pragma" content="no-cache" />
	<meta http-equiv="robots" content="noindex" />
	<link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body>
	<h3>Code</h3>
	<hr />
	<p>None posted yet</p>
	<br><br><br><br><br><br><a href="index.php">[HOME]</a>
    </body>
</html>
