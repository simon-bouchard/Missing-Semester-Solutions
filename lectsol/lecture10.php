<!DOCTYPE html>
<html>

<head>

<title>'Lecture 10 | Missing Semester Solutions'</title>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel="stylesheet" href="../styles/lecture.css">
</head>

<body class=lecture>

	<h3><a href="https://missing.csail.mit.edu/2020/potpourri/" target="_blank">Lecture 10</a></h3>
	<p>As promised here are the extra exercises for lecture 10. However no solutions will be provided for these exercises (no particular reason, I just don't feel like it).</p>
	<ol class=lectlist>

		<li>
			<h6>Keyboard remapping</h6>
			Set up basic keyboard remapping, like rerouting Caps Lock to &lt;esc&gt; if you plan to continue using vim. If you are on windows you can use <a href='https://github.com/randyrants/sharpkeys/releases' target=_blank>Sharpkeys</a> or <a href='https://www.autohotkey.com/' target=_blank'>AutoHotkey</a> (the latter also allows to disable caps lock light).
		</li>

		<li>
			<h6>Backups & Booting + Live USBs</h6>
			Backup your computer in the cloud and if youre really confident, wipe out your whole computer and boot it with a live usb key (ideally prepared in advance if you only have one computer). Reinstall your computer set up from your cloud backup.
		</li>

		<li>
			<h6>Cron Jobs</h6>
			Create a simple <a href='https://www.man7.org/linux/man-pages/man8/cron.8.html' target=blank>cron</a> job that runs a script every hour to check disk usage and logs the output. Alternatively you can write a job to back up a specific folder daily.
		</li>

		<li>
			<h6>APIs</h6>
			Create a simple app using an API. Could be the weather app suggested in the lecture or something more complicated.
		</li>

		<li>
			<h6>Github</h6>
			Get your first contribution by forking this website's repository and making a pull request.
		</li>

		<li>
			<h6>Notebook Programming</h6>
			If you've never used Jupyter Notebooks or similar tools, familiarize yourself with it by creating your first Jupyter Notebook. It could be something very simple like creating a plot from a dataset.
		</li>

		<li>
			<h6>Docker, Vagrant, VMs, Cloud, OpenStack</h6>
			Cloud VMs are the future! Get a virtual machine from the cloud. You can use <a href='https://www.oracle.com/cloud/free/' target=blank>Oracle Cloud's always free tier</a> or whichever one you want. Try setting up a server for a basic application. Reproduce the server's set up on Docker or Vagrant for easy local testing and collaboration. For example you could set up a LAMP server hosting a website showing your solution's to the Missing Solutions extra exercises!
		</li>
	</ol>

<?php include '../partials/lectNav.php'; ?>

<script src='../js/lectureNav.js'></script>
		
<script src='../js/copyButton.js'></script>

</body>
</html>
