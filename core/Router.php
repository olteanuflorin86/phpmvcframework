<?php

namespace app\core;

class Router
{
    
    protected array $routes = [];     
    public Request $request;
    
    public function __construct(Request $request) {
        
        $this->request = $request;
        
    }
    
    public function get(string $path, $callback) {
        
        $this->routes['get'][$path] = $callback;
        
    }

    public function resolve() {
        
        // we will determine what is the current path (url path) and what is the current method
        // based on this we will take the proper route and return the result tot the user
        $path = $this->request->getPath();
        $method = $this->request->getMethod();
                
        $callback = $this->routes[$method][$path] ?? false;
        if($callback === false) {
            return "Not found";
        } 
        if(is_string($callback)) {
            return $this->renderView($callback);
        }
        // if there is callback we need to execute this callback with call_user_func
        // The callback will return some string - because function() in index.php returns for ex Hello World
        // if we acces "/" (home page) we see Hello World
        return call_user_func($callback);

    }
    
    public function renderView($view) {
        
        $layoutContent = $this->layoutContent();
        $viewContent = $this->renderOnlyView($view);
        
        return str_replace('{{content}}', $viewContent, $layoutContent);
        
    }
    
    protected function layoutContent() {
        ob_start();
        include_once Application::$ROOT_DIR."/views/layouts/main.php";
        return ob_get_clean();
    }
    
    protected function renderOnlyView(string $view) {
        ob_start();
        include_once Application::$ROOT_DIR."/views/$view.php";
        return ob_get_clean();
    }

    
}

