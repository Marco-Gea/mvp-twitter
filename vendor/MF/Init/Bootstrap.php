<?php
//Abstraction class of routes for apllication
namespace MF\init;

abstract class Bootstrap{

    private $routes;

    abstract protected function initRoutes();

    public function __construct(){
        //Initializing the routes
        $this->initRoutes();
        //Search for a match route in application's routes to call the action
        $this->run($this->getUrl());
    }

    public function getRoutes(){
        return $this->routes;
    }

    public function setRoutes(array $routes){
        $this->routes = $routes;
    }

    //Search for a match route with the user path
    protected function run($url){

        foreach ($this->getRoutes() as $path => $route) {

            //If is a valid path (has a match route), the framework start the controller, gets the action and call her
            if($url == $route['route']){
                $class = "App\\Controllers\\".ucfirst($route['controller']);
                $controller = new $class;
                $action = $route['action'];
                $controller->$action();
            }
        }

    }

    // Getting the url of application and testing if is a valid path
    protected function getUrl(){
        return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    }
}

?>