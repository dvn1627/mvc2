<?php
namespace test1;
class Controller {
	
	public $view;
	
	public function __construct()
	{
		$this->view = new View();
	}
	
	public function getModel($modelName)
	{
		$modelPath = "../model/" . $modelName . '.php';
		if (!file_exists($modelPath)) {
			return false;
		}
		include_once $modelPath;
		return new $modelName;
	}

}
