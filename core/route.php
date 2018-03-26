<?php

namespace test1;
class Route
{

	static function start()
	{
		$file = file_get_contents('../config_app.json');
		$envs = json_decode($file, true);
		foreach ($envs as $k => $v) {
			define('ENV_'. strtoupper($k), $v);
		}

		$controllerName = false;
		$actionName = false;
		
		$routes = explode('/', $_SERVER['REQUEST_URI']);

		if (!empty($routes[1])) {	
			$controllerName = $routes[1];
		}
		
		if (!empty($routes[2])) {
			$actionName = $routes[2];
		}
		$parameter = null;
		if (((integer) $actionName) > 0) {
			$parameter = (integer) $actionName;
			$actionName = false;
		} elseif (!empty($routes[3])) {
			$parameter = $routes[3];
		}
		require '../router.php';
		$search = $controllerName ? '/' . $controllerName : '/';
		$search .= $actionName ? '/' . $actionName : '';
		$find = isset($route[$search])	? $route[$search] : false;
		if ($find === false) {
			Route::ErrorPage404();
		}
		$match = explode('@', $find);
		$controllerName = $match[0];
		$actionName = $match[1];
		$modelName = $controllerName . 'Model';

		$controllerFile = ucfirst($controllerName) . '.php';
		$controllerPath = "../controller/" . $controllerFile;

		if (file_exists($controllerPath)) {
			include_once $controllerPath;
		}
		else {
			Route::ErrorPage404();
		}
		
		$controller = new $controllerName;
		$action = $actionName;
		
		if (method_exists($controller, $action)) {
			$controller->$action($parameter);
		}
		else {
			Route::ErrorPage404();
		}
		
	}

	static function ErrorPage404()
	{
		include_once('../view/404_view.php');
		die();
    }

}
