<?php
namespace app\core;

abstract class Model {
    
    public const RULE_REQUIRED = 'required';
    public const RULE_EMAIL = 'email';
    public const RULE_MIN = 'min';
    public const RULE_MAX = 'max';
    public const RULE_MATCH = 'match';
    
    public function loadData($data) {
        // first we iterate over the data
        foreach($data as $key => $value) {
            // we have to check is a certain key exists - like firstname
            if(property_exists($this, $key)) {
                // if exists we will asign the data/ value to the property of the model
                // the actual Model doesn't have properties (the fields), RegisterModel does
                $this->{$key} = $value;
            }
        }
        
    }
    
    // this function that should be overriden will return an array
    abstract public function rules(): array;
    
    // this array will gather all the errors from validation
    public array $errors = [];
    
    public function validate() {
        
        // validate will be called after loadData

        foreach($this->rules() as $attribute => $rules) {
            // qw iterate over all the values/fields we get from Register form
            // value is the value of the attribute, like the value of firstName 
            $value = $this->{$attribute};
            //echo $value;
            foreach($rules as $rule) {
                // each rule can be a constant/string or an array
                $ruleName = $rule;
                if(!is_string($ruleName)) {
                    // rule[0] is the rule name
                    $ruleName = $rule[0];                    
                }
                if($ruleName === self::RULE_REQUIRED && !$value) {
                    // first we have RULE_REQUIRED for firstname
                    // we want to add errors to an attribute, the error will be of type RULE_...
                    $this->addError($attribute, self::RULE_REQUIRED);
                }
                
                
                
            }
            
        }
        
        if(empty($this->errors)) {
            // there are no errors in the errors array, addError was never called
            return true;
        } else {
            return false;
        }
        
    }
    
    public function addError(string $attribute, string $rule) {
        
        $message = $this->errorMessages()[$rule] ?? '';
        // here we add the errors to the errors array
        // each field/ property can have multiple errors (not all)
        // we will check all the attributes and assign existing errors per attribute
        $this->errors[$attribute][] = $message; 
        
        
    }
    
    public function errorMessages() {
        
        return [
            // we have again associative array
            self::RULE_REQUIRED => 'This field is required',
            self::RULE_EMAIL => 'This field must be a valid email address',
            self::RULE_MIN => 'Min length of this field must be {min}',
            self::RULE_MAX => 'Max length of this field must be {max}',
            self::RULE_MATCH => 'This field must be the same as {match}',
        ];
        
    }
    
}

