<?php
namespace app\core;

class Application 
{    
    public static string $ROOT_DIR;
    
    public Router $router;
    public Request $request;
    public Response $response;
    
    public static Application $app;
    
    private Controller $controller;
    
    public function __construct($rootPath) {
        
        self::$ROOT_DIR = $rootPath;
        // this is why we create a static Application field, to have a handler:
        self::$app = $this;
        
        $this->request = new Request();
        $this->response = new Response();
        
        $this->router = new Router($this->request, $this->response);
        
    } 
    
    
    public function getController() {
        return $this->controller;
    }
    
    public function setController(Controller $controller) {
        $this->controller = $controller;
    }
    
    
    public function run() {
        
        echo $this->router->resolve();
        
    }
    
}