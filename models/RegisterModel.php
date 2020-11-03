<?php
namespace app\models;

use app\core\Model;

class RegisterModel extends Model {
    
    public string $firstName;
    public string $lastName;
    public string $email;
    public string $password;
    public string $confirmPassword;
    
    /*
    public function getFirstName() {
        return $this->firstName;
    }
    
    public function setFirstName($firstName) {
        $this->firstName = $firstName;
    }
    

    public function getLastName() {
        return $this->lastName;
    }
    
    public function setLastName($lastName) {
        $this->lastName = $lastName;
    }
    

    public function getEmail() {
        return $this->email;
    }
    
    public function setEmail($email) {
        $this->email = $email;
    }
    

    public function getPassword() {
        return $this->password;
    }
    
    public function setPassword($password) {
        $this->password = $password;
    }
    

    public function getConfirmPassword() {
        return $this->confirmPassword;
    }

    public function setConfirmPassword($confirmPassword) {
        $this->confirmPassword = $confirmPassword;
    }
    */
    
    public function register() {
        
        echo "Creating new user";
        
    }
    
    public function rules(): array {
        
        return [            
            'firstName' => [self::RULE_REQUIRED],
            'lastName' => [self::RULE_REQUIRED],
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL],
            'password' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 8], [self::RULE_MAX, 'max' => 24]],
            'confirmPassword' => [self::RULE_REQUIRED, [self::RULE_MATCH, 'match' => 'password']],
        ];
        
    }
    

}

