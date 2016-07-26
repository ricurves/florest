<?php

$time_start = microtime(true);

require 'vendor/autoload.php';
require 'lib/controller.php';
require 'lib/model.php';

// Perform an autoloading class
spl_autoload_register(function ($name) {
	require $name . '.php';
});

// Create new instance of Slim object
$app = new \Slim\Slim($config);

// Load the appropriate controller based on the url
$params = explode('/', $app->request->getResourceUri());
if($controller = $params[1])
{
	$functionName = 'controllers\\' . ucfirst($controller) . 'Controller';
	new $functionName($app, $controller);
}

// Finally, start the engine & let the games begin!!
$app->run();

$time_end = microtime(true);

if ($app->config('profiler'))
{
	$execution_time = number_format($time_end - $time_start, 4);
	echo '<div style="background: #dfd; margin: 20px 0">Total execution time : '.$execution_time.' seconds </div>';
}

?>