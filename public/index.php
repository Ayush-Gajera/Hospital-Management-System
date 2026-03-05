<?php

define("BASE_PATH", dirname(__DIR__));  
require BASE_PATH . "/vendor/autoload.php";
require BASE_PATH . "/config.php";

ini_set('display_errors', 1);
error_reporting(E_ALL);

use app\Http\Router;
use app\Http\Request;

$request = new Request();
$router = new Router();

require BASE_PATH . "/routes/web.php";

// 6. Resolve and Display
// This is what sends your "Welcome" message to the browser
echo $router->resolve($request);
/*
define("BASE_PATH",dirname(__DIR__));  
require BASE_PATH ."./vendor/autoload.php";
require BASE_PATH ."/config.php";
ini_set('display_error',1);
error_reporting(E_ALL);


require BASE_PATH . "/routes/web.php";
use app\Http\Router;
use app\Http\Request;

$request = new Request();
$router = new Router();*/

