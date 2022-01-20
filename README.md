## Versions
Laravel 7.29
PHP 7.2.9

## Installation
- Clone repository
- composer update/install
- php artisan key:generate

## How it works
There is a new command ```php artisan plana:generate-files <type>```
That is developed in ```Console\Commands\GenerateFiles.php```

The command takes the configuration file from  ```config/generate.php``` and based on the config there
uses the templates stored in ```resources/templates/<type>``` it loads them, hydrates them and stores them
in ```App\<Type>```

The 2 examples types given are ```Models``` and ```Aplan```

In the config the developer can use the ```template``` field to set a specific template, 
otherwise the ```resources/templates/<type>/default.template``` is used

### Testing
Tests are located in ```tests/Unit```.

It is not 100% coverage, but it covers the general operation of the classes located in ```App/Generator```

To run the tests use ```vendor/bin/phpunit``` or ```php artisan test```

