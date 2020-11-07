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
            // EX $this->rules(): combination of required, email, min, etc
            // EX attribute: firstName
            // EX rules: required
            // we iterate over all the values/fields we get from Register form
            // value is the value of the attribute, like the value of firstName 
            $value = $this->{$attribute};
            // EX value: Florin
            foreach($rules as $rule) {
                // each rule can be a constant/string or an array
                $ruleName = $rule;
                // EX ruleName: required, email, Array(not string)
                if(!is_string($ruleName)) {
                    // rule[0] is the rule name
                    $ruleName = $rule[0];  
                    // EX rule[0]: min, max, match
                }
                if($ruleName === self::RULE_REQUIRED && !$value) {
                    // first we have RULE_REQUIRED for firstname
                    // we want to add errors to an attribute, the error will be of type RULE_...
                    $this->addError($attribute, self::RULE_REQUIRED);
                }
                if($ruleName === self::RULE_EMAIL && !filter_var($value, FILTER_VALIDATE_EMAIL)) {                
                    $this->addError($attribute, self::RULE_EMAIL);                       
                }
                if($ruleName === self::RULE_MIN && strlen($value) < $rule['min']) {
                    $this->addError($attribute, self::RULE_MIN, $rule);   
                }
                if($ruleName === self::RULE_MAX && strlen($value) > $rule['max']) {
                    $this->addError($attribute, self::RULE_MAX, $rule);
                }
                if($ruleName === self::RULE_MATCH && $value !== $this->{$rule['match']}) {
                    $this->addError($attribute, self::RULE_MATCH, $rule);
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
    
    
    public function addError(string $attribute, string $rule, $params = []) {
        
        $message = $this->errorMessages()[$rule] ?? '';
        // here we add the errors to the errors array
        // each field/ property can have multiple errors (not all)
        // we will check all the attributes and assign existing errors per attribute
        foreach($params as $key => $value) {
            $message = str_replace("{{$key}}", $value, $message);
        }
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
    
    
    public function hasError(string $attribute) {
        
        return $this->errors[$attribute] ?? false;
         
    }
    
    // there might be more than just one error...
    public function getFirstError($attribute) {
        
        return $this->errors[$attribute][0] ?? false;
        
    }
    
}

