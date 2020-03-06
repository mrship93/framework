<?php
namespace app\controllers;
use app\models\Main;

class MainController extends \vendor\core\base\Controller //наследуем класс
{



    public function indexAction() {
        $model = new Main();
       $posts = $model->findAll();
       $post = $model->findOne(2);
       //$post = $model->findOne('Тестовый пост', 'title');
       // $data = $model->findBySql("SELECT * FROM posts ORDER BY id DESC LIMIT 2");
        $data = $model->findLike('то', 'title');
       debug($data);
       // $this->layout = 'main';
        //$this->view = 'test';
        $this->set(['posts' => $posts]);
    }

    public function testAction() {

    }
}