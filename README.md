```markdown
# My PHP Router

A flexible and powerful PHP router for building web applications.

## Installation

You can install the package using Composer:

```bash
composer require bibek/my-php-router
```

## Usage

```php
<?php

// Include Composer's autoloader
require_once 'vendor/autoload.php';

// Import the Router class from your package
use Bibek\MyPhpRouter\Router;

// 1st middleware
function middleware($next) {
    try {
        // check user in session
        session_start();
        if (!isset($_SESSION['user'])) {
            throw new Error('401, Unauthorized'); // Throwing an Exception
        }
        $emptyObj = new stdClass();
        next($emptyObj); // go to the next controller
    }
    catch (Exception | Error $e) {
        // catched error ll be automatically echoed by the default error handling mechanism of PHP dev mode (php ini settings)
        // so error may be echoed twice (once by the default error handling mechanism of PHP dev mode and once by your error handler)
        // in production mode, the default error handling mechanism of PHP will not echo the error

        $next($e->getMessage()); // Will be caught by the errorHandler
    }
}

// next controller
function controller($next) {
    echo 'controller2';
}

// error handler
function errorHandler($error) {
    // Handle error here
    echo "Custom Error Handler: " . $error . "<br>";
}

// ROUTE THE REQUEST
Router::route('/user', 'errorHandler')->get(array('middleware', 'controller'));

// similarly (Assuming middleware2, controller2 are defined)
Router::route('/user/route2', 'errorHandler')->get(array('middleware2', 'controller2'));
```

## Customization

You can customize the router by defining your own middleware functions and error handlers. Feel free to extend and modify the provided examples according to your application's needs.

## Support and Contact

If you have any questions, suggestions, or feedback, feel free to reach out:

- **Bibek Dhakal**
- **Email:** dhakalaswin8366@gmail.com

## License
This package is open source and available under the MIT License.

```


