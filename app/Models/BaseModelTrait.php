<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

trait BaseModelTrait{



	public function save(array $options = [])
    {
        
        $this->attributes = $options;
        if( isset($this->attributes['id']) ){
            $this->exists = true;
        }

        $userId = (Auth::check() && Auth::user()->id)?Auth::user()->id:null;
        if (!$this->exists) {
            $this->created_by = $userId;
            $this->created_by_ip = $this->getUserIpAddr();
            $this->create_data = json_encode($options);
            // $this->created_by_module = Route::getCurrentRoute()->getActionName();
            $this->created_by_module = Route::getCurrentRoute() ? Route::getCurrentRoute()->getActionName() : null;
        }
        $this->updated_by = $userId;
        $this->updated_by_ip = $this->getUserIpAddr();            
        $this->update_data = json_encode($options);            
        $this->updated_by_module = Route::getCurrentRoute() ? Route::getCurrentRoute()->getActionName() : null;
        return parent::save($options);
    }

    private function getUserIpAddr(){
        if(!empty($_SERVER['HTTP_CLIENT_IP'])){
            //ip from share internet
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
            //ip pass from proxy
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }else{
            if(!empty($_SERVER['REMOTE_ADDR'])){

                $ip = $_SERVER['REMOTE_ADDR'];
            } else {
                $ip = null;
            }
        }
        return $ip;
    }

}