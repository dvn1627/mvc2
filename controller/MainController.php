<?php
class MainController extends test1\Controller
{

	public function __construct()
    {
        parent::__construct();
        $this->getModel('MainModel');
    }

	public function index()
	{
		$model = new MainModel();
		$data = $model->getArray(['table'	=> 'news']);
		$this->view->generate('news', 'main', 'news page', ['news' => $data]);
	}

	public function test($id)
	{
		echo "<h1>TEST PAGE</h1>";
		var_dump($id);
	}

}