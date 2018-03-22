<?php
class InstallController extends test1\Controller
{
    
    public function __construct()
    {
        $this->model = new InstallModel();
    }
    
	public function index()
	{
        $tables = $this->model->createTables();
        $admin = $this->model->createAdmin();
        echo ($tables == 0) ? 'tables created <br>' : $table;
        echo ($admin == 0) ? 'admin created <br>' : $table;
        
	}
}