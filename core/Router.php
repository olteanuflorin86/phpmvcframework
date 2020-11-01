<?php

namespace app\core;

class Router
{
    
    protected array $routes = [];     
    
    public Request $request;
    public Response $response;
    
    public function __construct(Request $request, Response $response) {
        
        $this->request = $request;
        $this->response = $response;
        
    }
    
    public function get(string $path, $callback) {
        
        $this->routes['get'][$path] = $callback;
        
    }
    
    public function post(string $path, $callback) {
        
        $this->routes['post'][$path] = $callback;
        
    }

    public function resolve() {
        
        // we will determine what is the current path (url path) and what is the current method
        // based on this we will take the proper route and return the result tot the user
        $path = $this->request->getPath();
        $method = $this->request->getMethod();
        $callback = $this->routes[$method][$path] ?? false;
        if($callback === false) {
            //Application::$app->response->setStatusCode(404);
            $this->response->setStatusCode(404);
            //return $this->renderContent("Not found");
            return $this->renderView("_404");
        } 
        // this is for rendering views, not for clojures:
        if(is_string($callback)) {
            return $this->renderView($callback);
        }
        // if there is callback we need to execute this callback with call_user_func
        // The callback will return some string - because function() in index.php returns for ex Hello World
        // if we acces "/" (home page) we see Hello World
        return call_user_func($callback);

    }
    
    public function renderView($view, $params = []) {
        
        $layoutContent = $this->layoutContent();
        $viewContent = $this->renderOnlyView($view, $params);
        
        return str_replace('{{content}}', $viewContent, $layoutContent);
        
    }
    
    // we don't use it anymore now, we used to in resolve function above
    // it can be used to publish a message
    public function renderContent($viewContent) {
        
        $layoutContent = $this->layoutContent();
        
        return str_replace('{{content}}', $viewContent, $layoutContent);
        
    }
    
    protected function layoutContent() {
        ob_start();
        include_once Application::$ROOT_DIR."/views/layouts/main.php";
        return ob_get_clean();
    }
    
    protected function renderOnlyView(string $view, $params) {
        
        echo '<pre>';
        var_dump($params);
        echo '</pre>';
        exit;
        
        ob_start();
        include_once Application::$ROOT_DIR."/views/$view.php";
        return ob_get_clean();
    }

    
}

