<?php

namespace App;

use MF\Init\Bootstrap;

//Application's routes
class Route extends BootStrap{

    // Mapping the routes and yours action in application
    protected function initRoutes(){
        
        $routes["home"] = Array(
            'route' => '/',
            'controller' => 'IndexController',
            'action' => 'index'
        );

        $routes["signin"] = Array(
            'route' => '/signin',
            'controller' => 'IndexController',
            'action' => 'signin'
        );

        $routes["register"] = Array(
            'route' => '/register',
            'controller' => 'IndexController',
            'action' => 'register'
        );

        $routes["autenticate"] = Array(
            'route' => '/autenticate',
            'controller' => 'AuthController',
            'action' => 'autenticate'
        );

        $routes["logout"] = Array(
            'route' => '/logout',
            'controller' => 'AuthController',
            'action' => 'logout'
        );

        $routes["timeline"] = Array(
            'route' => '/timeline',
            'controller' => 'AppController',
            'action' => 'timeline'
        );

        $routes["addTweet"] = Array(
            'route' => '/tweet',
            'controller' => 'AppController',
            'action' => 'tweet'
        );

        $routes["deleteTweet"] = Array(
            'route' => '/delete',
            'controller' => 'AppController',
            'action' => 'delete'
        );

        $routes["toFollow"] = Array(
            'route' => '/toFollow',
            'controller' => 'AppController',
            'action' => 'toFollow'
        );

        $routes["searchUser"] = Array(
            'route' => '/searchUser',
            'controller' => 'AppController',
            'action' => 'searchUser'
        );

        $routes["follow"] = Array(
            'route' => '/follow',
            'controller' => 'AppController',
            'action' => 'follow'
        );

        $routes["unfollow"] = Array(
            'route' => '/unfollow',
            'controller' => 'AppController',
            'action' => 'unfollow'
        );

        $this->setRoutes($routes);
    }

}

?>