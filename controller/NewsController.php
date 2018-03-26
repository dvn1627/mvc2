<?php
class NewsController extends test1\Controller
{
    
	public function create()
	{
        if (!isset($_SESSION['id'])) {
            header('Location: /');
        }
        $this->view->generate('news/create', 'main', 'create news');
    }

    public function __construct() {
        parent::__construct();
        $this->getModel('NewsModel');
    }
    
    public function store()
    {
        if (!isset($_SESSION['id'])) {
            header('Location: /');
        }
        if (!isset($_POST['title']) || strlen($_POST['title']) > 127 || strlen($_POST['title']) < 2) {
            header('Location: /');
        }
        $news = $this->getModel('NewsModel');
        $news->set('title', $_POST['title']);
        if (isset($_POST['message']) && strlen($_POST['message']) > 2 && strlen($_POST['message']) < 1023) {
            $news->set('message', $_POST['message']);
        }
        if (isset($_FILES['image']) && !empty($_FILES['image']['tmp_name'])) {
            $finfo = new \finfo(FILEINFO_MIME_TYPE);
            $ext = array_search(
                $finfo->file($_FILES['image']['tmp_name']),
                [
                    'jpg' => 'image/jpeg',
                    'png' => 'image/png',
                    'gif' => 'image/gif',
                ],
                true
            );
            if ($ext) {
                $path = $this->getFileName($ext);
                move_uploaded_file($_FILES['image']['tmp_name'], $path);
                $news->set('image', $path);
            }
        }
        $news->set('user_id', $_SESSION['id']);
        $news->save();
        header('Location: /');
    }

    public function delete($id)
    {
        if (!isset($_SESSION['id']) || is_null($id)) {
            header('Location: /');
        }
        $news = NewsModel::find('NewsModel', $id);
        if ($news->get('user_id') != $_SESSION['id']) {
            header('Location: /');
        }
        if (!is_null($news->get('image')) && file_exists($news->get('image'))) {
            unlink($news->get('image'));
        }
        $news->delete();
        header('Location: /');
    }

    public function edit($id)
    {
        if (!isset($_SESSION['id']) || is_null($id)) {
            header('Location: /');
        }
        $news = NewsModel::find('NewsModel', $id);
        if ($news->get('user_id') != $_SESSION['id']) {
            header('Location: /');
        }
        $this->view->generate('news/create', 'main', 'create news', $news);
    }

    public function update()
    {
        if (!isset($_SESSION['id']) || !isset($_POST['id'])) {
            header('Location: /');
        }
        if (!isset($_POST['title']) || strlen($_POST['title']) > 127 || strlen($_POST['title']) < 2) {
            header('Location: /');
        }
        $news = NewsModel::find('NewsModel', $_POST['id']);
        if ($news->get('user_id') != $_SESSION['id']) {
            header('Location: /');
        }
        $news->set('title', $_POST['title']);
        if (isset($_POST['message']) && strlen($_POST['message']) > 2 && strlen($_POST['message']) < 1023) {
            $news->set('message', $_POST['message']);
        }
        if (isset($_FILES['image']) && !empty($_FILES['image']['tmp_name'])) {
            if (!is_null($news->get('image')) && file_exists($news->get('image'))) {
                unlink($news->get('image'));
            }
            $finfo = new \finfo(FILEINFO_MIME_TYPE);
            $ext = array_search(
                $finfo->file($_FILES['image']['tmp_name']),
                [
                    'jpg' => 'image/jpeg',
                    'png' => 'image/png',
                    'gif' => 'image/gif',
                ],
                true
            );
            if ($ext) {
                $path = $this->getFileName($ext);
                move_uploaded_file($_FILES['image']['tmp_name'], $path);
                $news->set('image', $path);
            }
        }
        $news->save();
        header('Location: /');
    }

    private function getFileName($ext)
    {
        do {
            $name = 'images/news_' . uniqid() . '.' . $ext;
        } while (file_exists($name));
        return $name;
    }

}