<?php
class AuthController extends test1\Controller
{
    
    public function __construct()
    {
        parent::__construct();
        $this->getModel('AuthModel');
    }
    
	public function login()
	{
        if (!isset($_POST['password']) || !isset($_POST['email'])) {
            header('Location: /');
        }
        $AuthModel = new AuthModel();
        $adminId = $AuthModel->login(['password' => $_POST['password'], 'email' => $_POST['email']]);
        if ($adminId) {
            $_SESSION['id'] = $adminId;
            header('Location: /');
        }
    }
    
    public function logout()
    {
        unset($_SESSION['id']);
        header('Location: /');
    }
}