<?php
    
namespace App\Controllers;

//Use abstract class of all controllers
use MF\Controller\Action;
//Container abstraction class
use MF\Model\Container;

//The AppController's actions
class AppController extends Action{

    public function timeline(){
        $this->autentication();
        $tweets = Container::getModel('tweet');
        $tweets->__set('id_user', $_SESSION['id']);
        $this->view->data = $tweets->getAllTweets();
        
        $user = Container::getModel('user');
        $user->__set('id', $_SESSION['id']);

        $this->view->username = $user->getName();
        $this->view->countTweets = $user->countTweets();
        $this->view->countFollowing = $user->countFollowing();
        $this->view->countFollows = $user->countFollows();

        $this->render('timeline');
        
    }

    public function tweet(){
        $this->autentication();
        if(isset($_POST['text']) && $_POST['text'] != ''){
            $tweets = Container::getModel('tweet');
            $tweets->__set('id_user', $_SESSION['id']);
            $tweets->__set('text', $_POST['text']);
            $tweets->addTweet();
            header('Location: /timeline');
        }
    }

    public function delete(){;
        $this->autentication();
        echo "testando";
        if(isset($_GET['id']) && $_GET['id'] != ''){
            $tweets = Container::getModel('tweet');
            $tweets->__set('id', $_GET['id']);
            $tweets->deleteTweet();
            header('Location: /timeline');
        }
    }

    public function toFollow(){
        $this->autentication();

        $user = Container::getModel('user');
        $user->__set('id', $_SESSION['id']); 
        $this->view->data = $user->getAllUsers();
        $this->view->username = $user->getName();
        $this->view->countTweets = $user->countTweets();
        $this->view->countFollowing = $user->countFollowing();
        $this->view->countFollows = $user->countFollows();
        $this->render('toFollow');
    }

    public function searchUser(){
        $this->autentication();

        if(!isset($_POST['searchUser']) || $_POST['searchUser'] == ''){
            header('Location: /timeline');
        }
        
        $user = Container::getModel('user');
        $user->__set('id', $_SESSION['id']);
        $user->__set('searchUser', $_POST['searchUser']); 

        $this->view->username = $user->getName();
        $this->view->countTweets = $user->countTweets();
        $this->view->countFollowing = $user->countFollowing();
        $this->view->countFollows = $user->countFollows();
        $this->view->data = $user->getUsers();
        $this->render('toFollow');
    }

    public function follow(){
        $this->autentication();

        if(isset($_GET['id']) || $_GET['id'] != ''){
            $user = Container::getModel('user');
            $user->__set('id', $_SESSION['id']);
            $user->__set('id_followed', $_GET['id']);
            $user->follow();
        }

        header('Location: /toFollow');
    }

    public function unfollow(){
        $this->autentication();

        if(isset($_GET['id']) || $_GET['id'] != ''){
            $user = Container::getModel('user');
            $user->__set('id', $_SESSION['id']);
            $user->__set('id_followed', $_GET['id']);
            $user->unfollow();
        }

        header('Location: /toFollow');
    }

    public function autentication(){
        session_start();
        if(!isset($_SESSION['id']) ||  $_SESSION['id'] == '' && !isset($_SESSION['name']) ||  $_SESSION['name'] == ''){
            header('Location: /?login=erro');
        }
    }
    
}

?>