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
        $method = $this->request->method();
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
        // this is for controllers...
        if(is_array($callback)) {
            //$baseControllerInstance = new $callback[0]();
            //$callback[0] = $baseControllerInstance;
            // it is not ok to have controller public if we have get and set for it...
            Application::$app->setController(new $callback[0]());
            $callback[0] = Application::$app->getController();
        }
        
        /*
        echo '<pre>';
        var_dump($callback);
        echo '</pre>';
        exit;
        */
        
        // if there is callback we need to execute this callback with call_user_func
        // The callback will return some string - because function() in index.php returns for ex Hello World
        // if we acces "/" (home page) we see Hello World
        // this was for clojures...
        return call_user_func($callback, $this->request);

    }
    
    // this is for rendering views inside layouts
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
    
    // this is for render layouts
    protected function layoutContent() {
        $layout = Application::$app->getController()->layout;
        ob_start();
        include_once Application::$ROOT_DIR."/views/layouts/$layout.php";
        return ob_get_clean();
    }
    
    // this if for rendering views and maybe parameters
    protected function renderOnlyView(string $view, $params) {
        
        /*
        echo '<pre>';
        var_dump($params);
        echo '</pre>';
        exit;
        */
        
        foreach($params as $key => $value) {
            // $key is variable $name from home.php, $value it is the actual value of $name 
            $$key = $value;
            // $key is name string
            // if $key evaluates as name, $$key is evaluated as name variable...
            // , and we can use that name variable forward ($name), like at commented var_dump bellow
            
        }
        
        // the include will see $name... so it will include it in home.php...
        
        ob_start();
        include_once Application::$ROOT_DIR."/views/$view.php";
        return ob_get_clean();
    }

    
}

