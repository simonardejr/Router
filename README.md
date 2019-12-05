# Router
A very basic PHP Router

# Requirements
PHP 7.2 or greater.

# How to Use
Use this router is very simple, just include autoload from composer, define your routes and you are ready to go!

```php
require 'vendor/autoload.php';

use simonardejr\Router\Router;
use simonardejr\Router\Request;
use simonardejr\Router\Response;

// Define a GET route to "/"
Router::get('', function() {
    Response::send('Hello!');
});

// Defines a GET route to "/users/1"
Router::get('users/1', function() {
    $data = [
        'name' => 'Simonarde Lima',
        'foo'  => 'bar'
    ];

    Response::json($data);
});

// Defines a POST to "/users"
Router::post('users', function() {
    $request = Request::request();

    // your magic code to persist this new user goes here :)

    Response::send("New user {$request['name']} created!");
});

// Start Router
Router::run();
```

## You can even use controllers instead of Closures
Just create a folder called "controllers" on the root of the project and define the route passing the name of the controller and the method you want to call, like this:
```php
Router::get('test', 'TestController@index');
```

# Contribute!
Want to help? Clone this repo and open your PR!

This router is a very basic piece of code, and it's, by no means, the best and the cleanest way to implement a router, but feel free to use and redistribute any way you want.