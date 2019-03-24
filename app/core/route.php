<?php
	class Route
	{
		static function start()
		{
			// контроллер и действие по умолчанию
			$controller_name = 'main';
			$action_name = 'index';
						
			$separate_method_GET = explode('?', $_SERVER['REQUEST_URI']);
			$routes = explode('/', $separate_method_GET[0]);

			if (!empty($routes[1]))
			{	
				$controller_name = $routes[1];
			}
			
			if (!empty($routes[2]))
			{
				$action_name = $routes[2];
			}

			$controller_file = 'controller_' . strtolower($controller_name) . '.php';
			$controller_path = "../app/controllers/" . $controller_file;
			if(file_exists($controller_path))
			{
				include $controller_path;
			} else
			{
				Route::errorPage404();
			}
			
			$controller = 'Controller' . $controller_name;
			$controller = new  $controller;
			$action = 'action' . $action_name;
						
			if(method_exists($controller, $action))
			{
				$controller->$action();
			} else
			{
				Route::errorPage404();
			}	
		}

		static function errorPage404()
		{
			header('Location: http://' . $_SERVER['HTTP_HOST'] . '/404');
		}
	}