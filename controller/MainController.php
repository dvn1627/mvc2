<?php
class MainController extends test1\Controller
{
	
	public function index()
	{
		$model = new MainModel();
		$data = $model->getArray(['table'	=> 'news']);
		$this->view->generate('news.php', 'main.php', 'news page', ['news' => $data]);
	}
}