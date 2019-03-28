<!doctype html>
<?php
$ip = $_SERVER["REMOTE_ADDR"];
system("./record $ip greenhouse");

header("Cache-Control: no-store, must-revalidate, max-age=0");
header("Cache-Control: post-check=0", false);
header("Pragma: no-cache");
?>

<html>
	<head>
		<title>Greenhouse</title>
		<meta http-equiv="pragma" content="no-cache" />
		<meta http-equiv="robots" content="noindex" />
		<link name="viewport" content="width=device-width", initial-scale="1.0">
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	<body>
		<h3>Greenhouse</h3>
		<hr />
		<table>
			<tr valign="top">
				<td>
				<iframe src="status.php" valign="top" width="410" height="1400" frameborder="0" scrolling="no"></iframe>
				</td>
				<td><iframe src="log.php" width="1200" height="20000" frameborder="0" scrolling="no"></iframe></td>
			</tr>
		</table>

	<br><br><hr /><a href="index.php">[HOME]</a>
	</body>
</html>
