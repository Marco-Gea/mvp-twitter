<?php
    
namespace App\Controllers;

//Use abstract class of all controllers
use MF\Controller\Action;
//Container abstraction class
use MF\Model\Container;

//The IndexController's actions
class IndexController extends Action{

    public function index(){
        $this->view->login = isset($_GET['login']) ? $_GET['login'] : '';
        $this->render('index');
    }

    public function signin(){
        $this->view->registerError = false;
        $this->render('signin');
    }

    public function register(){
        $user = Container::getModel('User');
        $user->__set('name', $_POST['name']);
        $user->__set('email', $_POST['email']);
        $user->__set('pass', $_POST['pass']);
        if($user->validateUser() && count($user->getUserByEmail()) == 0){
            $user->register();
            $this->render('register');
        }else{
            $this->view->registerError = true;
            $this->render('signin');
        }
        
    }
    
}

?>