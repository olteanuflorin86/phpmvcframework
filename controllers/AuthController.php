<?php
namespace app\controllers;

use app\core\Controller;
use app\core\Request;
use app\models\RegisterModel;


class AuthController extends Controller {
    
    public function login() {
        
        $this->setLayout('auth');
        return $this->render('login');
        
    }
    
    public function register(Request $request) {
        
        $errors = [];
        
        $this->setLayout('auth');
        
        if($request->isPost()) {
            
            $registerModel = new RegisterModel();
            
            /*
            echo '<pre>';
            var_dump($request->getBody());
            echo '</pre>';
            exit;
            */
            
            
            $firstname = $request->getBody()['firstname'];
            if(!$firstname) {
                $errors['firstname'] = 'This field is required';
            }
            echo $firstname;
            
            echo '<pre>';
            var_dump($errors);
            echo '</pre>';
            exit;
            
            return 'Handle submitted data';
            
        }

        return $this->render('register', ['errors' => $errors]); 
        
    }
    
    
    
}

