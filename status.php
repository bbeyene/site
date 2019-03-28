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

$ip = $_SERVER["REMOTE_ADDR"];
system("./record $ip status");

header("Cache-Control: no-store, must-revalidate, max-age=0");
header("Cache-Control: post-check=0", false);
header("Pragma: no-cache");


?>

<!doctype html>
<html>
	<head>
		<title>Status</title>
		<meta http-equiv="pragma" content="no-cache" />
		<meta http-equiv="robots" content="noindex" />
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	<body>
	<table>
		<tr>
		<td>
<a class="weatherwidget-io" href="https://forecast7.com/en/45d52n122d99/hillsboro/?unit=us" data-label_1="OUTSIDE" data-label_2="HILLSBORO" data-font="Helvetica" data-mode="Current" data-theme="pure" >OUTSIDE HILLSBORO</a><script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://weatherwidget.io/js/widget.min.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","weatherwidget-io-js");</script>
		</td>
		</tr>
		<tr>
			<td>
					<fieldset><legend>Current Status</legend>
					<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
					House <select name="area" required>
						<option value=""></option>
						<option value="House 1" <?php if($_POST["area"] == "House 1") {echo 'selected';}?>> 1 </option>
						<option value="House 2" <?php if($_POST["area"] == "House 2") {echo 'selected';}?>> 2 </option>
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
		<td>
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
			<td>
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
		<td>
			<br>

			<?php 
			if($area == "House 1") {
				echo('<legend>(not yet) Live Image<figure><img src="images/gh2.jpg" /></figure></legend>');
			} 
			else if($area == "House 2") {
				echo('<legend>(not yet) Live Image<figure><img src="images/gh1.jpg" /></figure></legend>');
			}
			?>
		</td>
		</tr>
	</table>
	</body>
</html>
