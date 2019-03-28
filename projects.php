<!doctype html>
<?php
$ip = $_SERVER["REMOTE_ADDR"];
system("./record $ip projects");

header("Cache-Control: no-store, must-revalidate, max-age=0");
header("Cache-Control: post-check=0", false);
header("Pragma: no-cache");
?>


<html>
	<head>
		<title>Projects</title>
		<meta http-equiv="pragma" content="no-cache" />
		<meta http-equiv="robots" content="noindex" />
		<link name="viewport" content="width=device-width", initial-scale="1.0">
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	<body>
		<h3>Projects</h3>
		<hr />
		<p><a href="greenhouse.php">Greenhouse</a></p>
		<p><a href="other.php">Other</a></p>

	<br><br><br><br><br><br><hr /><a href="index.php">[HOME]</a>
	</body>
</html>
