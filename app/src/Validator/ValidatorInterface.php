<?php namespace App\Dengue\Validator;


interface ValidatorInterface
{

    public function validate(array $parameters = array());
    public function validationFailed();
    public function validationPasses();
}