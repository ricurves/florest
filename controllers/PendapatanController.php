<?php
namespace controllers;

use lib\Controller;
use models\Pendapatan;

class PendapatanController extends Controller 
{
	public function route()
	{
		$app = $this->app;

		$app->get($this->path, 
			function () use ($app) {
				$params = $app->request()->get();
				$model = new Pendapatan;
		    	echo json_encode($model->listData($params));
			});
		
		$app->get($this->path . ':id', 
			function ($id) use ($app) {
				$model = new Pendapatan;
				$data = $model->findOne($id);
		    	
				if (! $data) {
		    		$data = ['E0001' => 'Resource does not exist'];
		    		$app->response->setStatus(401);
		    	}

		    	echo json_encode($data);
			});

		$app->post($this->path, 
			function () use ($app) {
				$model = new Pendapatan;
		    	
		    	if (!$model->delete($id))
		    		$app->response->setStatus(404);
			});

		$app->delete($this->path . ':id', 
			function ($id) use ($app) {
				$model = new Pendapatan;
		    	
		    	if (!$model->delete($id))
		    		$app->response->setStatus(404);
			});
	}
}
?>