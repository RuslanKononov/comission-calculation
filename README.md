# Comission Calculation

## Installation
### Build and run application
You can run it via command in shell
```
$ make start
```

## Tests
### UnitTests
To run unit tests please use
```
$ make test-unit
```

## Run & Use
To use this nano-service please do next:

1. Put the file `input.txt` or another file with JSON rows of transactions into directory
> \app\InputFileStorage\

2. To run the application you should run shell
```
$ make shell-run
```
3. after that you can put
```
$ php app.php input.txt
```
