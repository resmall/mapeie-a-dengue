<?php namespace App\Dengue\Validator;

//use App\Dengue\Validator;

class LocationValidator implements ValidatorInterface 
{

    private $validationFailed = false;  // bool

    public function validate(Array $parameters = array()) {
        foreach($coordinates as $value) {
            if(!is_numeric($value)) {
                $this->$validationFailed = true; // not numero
            }
        }
        $this->$validationFailed = false;
    }

    public function validationFailed() {
        return $this->validationFailed;
    }

    public function validationPasses() {
        return !$this->validationFailed;
    }



}