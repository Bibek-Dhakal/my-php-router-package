# My PHP Router

A flexible and powerful PHP router for building web applications.

## Installation

You can install the package using Composer:

```console
composer require bibek/my-php-router
```

## Usage

```php
<?php

// Include Composer's autoloader
require_once 'vendor/autoload.php';

// Import the Router class from the package
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
MIT License

Copyright (c) 2024 Bibek Dhakal

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
```


