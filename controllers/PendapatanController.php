<?php
namespace controllers;

use lib\Controller;

class PendapatanController extends Controller 
{
	public function route()
	{
		$this->app->get($this->path . ':name', function ($name) {
		    echo "Hello, $name";
		});
	}
}
?>