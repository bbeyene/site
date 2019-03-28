<?php
$ip = $_SERVER["REMOTE_ADDR"];
system("./record $ip controls");

header("Cache-Control: no-store, must-revalidate, max-age=0");
header("Cache-Control: post-check=0", false);
header("Pragma: no-cache");

?>

<!doctype html>
<html>
	<head>
		<title>Controls	</title>
		<meta http-equiv="pragma" content="no-cache" />
		<meta http-equiv="robots" content="noindex" />
		<meta name="viewport" content="width=device-width" initial-scale="1.0">
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	<body>
	<table>
		<td width="410">
			<iframe src="status.php" width="410" height="1400" frameborder="0" scrolling="no"></iframe>
		</td>
		<td valign="top">
			<table>
				<tr>
				<td width="500" valign="center">
					<fieldset><legend>Change Auto Setting</legend>
						<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
							House <select name="autoArea" required>
								<option value=""></option>
								<option value="House 1">1</option>
								<option value="House 2">2</option>
								</select><br /><br />
							<table align="center">
							<tr><th></th><th></th></tr>
							<tr><td valign="top">Temperature </td> 
							<td><input type="number" id="number" placeholder="32 - 100" min="32" max="100" name="autoTemp" />&degF<br /><br /></td></tr>
							<tr><td valign="top">Humidity </td>
							<td><input type="number" id="number" placeholder="5 - 100" min="10" max="100" name="autoHumid" />%<br /><br />	</td></tr>
							<tr><td valign="top">Light </td>
							<td><input type="number" id="number" placeholder="1 - 24" min="0" max="24" name="autoLight" />Hour-Day<br /><br /></td></tr>
							<tr><td valign="top">Water </td>
							<td><select name="autoWaterAmount">
								<option value=""></option>
								<option value="off">OFF</option>
								<option value="low">LOW</option>
								<option value="medium">MEDIUM</option>
								<option value="high">HIGH</option>
							</select> 
							Per <select name="autoWaterPer">
								<option value=""></option>
								<option value="never">Never</option>
								<option value="day">Day</option>
								<option value="week">Week</option>
							</select><br /><br /></td></tr>
							</table>
							<input type="submit" name="set" value="SET" />
						</form>
					</fieldset>
				</td>
				</tr>
				<tr>


				<td valign="bottom">
					<?php
						$autoArea = $_POST['autoArea'];
						$autoSetVal = array();
						$autoSetName = array();

						if(!empty($_POST['autoTemp'])) {
							array_push($autoSetVal, $_POST['autoTemp']);
							array_push($autoSetName, "Preset-Temperature");
						}
						if(!empty($_POST['autoHumid'])) {
							array_push($autoSetVal, $_POST['autoHumid']);
							array_push($autoSetName, "Preset-Humidity");
						}
						if(!empty($_POST['autoLight'])) {
							array_push($autoSetVal, $_POST['autoLight']);
							array_push($autoSetName, "Light-Duration");
						}
						if(!empty($_POST['autoWaterAmount'])) {
							array_push($autoSetVal, $_POST['autoWaterAmount']);
							array_push($autoSetName, "Water-Amount");
						}
						if(!empty($_POST['autoWaterPer'])) {
							array_push($autoSetVal, $_POST['autoWaterPer']);
							array_push($autoSetName, "Water-Frequency");
						}

						$implodedAutoSetName = implode(" ", $autoSetName);
						$implodedAutoSetVal = implode(" ", $autoSetVal);


						if(!empty(($autoArea) && !empty($autoSetName))) {
							system("./driver setAuto '$autoArea' $implodedAutoSetName $implodedAutoSetVal");
							system("./driver readAutoStatus '$autoArea' $implodedAutoSetName");

							$file = fopen(".readAutoStatus.txt", "r");
							$returnedReadAutoStatus = fgetcsv($file);
							$N = count($autoSetName);
	
							echo('<fieldset><legend><span class="alert">' .$autoArea. ' New Auto Setting</span></legend>');
							for($i = 0; $i < $N; $i++) {
								echo($autoSetName[$i] . ": <b>" . $returnedReadAutoStatus[$i] . "</b><br>");
							}
							echo("</fieldset>");
						}
					?>
				</td>
				</tr>
				<tr>
				<td>
					<fieldset><legend>Manual Control</legend>
						<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
							House <select name="manArea" id="number">
								<option value=""></option>
								<option value="House 1">1</option>
								<option value="House 2">2</option>
							</select><br /><br />
							<table align="center">
							<tr><th></th></tr>
							<tr><td valign="top">Light </td>
							<td><select name="manLight" id="number">
								<option value=""></option>
								<option value="on">ON</option>
								<option value="off">OFF</option>
							</select><br /><br /></td></tr>
							<tr><td valign="top">Heat </td>
							<td><select name="manHeat" id="number">
								<option value=""></option>
								<option value="on">ON</option>
								<option value="off">OFF</option>
							</select><br /><br /></td></tr>
							<tr><td valign="top">Vent </td>
							<td><select name="manVent" id="number">
								<option value=""></option>
								<option value="open">OPEN</option>
								<option value="shut">SHUT</option>
							</select><br /><br /></td></tr>
							<tr><td valign="top">Fog </td>
							<td><select name="manFog" id="number">
								<option value=""></option>
								<option value="on">ON</option>
								<option value="off">OFF</option>
							</select><br /><br /></td></tr>
							<tr><td valign="top">Water </td>
							<td><select name="manWater" id="number">
								<option value=""></option>
								<option value="off">OFF</option>
								<option value="low">LOW</option>
								<option value="medium">MEDIUM</option>
								<option value="high">HIGH</option>
							</select><br /><br /></td></tr>
							</table>
							<input type="submit" name="set" value="SET" />
						</form>
					</fieldset>
				</td>
				</tr>
				<tr>
				<td>
					<?php
						$manArea = $_POST['manArea'];
						$manSetVal = array();
						$manSetName = array();

						if(!empty($_POST['manLight'])) {
							array_push($manSetVal, $_POST['manLight']);
							array_push($manSetName, "Light");
						}
						if(!empty($_POST['manHeat'])) {
							array_push($manSetVal, $_POST['manHeat']);
							array_push($manSetName, "Heat");
						}
						if(!empty($_POST['manVent'])) {
							array_push($manSetVal, $_POST['manVent']);
							array_push($manSetName, "Vent");
						}
						if(!empty($_POST['manFog'])) {
							array_push($manSetVal, $_POST['manFog']);
							array_push($manSetName, "Fog");
						}
						if(!empty($_POST['manWater'])) {
							array_push($manSetVal, $_POST['manWater']);
							array_push($manSetName, "Water");
						}

						$implodedManSetName = implode(" ", $manSetName);
						$implodedManSetVal = implode(" ", $manSetVal);


						if(!empty(($manArea) && !empty($manSetName))) {

//echo("manArea: " . $manArea . " setNames: " . $implodedManSetName . " setVals: " .$implodedManSetVal . " ");
							system("./driver setMan '$manArea' $implodedManSetName $implodedManSetVal");
							system("./driver readStatus '$manArea' $implodedManSetName");
							$file = fopen(".readStatus.txt", "r");
							$returnedStatus = fgetcsv($file);
							$N = count($manSetName);

							echo('<fieldset><legend><span class="alert">' .$manArea. ' Current Status</span></legend>');
							for($i = 0; $i < $N; $i++) {
								echo($manSetName[$i] . ": <b>" . $returnedStatus[$i] . "</b><br>");
							}
							echo("</fieldset>");
						}
					?>
				</td>
				</tr>
			</table>
		</td>
	</table>
	<br><br><a href="index.php">[HOME]</a>
	</body>
</html>
