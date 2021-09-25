<?php

namespace App\Models;

class AdminDefaultSetting extends Base
{
    protected $appends = ['abbreviation'];
    public function __construct()
    {
        parent::__construct();
    }

    public function getAbbreviationAttribute(){
        return $this->state_address()->first()->abbreviation;
    }

    public function state_address(){
        return $this->belongsTo(State::class, 'state', 'name');
    }
    
    public function addAdminDefaultSetting($data)
    {
        $latlong = $this->getLatLong($data["zip"]);
        $data['latitude'] = $latlong['latitude'];
        $data['longitude'] = $latlong['longitude'];
        $this->save($data);
    }
    public static function getLatLong($zipCode)
    {
        return Zipcode::where('zipcode', $zipCode)->select('latitude', 'longitude')->first();
    }

    public function getStatesAbbr(){
        return $this->hasOne(State::class, 'name', 'state');
    }
}
