<?php

$app = new \Slim\Slim($config);

$params = explode('/', $app->request->getResourceUri());
if($params[1])
{
	require 'controllers/' . ucfirst($params[1]) . 'Controller.php';
}

$app->run();

?>