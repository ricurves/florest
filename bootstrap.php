<?php

require_once 'lib/controller.php';
require_once 'lib/model.php';

$app = new \Slim\Slim($config);

$params = explode('/', $app->request->getResourceUri());
if($controller = $params[1])
{
	require 'controllers/' . ucfirst($controller) . 'Controller.php';
	$functionName = 'controllers\\' . ucfirst($controller) . 'Controller';
	new $functionName($app, $controller);
}

$app->run();

?>