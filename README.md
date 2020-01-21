symfony34-docker
================

A Symfony project created on January 21, 2020, 4:07 pm.

# How to run #


* Make sure Docker engine is running   
and 
run the following command in your terminal
```
$ docker-compose up -d
```

Hit the URL in browser: `http://localhost:8080`



# Docker compose cheatsheet #

```
$ docker-compose up -d  // Start containers in the background

$ docker-compose up //Start containers on the foreground

$ docker-compose stop //Stop containers

$ docker-compose kill //Kill containers

$ docker-compose logs //View container logs

```

 #### Execute command inside of container: 
 
 ```
$ docker-compose exec SERVICE_NAME COMMAND

$ docker-compose exec php-fpm bash // PHP shell

$ docker-compose exec php-fpm bin/console //Runsymfony console 

$ docker-compose exec mysql mysql -uroot -pCHOSEN_ROOT_PASSWORD //open a mysql shell
```
 