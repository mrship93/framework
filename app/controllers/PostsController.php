<?php
namespace app\controllers;

class PostsController extends \vendor\core\base\controller //наследуем класс
{
    // public $layout = 'main';


    public function indexAction() {
         //$this->layout = 'main';
        $this->view = 'test';
        $this->set(['name' => 'Константин']);
    }

    public function testAction() {

    }
}