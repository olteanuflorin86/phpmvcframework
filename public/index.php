<?php 

    require_once __DIR__.'/../vendor/autoload.php';
    
    // If we write the line below we can create an instance of Application in this file
    use app\core\Application;
    
    $app = new Application(dirname(__DIR__));    
    
    $app->router->get('/', function() {
        return 'Hello World';
    });
    
    $app->router->get('/contact', 'contact');
    
    $app->router->get('/home', 'home');
    
    $app->run();
    
    
    

?>