<!DOCTYPE html>
<html>

<head>

<title>'Lecture 2'</title>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel="stylesheet" href="../styles/lecture.css">
</head>

<body class=lecture>

	<h3><a href="https://missing.csail.mit.edu/2020/shell-tools/" target="_blank">Lecture 2</a></h3>
	<ol class=lectlist>
		<li><p>Read <code><a href='https://www.man7.org/linux/man-pages/man1/ls.1.html' target='_blank'>man ls</a></code> and write an <code>ls</code> command that lists files in the following manner</p>
			<ul>
				<li>Includes all files, including hidden files</li>
				<li>Sizes are listed in human readable format (e.g. 454M instead of 454279954)</li>
				<li>Files are ordered by recency</li>
				<li>Output is colorized</li>
			</ul>
			<p>A sample output would look like this</p>
			<div class=instcode><pre>-rw-r--r--   1 user group 1.1M Jan 14 09:53 baz
drwxr-xr-x   5 user group  160 Jan 14 09:53 .
-rw-r--r--   1 user group  514 Jan 14 06:42 bar
-rw-r--r--   1 user group 106M Jan 13 12:12 foo
drwx------+ 47 user group 1.5K Jan 12 18:08 ..</pre>
			</div>

			<div class=inst>
				<p><code>-l</code> for the long listing format</p>
				<p><code>-a</code> to include all files</p>
				<p><code>-h</code> for human readable format</p>
				<p><code>-t</code> to sort by recency</p>
				<p><code>--color=auto</code> to color the output if going to the terminal</p>
				<div class="code-container"><code class=in>ls -laht --color=auto</code>
						<button class="copy">copy</button>

						<li><p>Write bash functions <code>marco</code> and <code>polo</code> that do the following. Whenever you execute <code>marco</code> the current working directory should be saved in some manner, then when you execute <code>polo</code>, no matter what directory you are in, <code>polo</code> should cd you back to the directory where you executed <code>marco</code>. For ease of debugging you can write the code in a file <code>marco.sh</code> and (re)load the definitions to your shell by executing <code>source marco.sh</code>.</p>
							<div class="inst"><div class=code-container><div class=file-cont><p class=codehead>marco_polo.sh</p><code class="file"><pre>#!/usr/bin/bash

function marco() {
	#Save current directory in global variable
	export MARCO_DIR=$(pwd)
}

function polo() {
	#Verify if there is a saved directory
	if [ -z "$MARCO_DIR" ]; then
		echo "No directories saved, please run 'marco' first."

	else
		#Change directory and display error message if failed
		cd $MARCO_DIR || echo "Failed to change directory to $MARCO_DIR"
	
	fi
}
											</pre></code></div>
					<button class="copy">Copy</button></div>
				<p>Marco assigns the current directory to a variable using export to ensure the variable has environment scope.</p>
				<p>Polo first verifies if there is a directory stored (-z verifies if a value is empty).</p> 
				<p>It then changes the directory and displays a message if it fails with <code>||</code></p></div>
				</li>

			<li>	<p>Say you have a command that fails rarely. In order to debug it you need to capture its output but it can be time consuming to get a failure run. Write a bash script that runs the following script until it fails and captures its standard output and error streams to files and prints everything at the end. Bonus points if you can also report how many runs it took for the script to fail.</p>
				<div class=instcode><pre>#!/usr/bin/env bash

n=$(( RANDOM % 100 ))

if [[ n -eq 42 ]]; then
	echo "Something went wrong"
	>&2 echo "The error was using magic numbers"
	exit 1
fi

echo "Everything went according to plan"</pre></div>

					<div class="inst"><div class=code-container><div class=file-cont><p class=codehead>run_until_fail</p><code class=file><pre>#!/usr/bin/bash

#To create and clear the files
> output.log
> error.log

#initialise counter
count=0

#infinite while loop
while true; do

	#increment count
	count=$((count + 1))

	#execute script and put output and error in files
	./script.sh >> output.log 2>> error.log

	#break from while loop if exit code  is not 0
	if [[ $? -ne 0 ]]; then
		break
	fi
done

echo "The script failed after $count runs."

echo "Standard output:"
cat output.log

echo "Standard error:"
cat error.log
</pre></code></div>
						<button class=copy>Copy</button></div>
				Make both files executable:
				<div class=code-container><code class=in>chmod +x script.sh run_until_fail.sh</code>
						<button class="copy">Copy</button></div>
				Then run 
				<div class=code-container><code class=in>./run_until_fail</code>
						<button class="copy">Copy</button></div>
				<p class=codehead>Terminal output:</p><code class=out><pre>The script failed after 173 runs.
Standard output:
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Everything went according to plan
Something went wrong
Standard error:
The error was using magic numbers
</pre></code></div>
				
<li>	<p>As we covered in the lecture <code>find</code>’s <code>-exec</code> can be very powerful for performing operations over the files we are searching for. However, what if we want to do something with all the files, like creating a zip file? As you have seen so far commands will take input from both arguments and STDIN. When piping commands, we are connecting STDOUT to STDIN, but some commands like <code>tar</code> take inputs from arguments. To bridge this disconnect there’s the <code><a href=https://www.man7.org/linux/man-pages/man1/xargs.1.html target=_blank>xargs</a></code> command which will execute a command using STDIN as arguments. For example <code>ls | xargs rm</code> will delete the files in the current directory.</p>
	<p>Your task is to write a command that recursively finds all HTML files in the folder and makes a zip with them. Note that your command should work even if the files have spaces (hint: check <code>-d</code> flag for <code>xargs</code>).</p>
	<p>If you’re on macOS, note that the default BSD <code>find</code> is different from the one included in <a href="https://en.wikipedia.org/wiki/List_of_GNU_Core_Utilities_commands" target=_blank>GNU coreutils</a>. You can use <code>-print0</code> on <code>find</code> and the <code>-0</code> flag on <code>xargs</code>. As a macOS user, you should be aware that command-line utilities shipped with macOS may differ from the GNU counterparts; you can install the GNU versions if you like by using brew.</p>
	
				<div class=instblock>
					<ol>
						<li>First you need to install zip if it isn't already done.
							<div class=code-container><div class="in"><code>sudo apt install zip</code></div>
						<button class="copy">Copy</button></div></li>	

						<li>Then you can run<div class=code-container><div class="in"><code>find . -name "*.html" -print0 | xargs -0 zip html_files.zip</code></div>
						<button class="copy">Copy</button></div>
							<p><code>find .</code> searches the current directory</p>
							<p><code>*.html</code> matches any file ending with .html</p>
							<p><code>-print0</code> and <code>-0</code> arguments handle whitespace in file names by seperating files with null characters which won't interfere with whitespace in file names</p></li>
					</ol>

			<li>	(Advanced) Write a command or script to recursively find the most recently modified file in a directory. More generally, can you list all files by recency?
				<div class="inst">
					
					<div class=code-container>
						<code class=in>find . -type f -exec stat --format="%Y %n" {} + | sort -n -r | head -n1 | sed 's/^[0-9]* //'</code>
								<button class="copy">Copy</button></div>
					<p><code>find . -type f -exec stat --format="%Y %n" {} +</code>: Finds all regular files recursively and prints the modification time followed by the file name.</p>
					<p><code>sort -n -r</code>: Sorts the files by modification time.</p>
					<p><code>head -n1</code>: Selects the first (most recently modified) file.</p>
					<p><code>sed 's/^[0-9]* //'</code>: Uses sed to remove the number (modification time in seconds) at the beginning of the line. The <code>^[0-9]*</code> matches the leading digits, and the space following removes the space between the time and the file name. You will learn more about sed in the upcomming lectures.</p>
				</div>
			</li>

		</ol>

<?php include '../partials/lectNav.php'; ?>

<script src='../js/lectureNav.js'></script>
		
<script src='../js/copyButton.js'></script>

</body>
</html>
