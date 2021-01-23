<?php
    
namespace App\Controllers;

//Use abstract class of all controllers
use MF\Controller\Action;
//Container abstraction class
use MF\Model\Container;

//The AuthController's actions
class AuthController extends Action{

    public function autenticate(){
        $user = Container::getModel('User');
        $user->__set('email', $_POST['email']);
        $user->__set('pass', $_POST['pass']);
        $user->login();

		if($user->__get('id') != '' && $user->__get('name')) {
			
			session_start();

			$_SESSION['id'] = $user->__get('id');
			$_SESSION['name'] = $user->__get('name');

			header('Location: /timeline');

		} else {
			header('Location: /?login=erro');
		}
    }

    public function logout(){
        session_start();
        session_destroy();
        header('Location: /');
    }
    
}

?>