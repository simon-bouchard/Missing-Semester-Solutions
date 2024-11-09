# The Missing Solutions Website
Here is the repository for the missing solutions website

Feel free to contribute

## Set up the docker to test the server on your own machine

* First create the directory that will contain this repository (ex.: missing-solutions)

* Then, clone this repository in that directory (git clone https://github.com/simon-bouchard/simon-bouchard.github.io)

* Cd to the repository and copy the files in docker in the repository's parent directory (missing-solutions): 

```bash
cp -r docker/* .. 
```


* Change the repository's (local) name to src: 

```bash
mv simon-bouchard.github.io src
```


* Run the docker: 

```bash
docker-compose up --build
```

* Finally, you can acces your local server on http://localhost:8000/ on a browser.

* You can close the docker with ctrl-c.

* After you have created the iso you only have to run: docker-compose up


