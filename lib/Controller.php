<?php
namespace lib;

class Controller
{
	public $app; 
	public $id;
	public $path;

	function __construct($app, $id)
	{
		$this->app = $app;
		$this->id = $id;
		$this->path = '/' . $id . '/';
		$this->route();
	}

	public function route()
	{
		echo 'No routing yet!';
	}

	public function loadModel($model)
	{

	}
}

?>