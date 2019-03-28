<!doctype html>

<?php
$ip = $_SERVER["REMOTE_ADDR"];
system("./record $ip ghschedule");

header("Cache-Control: no-store, must-revalidate, max-age=0");
header("Cache-Control: post-check=0", false);
header("Pragma: no-cache");
?>


<html>
	<head>
		<title>Greenhouse Schedule</title>
		<meta http-equiv="pragma" content="no-cache" />
		<meta http-equiv="robots" content="noindex" />
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	<body>
		<table>
			<tr>	<th></th>
				<th>Step 0</th>
				<th>Step 1</th>
				<th>Step 2</th>
				<th>Step 3</th>
				<th>Step 4</th>
			</tr>
			<tr><th>Equipment</th>
				<td>
					<ol><b>
						<li>Raspberry Pi</li>
						<li>Arduino</li>
						<li>Peripherals</li>
						<ul>
							<li>Motors</li>
							<li>Sensors</li>
							<li>Lights</li>
							<li>Components, etc</li>
						</b></ul>
					</ol>
				</td>
				<td>
					<ul>
						<li>Materials and Components</li>
					</ul>
				</td>
				<td>
					<ul>
						<li>Greenhouse Construction Materials</li>
					</ul>
				</td>
				<td></td>
				<td>
					<ul>
						<li>Professional Grade Components</li>
					</ul>
				</td>
			</tr>
			<tr><th>Learn</th>
				<td>
					<ol>
						<li><b>Greenhouse (function and architecture)</b></li>
						<li>R-Pi Programming (python)</li>
						<li><b>Arduino programming</b></li>
						<li><b>C++ windows & unix serial COM</b></li>
						<li><i>Electronics</i></li>
						<ul>
							<li><i>Power Supply</i></li>
						</ul>
					</ol>
				</td>
				<td>
					<ul>
						<li><b>How to Construct Greenhouse</b></li>
						<li><b>PHP</b></li>
						<li><b>CSS</b></li>
					</ul>
				</td>
				<td>
					<ul>
						<li>How to Solder</li>
						<li>JavaScript</li>
						<li>SQL</li>
					</ul>
				</td>
				<td>
					<ol>
						<li>Desktop dev (Java/Python)</li>
						<li>Android dev</li>
						<li>iOS dev</li>
					</ol>
				</td>
				<td>
					<ul>
						<li>Scalable App</li>
					</ul>
				</td>
			</tr>
			<tr><th>Build</th>
				<td>
					<ul>
						<li><b>Server</b></li>
					</ul>
				</td>
				<td>
					<ul>
						<li><b>Breadboard</b></li>
						<li><i>Table-top Prototype</i></li>
					</ul>
				</td>
				<td>
					<ul>
						<li>Greenhouse</li>
						<li>Solder R-Pi Zero</li>
						<li>Solder Arduino Mini</li>
						<li>Control Box</li>
					</ul>
				</td>
				<td></td>
				<td>
					<ul>
						<li>Stand-alone Control Box</li>
					</ul>
				</td>
			</tr>
			<tr><th>Program</th>
				<td>
					<ul>
						<li><b>App (demo version)</b></li>
					</ul>
				</td>
				<td>
					<ol>
						<li><b>Arduino</b></li>
						<li><b>Arduino to R-Pi</b></li>
						<li><b>Command Line Interface</b></li>
						<li><b>Browser Interface</b></li>
					</ol>
				</td>
				<td></td>
				<td>
					<ol>
						<li>Desktop App</li>
						<li>Android App</li>
						<li>iOS App</li>
					</ol>
				</td>
				<td>
					<ul>
						<li>Pairable Software/Hardware Package</li>
					</ul>
				</td>
			</tr>

		</table>
	</body>
</html>
