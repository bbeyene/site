<?php
$ip = $_SERVER["REMOTE_ADDR"];
system("./record $ip home");

header("Cache-Control: no-store, must-revalidate, max-age=0");
header("Cache-Control: post-check=0", false);
header("Pragma: no-cache");

?>
<!doctype html>
<html>
	<head>
        	<title>Beyene</title>
		<meta http-equiv="pragma" content="no-cache" />
		<meta http-equiv="pragma" content="noindex" />
		<link rel="stylesheet" type="text/css" href="style.css">
		<meta name="viewport" content="width=device-width", initial-scale="1.0">
	</head>
	<body>

	<table>
		<tr>
		<td valign="top">
		<a href="projects.php"> Projects </a>
		<a href="about.php"> About </a>
		</td>
		<td>
		<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
			<input type="username" name="username" size="15" maxlength="30" />
			<input type="password" name="password" size="15" maxlength="30" />
			<input type="submit" name="go" value="GO" />
		</form>
		</td>
		</tr>
		<tr>
		<td><br><br><br>
		<?php 
$name = $_POST['username'];
if($name == "arif" || $name == "Arif")
	echo ('<iframe height="1400" width="800" src="controls.php" scrolling="no" frameborder="0"></iframe>');
else
	echo ('<iframe height="1400" width="800" src="jscode.php" scrolling="no" frameborder="0"></iframe>');
?>
		</td>
		<td></td>
    </body>
</html>
