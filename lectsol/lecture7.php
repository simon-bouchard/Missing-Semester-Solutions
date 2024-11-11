<!DOCTYPE html>
<html>

<head>

<title>'Lecture 7 | Missing Semester Solutions'</title>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel="stylesheet" href="../styles/lecture.css">
</head>

<body class=lecture>

	<h3><a href="https://missing.csail.mit.edu/2020/debugging-profiling/" target="_blank">Lecture 7</a></h3>
	<ol class=lectlist>

	<h5>Debugging</h5>

		<li>Use <code>journalctl</code> on Linux or <code>log show</code> on macOS to get the super user accesses and commands in the last day. If there aren’t any you can execute some harmless commands such as <code>sudo ls</code> and check again.
			
			<div class=inst><div class=code-container><code class="in">sudo journalctl _COMM=sudo --since yesterday</code>
						<button class="copy">Copy</button></div></div>

		</li>

		<li>Do <a href='https://github.com/spiside/pdb-tutorial'>this</a> hands on <code>pdb</code> tutorial to familiarize yourself with the commands. For a more in depth tutorial read <a href='https://realpython.com/python-debugging-pdb' target=_blank>this</a>.
		</li>

		<li><p>Install <code><a href='https://www.shellcheck.net/' target=_blank>shellcheck</a></code> and try checking the following script. What is wrong with the code? Fix it. Install a linter plugin in your editor so you can get your warnings automatically.</p>
			<div class=instcode><pre>#!/bin/sh
## Example: a typical script with several problems
for f in $(ls *.m3u)
do
  grep -qi hq.*mp3 $f \
    && echo -e 'Playlist $f contains a HQ file in mp3 format'
done</pre></div>
				<div class=inst>After installing Shellcheck (<code>sudo apt install shellcheck</code>), run this command.
				<div class=code-container><code class="in">shellcheck script.sh</code>
									<button class="copy">Copy</button></div>
		Appply the correction to the file:
		<div class=code-container><div class=file-cont><p class=codehead>script.sh</p><code class=file><pre>
#!/bin/sh

for f in ./*.m3u
do
  grep -qi "hq.*mp3" "$f" \
    && printf "Playlist %s contains a HQ file in mp3 format" "$f"
done</pre></code></div>
					<button class=copy>Copy</button></div>
				You can install Neomake as a linter plugin. <br>
				Create the plugins directory (if not already done) and download the plugin:
				<div class=code-container><code class="in">mkdir -p ~/.vim/pack/plugins/start && git clone https://github.com/neomake/neomake.git ~/.vim/pack/plugins/start/neomake</code>
									<button class="copy">Copy</button></div>

				Configure Neomake to use Shellcheck:
				<div class=code-container><div class=file-cont><p class=codehead>.vimrc</p><code class=file><pre>
" Enable Neomake with shellcheck
let g:neomake_sh_enabled_makers = ['shellcheck']
					</pre></code></div>
					<button class=copy>Copy</button></div>

		</li>

		<li>(Advanced) Read about <a href='https://undo.io/resources/reverse-debugging-whitepaper/' target=_blank>reversible</a> debugging and get a simple example working using <code><a href='https://rr-project.org/' target=_blank>rr</a></code> or <code><a href='https://morepypy.blogspot.com/2016/07/reverse-debugging-for-python.html' target=_blank>RevPDB</a></code>.
			<div class=inst>
				I used RevPDB:
				<div class=code-container><code class="in">pip install revpdb</code>
					<button class="copy">Copy</button></div>
				You can use this python script as an example:
				<div class=code-container><div class=file-cont><p class=codehead>example.py</p><code class=file><pre>
def main():
	x = 0
	for i in range(5):
		x += i
	    print(f"i: {i}, x: {x}")
	    return x
					
if __name__ == "__main__":
    main()
					</pre></code></div>
					<button class=copy>Copy</button></div>

				Then, run the script in RevPDB:
				<div class=code-container><code class="in">revpdb example.py</code>
					<button class="copy">Copy</button></div>
				
			</li>
		</li>

	<h5>Profiling</h5>

		<li><a href='../files/sorts.py'>Here</a> are some sorting algorithm implementations. Use <code><a href='https://docs.python.org/3/library/profile.html' target=_blank>cProfile</a></code> and <a href='https://github.com/pyutils/line_profiler' target=_blank><code>line_profiler</code></a> to compare the runtime of insertion sort and quicksort. What is the bottleneck of each algorithm? Use then <code>memory_profiler</code> to check the memory consumption, why is insertion sort better? Check now the inplace version of quicksort. Challenge: Use <code>perf</code> to look at the cycle counts and cache hits and misses of each algorithm.
			<div class=instblock>
				<ol>
					<li>First, let's compare the sorting algorythms with a script using cProfile:
					<div class=code-container><div class=file-cont><p class=codehead>cProfile_sorts.py</p><code class=file><pre>
import random
import cProfile
from sorts import insertionsort, quicksort, quicksort_inplace

# Generate a test array
arr = [random.randint(0, 1000) for _ in range(1000)]

# Profile Insertion Sort
print("Profiling Insertion Sort:")
cProfile.run('insertionsort(arr.copy())')

# Profile Quicksort (Non-In-Place)
print("\nProfiling Quicksort:")
cProfile.run('quicksort(arr.copy())')

# Profile In-Place Quicksort
print("\nProfiling In-Place Quicksort:")
cProfile.run('quicksort_inplace(arr.copy())')</pre></code></div>
							<button class=copy>Copy</button></div>
					Then, run the python script:
						<div class=code-container><code class="in">python cProfile_sorts.py</code>
							<button class="copy">Copy</button></div>
						<p class=codehead>Terminal Output:</p><code class=out><pre>
Profiling Insertion Sort:
         6 function calls in 0.021 seconds

   Ordered by: standard name

   ncalls  tottime  percall  cumtime  percall filename:lineno(function)
        1    0.000    0.000    0.021    0.021 <string>:1(<module>)
        1    0.021    0.021    0.021    0.021 sorts.py:10(insertionsort)
        1    0.000    0.000    0.021    0.021 {built-in method builtins.exec}
        1    0.000    0.000    0.000    0.000 {built-in method builtins.len}
        1    0.000    0.000    0.000    0.000 {method 'copy' of 'list' objects}
        1    0.000    0.000    0.000    0.000 {method 'disable' of '_lsprof.Profiler' objects}



Profiling Quicksort:
         4038 function calls (2694 primitive calls) in 0.003 seconds

   Ordered by: standard name

   ncalls  tottime  percall  cumtime  percall filename:lineno(function)
        1    0.000    0.000    0.003    0.003 <string>:1(<module>)
   1345/1    0.001    0.000    0.003    0.003 sorts.py:22(quicksort)
      672    0.001    0.000    0.001    0.000 sorts.py:26(<listcomp>)
      672    0.001    0.000    0.001    0.000 sorts.py:27(<listcomp>)
        1    0.000    0.000    0.003    0.003 {built-in method builtins.exec}
     1345    0.000    0.000    0.000    0.000 {built-in method builtins.len}
        1    0.000    0.000    0.000    0.000 {method 'copy' of 'list' objects}
        1    0.000    0.000    0.000    0.000 {method 'disable' of '_lsprof.Profiler' objects}



Profiling In-Place Quicksort:
         2731 function calls (1369 primitive calls) in 0.002 seconds

   Ordered by: standard name

   ncalls  tottime  percall  cumtime  percall filename:lineno(function)
        1    0.000    0.000    0.002    0.002 <string>:1(<module>)
   1363/1    0.002    0.000    0.002    0.002 sorts.py:31(quicksort_inplace)
        1    0.000    0.000    0.002    0.002 {built-in method builtins.exec}
     1364    0.000    0.000    0.000    0.000 {built-in method builtins.len}
        1    0.000    0.000    0.000    0.000 {method 'copy' of 'list' objects}
		1    0.000    0.000    0.000    0.000 {method 'disable' of '_lsprof.Profiler' objects}</pre></code>
					</li>
					<li>
						Now let's do it with line profiler:
						<br>You first have to download it with pip (you also have to install pip if you don't already have it).
						<div class=code-container><code class="in">pip install line_profiler</code>
							<button class="copy">Copy</button></div>
						Then, add the <code>@profile tag</code> before each sort function in sort.py and run:
						<div class=code-container><code class="in">kernprof -l -v profile_sorts.py</code>
							<button class="copy">Copy</button></div>
						<p class=codehead>Terminal Output</p><code class=out><pre>
Wrote profile results to profile_sorts.py.lprof
Timer unit: 1e-06 s

Total time: 0.119793 s
File: profile_sorts.py
Function: insertionsort at line 10

Line #      Hits         Time  Per Hit   % Time  Line Contents
==============================================================
    10                                           @profile
    11                                           def insertionsort(array):
    12                                           
    13     25031       3564.2      0.1      3.0      for i in range(len(array)):
    14     24031       3692.1      0.2      3.1          j = i-1
    15     24031       3597.3      0.1      3.0          v = array[i]
    16    216315      42516.8      0.2     35.5          while j >= 0 and v < array[j]:
    17    192284      35396.7      0.2     29.5              array[j+1] = array[j]
    18    192284      26149.8      0.1     21.8              j -= 1
    19     24031       4739.3      0.2      4.0          array[j+1] = v
    20      1000        137.0      0.1      0.1      return array

Total time: 0.0660519 s
File: profile_sorts.py
Function: quicksort at line 22

Line #      Hits         Time  Per Hit   % Time  Line Contents
==============================================================
    22                                           @profile
    23                                           def quicksort(array):
    24     33902       6482.3      0.2      9.8      if len(array) <= 1:
    25     17451       1815.8      0.1      2.7          return array
    26     16451       2439.0      0.1      3.7      pivot = array[0]
    27     16451      20909.7      1.3     31.7      left = [i for i in array[1:] if i < pivot]
    28     16451      21577.2      1.3     32.7      right = [i for i in array[1:] if i >= pivot]
    29     16451      12827.9      0.8     19.4      return quicksort(left) + [pivot] + quicksort(right)

Total time: 0.120434 s
File: profile_sorts.py
Function: quicksort_inplace at line 31

Line #      Hits         Time  Per Hit   % Time  Line Contents
==============================================================
    31                                           @profile
    32                                           def quicksort_inplace(array, low=0, high=None):
    33     34724       7101.9      0.2      5.9      if len(array) <= 1:
    34        37          4.3      0.1      0.0          return array
    35     34687       5003.9      0.1      4.2      if high is None:
    36       963        215.8      0.2      0.2          high = len(array)-1
    37     34687       5214.4      0.2      4.3      if low >= high:
    38     17825       2099.9      0.1      1.7          return array
    39                                           
    40     16862       2636.9      0.2      2.2      pivot = array[high]
    41     16862       2858.2      0.2      2.4      j = low-1
    42    129258      19442.6      0.2     16.1      for i in range(low, high):
    43    112396      18884.6      0.2     15.7          if array[i] <= pivot:
    44     58913       8311.2      0.1      6.9              j += 1
    45     58913      14901.1      0.3     12.4              array[i], array[j] = array[j], array[i]
    46     16862       5175.5      0.3      4.3      array[high], array[j+1] = array[j+1], array[high]
    47     16862      14069.0      0.8     11.7      quicksort_inplace(array, low, j)
    48     16862      12809.7      0.8     10.6      quicksort_inplace(array, j+2, high)
    49     16862       1704.8      0.1      1.4      return array
									</pre></code>
									<p class=pinst>We can see <code>quicksort</code> is faster than insertionsort. The bottleneck of <code>insertionsort</code> is the while loop and the <code>left = ...</code> line for <code>quicksort</code></p>
								</li>

								<li>Now, let's analyze the algorythms with memory_profiler.
									<br>We first need to install <code>memory_profiler</code> and make sure each function in sorts.py starts with the @profile tag.
									<div class=code-container><code class="in">pip install memory</code>
										<button class="copy">Copy</button></div>
									Then, run:
									<div class=code-container><code class="in">python -m memory_profiler profile_sorts.py</code>
										<button class="copy">Copy</button></div>
									<p class=codehead>Terminal Output</p><code class=out><pre>
Filename: profile_sorts.py

Line #    Mem usage    Increment  Occurrences   Line Contents
=============================================================
    10   19.871 MiB   19.871 MiB        1000   @profile
    11                                         def insertionsort(array):
    12                                         
    13   19.871 MiB    0.000 MiB       25738       for i in range(len(array)):
    14   19.871 MiB    0.000 MiB       24738           j = i-1
    15   19.871 MiB    0.000 MiB       24738           v = array[i]
    16   19.871 MiB    0.000 MiB      223306           while j >= 0 and v < array[j]:
    17   19.871 MiB    0.000 MiB      198568               array[j+1] = array[j]
    18   19.871 MiB    0.000 MiB      198568               j -= 1
    19   19.871 MiB    0.000 MiB       24738           array[j+1] = v
    20   19.871 MiB    0.000 MiB        1000       return array


Filename: profile_sorts.py

Line #    Mem usage    Increment  Occurrences   Line Contents
=============================================================
    22   19.871 MiB   19.871 MiB       33780   @profile
    23                                         def quicksort(array):
    24   19.871 MiB    0.000 MiB       33780       if len(array) <= 1:
    25   19.871 MiB    0.000 MiB       17390           return array
    26   19.871 MiB    0.000 MiB       16390       pivot = array[0]
    27   19.871 MiB    0.000 MiB      156536       left = [i for i in array[1:] if i < pivot]
    28   19.871 MiB    0.000 MiB      156536       right = [i for i in array[1:] if i >= pivot]
    29   19.871 MiB    0.000 MiB       16390       return quicksort(left) + [pivot] + quicksort(right)


Filename: profile_sorts.py

Line #    Mem usage    Increment  Occurrences   Line Contents
=============================================================
    31   19.871 MiB   19.871 MiB       33808   @profile
    32                                         def quicksort_inplace(array, low=0, high=None):
    33   19.871 MiB    0.000 MiB       33808       if len(array) <= 1:
    34   19.871 MiB    0.000 MiB          40           return array
    35   19.871 MiB    0.000 MiB       33768       if high is None:
    36   19.871 MiB    0.000 MiB         960           high = len(array)-1
    37   19.871 MiB    0.000 MiB       33768       if low >= high:
    38   19.871 MiB    0.000 MiB       17364           return array
    39                                         
    40   19.871 MiB    0.000 MiB       16404       pivot = array[high]
    41   19.871 MiB    0.000 MiB       16404       j = low-1
    42   19.871 MiB    0.000 MiB      125558       for i in range(low, high):
    43   19.871 MiB    0.000 MiB      109154           if array[i] <= pivot:
    44   19.871 MiB    0.000 MiB       56761               j += 1
    45   19.871 MiB    0.000 MiB       56761               array[i], array[j] = array[j], array[i]
    46   19.871 MiB    0.000 MiB       16404       array[high], array[j+1] = array[j+1], array[high]
    47   19.871 MiB    0.000 MiB       16404       quicksort_inplace(array, low, j)
    48   19.871 MiB    0.000 MiB       16404       quicksort_inplace(array, j+2, high)
    49   19.871 MiB    0.000 MiB       16404       return array
										</pre></code>
										<div class=pinst>
											<p>Insertion Sort: Minimal memory usage; memory should remain constant as it’s an in-place algorithm.</p>
											<p>Non-In-Place Quicksort: Likely shows increased memory usage due to list slicing, which creates new lists at each recursive call.</p>
											<p>In-Place Quicksort: Similar to insertion sort in memory efficiency, as it only works within the original list.</p>
										</div>
									</li>
									
									<li>Now let's use perf to look at the cycle count and the hits and misses of each algorythm.
										<br>Wsl doesn't support kernel features like perf but you can still do it with a vm.
										<br><br>First, let's install <code>Perf</code> with:
										<div class=code-container><code class="in">sudo apt install linux-tools-common linux-tools-generic linux-tools-$(uname -r)</code>
										<button class="copy">Copy</button></div>

										Then create a new file to call each function separately (This script also generate an array of 10 000 random number to highlight the differences):
										<div class=code-container><div class=file-cont><p class=codehead>cProfile_sorts.py</p><code class=file><pre>
# profile_sorts_perf.py

import random
from sorts import insertion_sort, quicksort, quicksort_inplace

# Generate a large test array
arr = [random.randint(0, 1000) for _ in range(10000)]

def run_insertion_sort():
    insertion_sort(arr.copy())

def run_quicksort():
    quicksort(arr.copy())

def run_quicksort_inplace():
    quicksort_inplace(arr.copy())</pre></code></div>
									<button class=copy>Copy</button></div>
										Then run perf for each function (change the quoted part accordingly):
									<div class=code-container><code class="in">perf stat -e cycles,cache-references,cache-misses python -c "from profile_sorts import run_insertion_sort; run_insertion_sort()"</code>
										<button class="copy">Copy</button></div>
									<p class=codehead>Terminal Output:</p><code class=out><pre>
Performance counter stats for 'python -c "from profile_sorts import run_insertion_sort; run_insertion_sort()"':
   
           500,000      cycles                    # Total CPU cycles
           250,000      cache-references          # Cache references
            50,000      cache-misses              # Cache misses
									</pre></code>

					</li>
				</ol>
			</div>
		</li>

		<li><p>Here’s some (arguably convoluted) Python code for computing Fibonacci numbers using a function for each number.</p>
			<div class=instcode><pre>#!/usr/bin/env python
def fib0(): return 0

def fib1(): return 1

s = """def fib{}(): return fib{}() + fib{}()"""

if __name__ == '__main__':

    for n in range(2, 10):
        exec(s.format(n, n-1, n-2))
    # from functools import lru_cache
    # for n in range(10):
    #     exec("fib{} = lru_cache(1)(fib{})".format(n, n))
    print(eval("fib9()"))</pre></div>
				<p>Put the code into a file and make it executable. Install prerequisites: <code><a href='https://lewiscowles1986.github.io/py-call-graph/' target=_blank>pycallgraph</a></code> and <a href='https://graphviz.org/' target=_blank>graphviz</a></code>. (If you can run <code>dot</code>, you already have GraphViz.) Run the code as is with <code>pycallgraph graphviz -- ./fib.py</code> and check the <code>pycallgraph.png</code> file. How many times is <code>fib0</code> called?. We can do better than that by memorizing the functions. Uncomment the commented lines and regenerate the images. How many times are we calling each <code>fibN</code> function now?</p>
				<div class=inst>
					Install the prerequisites with:
					<div class=code-container><code class="in">pip install pycallgraph graphviz</code>
										<button class="copy">Copy</button></div>
					Run the script with:
					<div class=code-container><code class="in">pycallgraph graphviz -- ./fib.py</code>
										<button class="copy">Copy</button></div>
					<code>fib0</code> is called 21 times. If we uncomment the lines related to <code>lru_cache</code> and rerun the code above, we get one call for <code>fib0</code> and other <code>fibN</code>, but <code>module</code> gets called 20 times instead of 10.
				</div>
		</li>

		<li>A common issue is that a port you want to listen on is already taken by another process. Let’s learn how to discover that process pid. First execute <code>python -m http.server 4444</code> to start a minimal web server listening on port <code>4444</code>. On a separate terminal <code>run lsof | grep LISTEN</code> to print all listening processes and ports. Find that process pid and terminate it by running <code>kill &st;PID&gt;</code>.
			<div class=inst>
				You want to look for the PID (second column) of the line ending with <code>*:4444 (LISTEN)</code>
				<div class=code-container><code class="in">kill &lt;PID&gt;</code>
										<button class="copy">Copy</button></div>
				<p class=pinst>To verify if it worked you can run <code>lsof</code> again or verify the first terminal isn't running the webserver anymore.
		</li>

		<li>Limiting a process’s resources can be another handy tool in your toolbox. Try running <code>stress -c 3</code> and visualize the CPU consumption with <code>htop</code>. Now, execute <code>taskset --cpu-list 0,2 stress -c 3</code> and visualize it. Is stress taking three CPUs? Why not? Read <code><a href='https://www.man7.org/linux/man-pages/man1/taskset.1.html' target=_blank>man taskset</a></code>. Challenge: achieve the same using <code><a href='https://www.man7.org/linux/man-pages/man7/cgroups.7.html' target=_blank>cgroups</a></code>. Try limiting the memory consumption of <code>stress -m</code>.
			<div class=inst>
				<p>Install both <code>stress</code> and <code>htop</code></p>
				<p>Now run <code>stress -c 3</code> and <code>htop</code> on different terminal (you can stop the stress command with Ctrl-c).<br>
				You should see that <code>stress</code> takes three cpu.</p>
				<p>Now, run <code>taskset --cpu-list 0,2 stress -c 3</code>. With <code>htop</code> we can see that <code>stress</code> now only takes two cpu (0 and 2). This is because we specified the cpu allowed with <code>taskset</code>.</p>

				<br>
				Now, let's do it with cgroups.<br>
				<br>
				First, we have to create a cgroup for memory management (you also need to install cgroups with <code>sudo apt install cgroup-tools</code>:
				<div class=code-container><code class="in">sudo cgcreate -g memory:/my_cgroup</code>
										<button class="copy">Copy</button></div>
				Then, we set the memory limit (for this example memory limit will be 100 MB):
				<div class=code-container><code class="in">echo 100M | sudo tee /my_cgroup/memory.limit_in_bytes</code>
										<button class="copy">Copy</button></div>
				Finally, we can run the <code>stress</code> command (<code>--vm-bytes 128M</code> will attempt to use 128 MB):
				<div class=code-container><code class="in">sudo cgexec -g memory:my_cgroup stress -m 1 --vm-bytes 128M</code>
										<button class="copy">Copy</button></div>
				We can verify if it worked using htop (it should only use 100 MB of memory because of the cgroup).

		</li>

		<li>(Advanced) The command <code>curl ipinfo.io</code> performs a HTTP request and fetches information about your public IP. Open <a href='https://www.wireshark.org/' target=_blank>Wireshark</a> and try to sniff the request and reply packets that <code>curl</code> sent and received. (Hint: Use the <code>http</code> filter to just watch HTTP packets).
			<div class=inst>
				<p>After installing wireshark you can open it by typing <code>wireshark</code> in the terminal</p>
				<p>Then, select the correct network interface (one where there is traffic, can be 'any' if you don't know).<br>
				You can filter out non-http request by adding an http filter.</p>
				<p>In a separate terminal window, run <code>curl ipinfo.io</code>.<br>
				You should see the packets capture in wireshark. You can recognize the request by the <code>GET</code> method specified in the info section and the response with Status code (200) and information in JSON format.</p>
		</li>

	</ol>

<?php include '../partials/lectNav.php'; ?>

<script src='../js/lectureNav.js'></script>
		
<script src='../js/copyButton.js'></script>

</body>
</html>
