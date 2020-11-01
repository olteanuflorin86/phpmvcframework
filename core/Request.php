<?php
namespace app\core;

class Request
{
    
    public function getPath() {
        
        $path = $_SERVER['REQUEST_URI'] ?? '/';
        // check if "?" exists in $path and if so it gives us its position (if not we get false)
        $position = strpos($path, '?');
        if($position === false) {
            return $path;
        }
        return substr($path, 0, $position);
        
    }
    
    public function getMethod() {
        
        return strtolower($_SERVER['REQUEST_METHOD']);
        
    }
    
    public function getBody() {
        
        $body = [];
        
        // we make the sanitize for get and post below
        
        if($this->getMethod() === 'get') {   
            echo 'get method';
            foreach($_GET as $key => $value) {                
                $body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
        
        if($this->getMethod() === 'post') {
            echo 'post method';
            foreach($_POST as $key => $value) {
                $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
        
        return $body;
        
    }
    
}

