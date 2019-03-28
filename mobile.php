<?php
function isChecked($checkName, $value) {
	if(!empty($_POST[$checkName])) {
		foreach($_POST[$checkName] as $checkValue) {
			if($checkValue == $value) {
				return true;
			}
		}
	}
	return false;
}
<?php
$ip = $_SERVER["REMOTE_ADDR"];
system("./record $ip mobile");

header("Cache-Control: no-store, must-revalidate, max-age=0");
header("Cache-Control: post-check=0", false);
header("Pragma: no-cache");

?>

<!doctype html>
<html>
	<head>
		<title>Mobile</title>
		<meta http-equiv="pragma" content="no-cache" />
		<meta http-equiv="robots" content="noindex" />
		<meta name="viewport" content="width=device-width" initial-scale="1.0">
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	<body>
	<table align="center">
		<tr>
		<td halign="center">
<a class="weatherwidget-io" href="https://forecast7.com/en/45d52n122d99/hillsboro/?unit=us" data-label_1="OUTSIDE" data-label_2="HILLSBORO" data-font="Helvetica" data-mode="Current" data-theme="pure" >OUTSIDE HILLSBORO</a><script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://weatherwidget.io/js/widget.min.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","weatherwidget-io-js");</script>
		</td>
		</tr>
		<tr>
			<td halign="center">
					<fieldset><legend>Current Status</legend>
					<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
					House <select name="area" required>
						"<option value=""></option>
						"<option value="House 1" <?php if($_POST["area"] == "House 1") {echo 'selected';}?>> 1 </option>
						"<option value="House 2" <?php if($_POST["area"] == "House 2") {echo 'selected';}?>> 2 </option>
					</select><br><br>
					<table align="center">
					<tr><th></th><th></th></tr>
					<tr><td width="150">
					<label class="container">Temperature
					<input id="temperature" type="checkbox" name="status[]" value="Temperature" <?php if(isChecked('status', 'Temperature')) {echo 'checked';}?>/>
					<span class="checkmark"></span></label><br><br>
					<label class="container">Humidity
					<input id="humidity" type="checkbox" name="status[]" value="Humidity" <?php if (isChecked('status', 'Humidity')) {echo 'checked';}?> />
					<span class="checkmark"></span></label><br><br>
					<label class="container">Light
					<input id="light" type="checkbox" name="status[]" value="Light" <?php if (isChecked('status', 'Light')) {echo 'checked';}?> />
					<span class="checkmark"></span></label><br><br>
					<label class="container">Door
					<input id="door" type="checkbox" name="status[]" value="Door" <?php if (isChecked('status', 'Door')) {echo 'checked';}?> />
					<span class="checkmark"></span>	</label><br><br>
					</td>
					<td width="150">
					<label class="container">Vent
					<input id="vent" type="checkbox" name="status[]" value="Vent" <?php if (isChecked('status', 'Vent')) {echo 'checked';}?> />
					<span class="checkmark"></span></label><br><br>
					<label class="container">Heat
					<input id="heat" type="checkbox" name="status[]" value="Heat" <?php if (isChecked('status', 'Heat')) {echo 'checked';}?> />
					<span class="checkmark"></span></label><br><br>
					<label class="container">Fog
					<input id="fan" type="checkbox" name="status[]" value="Fog" <?php if (isChecked('status', 'Fog')) {echo 'checked';}?> />
					<span class="checkmark"></span></label><br><br>
					<label class="container">Water
					<input id="water" type="checkbox" name="status[]" value="Water" <?php if (isChecked('status', 'Water')) {echo 'checked';}?> />
					<span class="checkmark"></span></label><br><br>
					</td></tr>
					</table>
					

					<input type="submit" name="view" value="VIEW" />
					</form>
				</fieldset>
			</td>
		</tr>

		<tr>
		<td halign="center">
			<br>
			<?php
				$area = $_POST['area'];
				$status = $_POST['status'];
				$implodedStatus = implode(" ", $status);
				$autoStatus = array("Preset-Temperature", "Preset-Humidity", "Light-Duration", "Water-Amount", "Water-Frequency");
				$implodedAutoStatus = implode(" ", $autoStatus);

				if (($area) && ($status)){
					system("./driver readStatus '$area' $implodedStatus");

					$file = fopen(".readStatus.txt", "r");
					$returnedReadStatus = fgetcsv($file);
					$N = count($status);

					echo('<fieldset><legend>' . $area . ' Current Status</legend>');
					for($i = 0; $i < $N; $i++) {
						echo($status[$i] . ": <b>" . $returnedReadStatus[$i] . "</b><br>");
					
					}
					echo("</fieldset>");
				}
			?>
		</td>
		</tr>
		<tr>
			<td halign="center">
				<br>
				<?php 
				if($area) {
					system("./driver readAutoStatus '$area' $implodedAutoStatus");

					$file = fopen(".readAutoStatus.txt", "r");
					$returnedReadAutoStatus = fgetcsv($file);
					$N = count($autoStatus);

					echo('<fieldset><legend>' . $area . ' Auto Setting</legend>');
					for($i = 0; $i < $N; $i++) {
						echo($autoStatus[$i] . ": <b>" . $returnedReadAutoStatus[$i] . "</b><br>");
					}
					echo("</fieldset>");
				}
				?>
		</td>
		</tr>

		<tr>
		<td halign="center">
			<br>

			<?php 
			if($area == "House 1") {
				echo('<legend>Live Image<figure><img src="images/gh2.jpg" /></figure></legend>');
			} 
			else if($area == "House 2") {
				echo('<legend>Live Image<figure><img src="images/gh1.jpg" /></figure></legend>');
			}
			?>
		</td>
		</tr>
		<tr>
		<td halign="center">
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
								<option value="1">LOW</option>
								<option value="2">MEDIUM</option>
								<option value="3">HIGH</option>
							</select> 
							Per <select name="autoWaterPer">
								<option value=""></option>
								<option value="1">Day</option>
								<option value="2">Week</option>
							</select><br /><br /></td></tr>
							</table>
							<input type="submit" name="set" value="SET" />
						</form>
					</fieldset>
			</td>
			</tr>

			<tr>
			<td halign="center">
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
			<td halign="center">
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
								<option value="0">OFF</option>
								<option value="1">LOW</option>
								<option value="2">MEDIUM</option>
								<option value="3">HIGH</option>
							</select><br /><br /></td></tr>
							</table>
							<input type="submit" name="set" value="SET" />
						</form>
					</fieldset>
			</td>
			</tr>
			<tr>
			<td halign="center">
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
						if($_POST['manWater'] != "") {
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
	</body>
</html>
