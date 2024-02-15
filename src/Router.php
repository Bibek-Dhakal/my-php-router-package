<?php
// router.php

// Router class
class Router {
    public static function route($route, $errorHandler8366 = null) {
        if(!isset($route)) {
            throw new Exception('Route is not defined');
        }
        if(!isset($errorHandler8366)) {
            $errorHandler = function ($error) {
                echo "Error: " . $error->message . " Pass a custom error handler to the route for better error handling.";
            };
            return new Route($route, 'errorHandler');
        }
        if(!is_callable($errorHandler8366)) {
            throw new Exception('Error handler is not a function');
        }
        $errorHandler = function ($error) use ($errorHandler8366) {
            $errorHandler8366($error);
        };
        return new Route($route, 'errorHandler');
    }
}

// Route class
class Route {
    private $route;
    private $handlersArray = array();
    private $errorHandlerArray = array();

    private $currentHandlerIndex = 0;

    public function __construct($route, $errorHandler) {
        $this->route = $route;
        if(is_callable($errorHandler)) {
            $this->errorHandlerArray[0] = $errorHandler;
        }
    }
    
    public function get($handlersArray) {
        $this->handleRequest('GET', $handlersArray);
    }
    
    public function post($handlersArray) {
        $this->handleRequest('POST', $handlersArray);
    }

    private function handleRequest($method, $handlersArray) {
        if ($_SERVER['REQUEST_URI'] === $this->route && $_SERVER['REQUEST_METHOD'] === $method) {
            $this->handlersArray = $handlersArray;
            if(!empty($handlersArray)) {
                if(is_callable($this->handlersArray[$this->currentHandlerIndex])) {
                    $next = $this->getNextFnDef();
                    $this->handlersArray[$this->currentHandlerIndex]($next);
                }
            }
        }
    }

    private function getNextFnDef() {
        return function ($error = new stdClass()) {
            print_r($error);
            if(!empty((array) $error) ?? false) {
                // error object is not empty
                if(is_callable($this->errorHandlerArray[0])) {
                    $this->errorHandlerArray[0]($error);
                }

            } else {
                if(isset($this->handlersArray[$this->currentHandlerIndex + 1])) {
                    $this->currentHandlerIndex++;
                    if(is_callable($this->handlersArray[$this->currentHandlerIndex])) {
                        $next = $this->getNextFnDef();
                        $this->handlersArray[$this->currentHandlerIndex]($next);
                    }
                }
            }
        };
    }
}




