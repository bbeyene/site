<!doctype html>
<?php
$ip = $_SERVER["REMOTE_ADDR"];
system("./record $ip about");

header("Cache-Control: no-store, must-revalidate, max-age=0");
header("Cache-Control: post-check=0", false);
header("Pragma: no-cache");
?>

<html>
	<head>
		<title>About</title>
		<meta http-equiv="pragma" content="no-cache" />
		<meta http-equiv="robots" content"noindex" />
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	<body>
		<h3>About</h3>
		<hr />
		<p><span class="summary">The main purpose of this site is to serve as a repository and showcase for past and current projects.</span></p>
		<figure>
			<p><a href="code.php">some code<!--<img src="images/logo5.gif" alt="code" title="html,css,js,php,c++" /?--></a></p>
				<figcaption>Most of the languages I've used are self-tought so there are better ways to do what I did. Provide criticism below, 
						it currently goes to /dev/null (NOWHERE!)</figcaption>
		</figure>
		<br />
		<h3>Suggestions</h3>
		<hr />
		<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
			<label>Name <input type="text" name="user" size="20" maxlength="30" /></label>
			<p>Comments for listed projects?
			<input id="greenhouse" type="radio" name="project[]" value="greenhouse" checked="checked" />
			<label for="greenhouse">Greenhouse</label>
			<input id="other" type="radio" name="project[]" value="other" />
			<label for="other">Other</label>
			</p>
			<textarea name="comment" cols="60" rows="10"></textarea><br />
			<input type="submit" name="submit" value="Submit" />
		</form>
<p>
<?php

$ip = $_SERVER["REMOTE_ADDR"];

$user = $_POST['user'];
$comments = $_POST['comments'];
echo $user;
echo $comments;
//if(isset($user) || isset($comments)) {
//	echo("Incomplete fields.");
//}
//else {
//	echo("Thank you " . $name .);
//}i
?>
</p>
		<br />
		<h3>Contact</h3>
		<hr />
		<a href="mailto:bruskey@yahoo.com">Email</a>

		<br><br><hr /><a href="index.php">[HOME]</a>
	</body>
</html>
