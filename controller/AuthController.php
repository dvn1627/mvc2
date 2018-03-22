<?php
class AuthController extends test1\Controller
{
    
    public function __construct()
    {
        $this->model = new AuthModel();
    }
    
	public function login()
	{
        if (!isset($_POST['password']) || !isset($_POST['email'])) {
            header('Location: /');
        }
        $adminId = $this->model->login(['password' => $_POST['password'], 'email' => $_POST['email']]);
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