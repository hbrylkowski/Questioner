All commands are run in project root directory.

First - install dependencies:

`$ composer install`
_____
To start development webserver run:

`$ php -S localhost:8888 -t public public/index.php`
_____
Run unit tests:

`$ ./bin/phpspec run`
_____
Run integration tests:

`$ ./bin/phpunit test`

(development server must be running)