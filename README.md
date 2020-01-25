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

# Run application in browser

Hit the URL in browser: `http://localhost:8080`


# Console Command in terminal:

```
$ php bin/console identification-requests:process input.csv

*** input.csv file location is in :: src/AppBundle/Command/input.csv

```

# Auto-wiring 
```
$  php bin/console debug:autowiring
```

# Sample Data  ( code Level )
```
  $data['requestDate'] = $line[0]; //identification request date in format Y-m-d
  $data['countryCode'] = $line[1]; //identity document country code
  $data['documentType'] = $line[2]; //identity document type
  $data['documentNumber'] = $line[3]; //identity document number
  $data['issueDate'] = $line[4];  //identity document issue date in format Y-m-d
  $data['personalIdentificationNumber'] = $line[5]; //identity document owner's personal identification number
  
```
  
# PHP Unit TEST 

Pre-Requirement::
Make sure you have installed `phpunit` in you machine. I have install in my `OSX` by the following command:
```
$ brew install phpunit
```

# RUN PHPUNIT TEST
in terminal go to the project directory and run the following command
```
$ phpunit 

or 

$ phpunit tests/AppBundle/Directory__NAME/CLASS__NAME 
e.g. : $ phpunit tests/AppBundle/Controller
``` 


# Install PHPUNIT version 6.5 
```
$ wget https://phar.phpunit.de/phpunit-6.5.phar
$ chmod +x phpunit-6.5.phar
$ sudo mv phpunit-6.5.phar /usr/local/bin/phpunit
$ phpunit --version
```
