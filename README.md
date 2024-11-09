# missing-semester_solutions
Here is the repository for the missing solutions website
Feel free to contribute

##Set up a the docker to test the server on your own machine
First create the directory that will contain this repository (ex.: missing-solutions)
Then, clone this repository in that directory (git clone https://github.com/simon-bouchard/simon-bouchard.github.io)
After that, make create a directory called apache-config: mkdir apache-config
Cd in the repository, copy the files in docker in the repository's parent directory (missing-solutions): cp -r docker/\* .. (you must first cd in the repository)
Change the repository's (local) name to src: mv simon-bouchard.github.io src
Run the docker: docker-compose up --build
Finally, you can acces your local server on http://localhost:8000/ on a browser.
You can close the docker with ctrl-c.
After you have created the iso you only have to run: docker-compose up
