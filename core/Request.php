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
    
}

