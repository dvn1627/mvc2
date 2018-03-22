<?php

namespace test1;
class Route
{

	static function start()
	{
		$file = file_get_contents('config_app.json');
		$envs = json_decode($file, true);
		foreach ($envs as $k => $v) {
			define('ENV_'. strtoupper($k), $v);
		}

		$controllerName = 'main';
		$actionName = 'index';
		
		$routes = explode('/', $_SERVER['REQUEST_URI']);

		if ( !empty($routes[1]) )
		{	
			$controllerName = $routes[1];
		}
		
		if ( !empty($routes[2]) )
		{
			$actionName = $routes[2];
		}

		$modelName = $controllerName . 'Model';
		$controllerName = $controllerName . 'Controller';

		$modelFile = ucfirst($modelName) . '.php';
		$modelPath = "model/" . $modelFile;
		if(file_exists($modelPath))
		{
			include_once "model/" . $modelFile;
		}

		$controllerFile = ucfirst($controllerName) . '.php';
		$controllerPath = "controller/" . $controllerFile;
		if(file_exists($controllerPath))
		{
			include_once "controller/" . $controllerFile;
		}
		else
		{
			Route::ErrorPage404();
		}
		
		$controller = new $controllerName;
		$action = $actionName;
		
		if(method_exists($controller, $action))
		{
			$controller->$action();
		}
		else
		{
			Route::ErrorPage404();
		}
		
	}

	static function ErrorPage404()
	{
        include_once('view/404_view.php');
    }

}
