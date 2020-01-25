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
  
