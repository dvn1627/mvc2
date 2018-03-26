<?php
class MainController extends test1\Controller
{
	
	public function index()
	{
		$model = $this->getModel('MainModel');
		$data = $model->getArray(['table'	=> 'news']);
		$this->view->generate('news', 'main', 'news page', ['news' => $data]);
	}

	public function test($id)
	{
		echo "<h1>TEST PAGE</h1>";
		var_dump($id);
	}

}