<?php
namespace controllers;

use lib\Controller;
use models\Pendapatan;

class PendapatanController extends Controller 
{
	public function route()
	{
		$app = $this->app;

		$this->app->get($this->path, 
			function () use ($app) {
				$params = $app->request()->get();
				$model = new Pendapatan;
		    	echo json_encode($model->listData($params));
			});
		
		$this->app->get($this->path . ':id', 
			function ($id) {
				$model = new Pendapatan;
		    	echo json_encode($model->findOne($id));
			});
	}
}
?>