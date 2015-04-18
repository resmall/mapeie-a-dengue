<?php namespace App\Dengue\Location;

class Location
{

    private $longitude;

    private $latitude;

    function __construct($lng, $lat) {
        $this->longitude = $lng;
        $this->latitude = $lat;
    }

    public function getLongitude() {
        return $this->longitude;
    }

    public function setLongitude($longitude) {
        $this->longitude = $longitude;
    }

    public function getLatitude() {
        return $this->latitude;
    }

    public function setLatitude($latitude) {
        $this->latitude = $latitude; 
    }

}





