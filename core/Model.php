<?php
namespace app\core;

abstract class Model {
    
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
    
    public function validate() {
        // to do
    }
    
}

