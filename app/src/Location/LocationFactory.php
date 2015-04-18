<?php namespace App\Dengue\Location;

use App\Dengue\Validator\Validator;


// usando o design pattern factory *yay*
class LocationFactory
{


    //public function ()

    // recebe esses parametros do input post
    // TODO: Não precisa ser estático, coisa de preguiçoso, mudar.
    public function getLocationObject($long, $lat) {
        $v = new Validator([$long, $lat]);
        if( $v->validationPasses() ) {
            $locationObject = new Location($long, $lat);
            return $locationObject;
        } else {
            return null;
        }
    }

    // faz uma validação preguiçosa se os parâmetros são numeros mesmo ou nao
    private function validate(array $coordinates) {
        foreach($coordinates as $value) {
            if(is_nan($value)) {
                return false;
            } 
        }
        return true;
    }
}