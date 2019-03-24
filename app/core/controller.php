<?php
	abstract class Controller
	{
		protected $model;
		protected $view;
		protected $template = "default.php";
		protected $model_dir = "../app/models/";

		function __construct()
		{
			$this->view = new View();
		}

		protected function includeModel(array $models)
        {
            foreach($models as $model){
                $model_patch = $this->model_dir . $model . '.php';
                include $model_patch;
                $this->model[$model] = new $model();
            }
        }
		
		abstract public function actionIndex();
	}
