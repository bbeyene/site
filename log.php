<!doctype html>
<?php
$ip = $_SERVER["REMOTE_ADDR"];
system("./record $ip log");

header("Cache-Control: no-store, must-revalidate, max-age=0");
header("Cache-Control: post-check=0", false);
header("Pragma: no-cache");

?>

<html>
	<head>
		<title>Log</title>
		<meta http-equiv="pragma" content="no-cache" />
		<meta http-equiv="robots" content="noindex" />
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	<body>
		<h3>Log</h3>
	<h4></h4>
	<p>I wanted to play with a Raspberry Pi and/or Arduino so I looked for a problem to solve. I have no experience with electronics or microcontrollers but 
	I'm trying to apply what I've learned in CS classes to some physicsal system. Many of the kits that come with Raspberry Pi's and Arduinos 
	include sensors, motors, L.E.D.s, etc, and are as one hobbiest on YouTube noted, "solutions looking for problems."</p>
	<p>My starting off point was unoriginal given that there are many greenhouse controller projects out there. So I tried to add other challenges and learning 
	opportunities to the idea. Their projects often use LCD screens and push-buttons, have an unfriendly user interface and require some sort of physical interaction 
	with the components. My plan was to have a web interface and a desktop and/or iOS/Android app to monitor and run tasks or set presets. I didn't know about different 
	menthods to remotely control an Arduino and/or components and when I found that I needed more componets to read from analog devices (an ADC) I decided to use the R.Pi as a 
	server. This has the added benefit of remote connection AND reprogramming (uploading new sketches) from anywhere through ssh.</p>
	<p>I've since learned that there is a wi-fi module (esp8266) that can be used on its own or with existing Arduinos. A future iteration will use an 
	Arduino Nano with such a node, or with the Pi Zero. Currently the Pi is a server - emulating how a VPS would communicate with the Arduino.</p>
	<p>This project is somewhere in between an Arduino hobby garden and a full climate control system that's very customizable but user friendly.</p><br>
	<p><em>The "current status" on the left is at the moment stationed in a bedroom - it gets sensor and relay readings. Presets and controls are available when logged in 
	on the home page.</em></p>
	<br><hr /><br>
	<p>There are several ways to interface:
	<ol>
		<li>The Arduino's Serial Monitor</li>
		<li>From a shell (command line) on the Raspberry Pi</li>
		<li>From the website</li>
	</ol></p>
	<figure><img src="images/diagram.png" /></figure>
	<br><p>The app is complete but written procedurally so it may/may not be easy to follow. Spagetti code but more like uncooked spagetti still in its package.
	Object-oriented version coming soon.</p>
	<iframe src="/code/main.html" width="1200" height="800" frameborder="0" scrolling="yes"></iframe>
	<br><br>
	<p>It runs with one of the follwing arguments
		<ul><li>Read Status</li>
		<li>Read Presets</li>
		<li>Set Presets</li>
		<li>Manual Operation</li>
		<li>Schedule</li></ul></p>
	<p>I put a lot of thought into different cases and combinations to make sure that there were no contridictions. For example:
	<ul>
	<li>What happens when there are presets but you want to turn on a component</li>
	<li>The state after a power failure</li>
	<li>Conflicts between one climate variable and another</li></ul></p>
	<br><hr /><br>
	<p>Instead of sending 1's and 0's to the Arduino which then sets the relays, I experimented with sending a base-256 integer similar to how linux file permissions are set.</p>
	<p>With linux file permissions,
	<li>None: 0</li>
	<li>Read: 1</li>
	<li>Write: 2</li>
	<li>Execute: 4</li>
	Then you add each option. So to give a user all three, you call "chmod 7 file_name". Each integer is a unique combination of read, write and execute.</p>
	<p>That's in base-8 (2^3 options). Since I have 8 relay switches, an integer between 0 and 255 uniquely determines a configuration (2^8) thus base-256.
	<li>For OFF, OFF, OFF, OFF, ON, ON, ON, ON - that number is (0)+(0)+(0)+(0)+(2^3)+(2^2)+(2^1)+(2^0) = 15</li>
	<li>For on, on, on, on, off, off, off, off - that number is (2^7)+(2^6)+(2^5)+(2^4)+(0)+(0)+(0)+(0) = 240</li>
	Furthermore, since the first 4 relays control the first house and the last 4 the second house while the app executes on one house at a time...</p>
	<p>only the four least significant bits are set, then passed to the Arduino after being left shifted by ((the number of the house - 1) * 4)
	<li>If it's the first house and we want to turn on all 4 relays, send "15" as is.</li>
	<li>If it's the second house and we want to turn on all 4 relays, send "240" = 15 &lt;&lt; 4</li></p>
	<p>While this reduces the number of if-else statements in the main program and would make the switch-case statements in the Arduino code unnecessary, it is more complicated to 
	debug so I just send strings of 1's and 0's.</p>
	<br><hr /><br>
	<p>Here's the overly specific light algorithm:</p>
	<pre><code>
Suppose:
date: 07/01/2018
light duration = 13 hrs
light needed before and after noon: (13 / 2) = 6.5 hrs
Use solar noon: 1:14pm, instead of mean noon: 12:00pm
begin light sensing at solar noon - duration/2 needed: (1:14pm) - 6.5 hrs = 6:44am
end light sensing at solar noon + duration/2 needed: (1:14pm) + 6.5 hrs = 7:44pm

Reason 1: solar noon window varies 28 mins

sun: 5:30am to 9:00pm
Using mean noon: 5:30am to 6:30pm
Versus solar noon: 6:44am to 7:44pm
 

Reason 2: daylight savings varies 1 hour

March 10 
(before daylight savings)
Solar noon: 12:20pm
Sun: 6:30am to 6:10pm
Using mean noon: 5:30am to 6:30pm
Using solar noon & DST: 5:50pm to 6:50pm

March 11 
(during daylight savings)
Solar noon: 12:20pm
Sun: 7:30am to 7:10pm
Using mean noon: 5:30am to 6:30pm
Using solar noon & DST: 6:50am to 7:50pm
	</code></pre>
	<p>Solar data sourced from dateandtime.com. Every plant has the right and privilege of consistent and predictable light 
	not based on timezones or debatable macroeconomic constructs.</p><p>Time that could have been put to other use = ~11 hours</p>
	<br><hr /><br>
	<p>Arduino sketch:</p>
	<iframe src="/code/arduino.html" width="1200" height="800" frameborder="0" scrolling="yes"></iframe>
	<br><br><br><hr /><br><br><br><br>
	<iframe src="ghschedule.php" width="1200" height="1200" frameborder="0" scrolling="no"></iframe>
	</body>
</html>
