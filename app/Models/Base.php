<?php
/**
* Base class is a child class of Elequoent Model's class.
* Our all Models will be extending this Base Model.
*
* @package  App\Models
* @author   Hadi Rajani
*/
namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

class Base extends Model
{

    /**
     * Used to track wether tracking of modifier is allowed
     *
     * @var bool
     */
    protected $trackModifier = true;

    /**
     * Contains column names of table which shuould be guarded
     *
     * @var array
     */
    protected $guarded = ['created_by','updated_by'];

    /**
     * Contains column names of table which shuould be hidden
     *
     * @var array
     */
    protected $hidden = ['created_by','updated_by','created_by_ip','updated_by_ip','create_data','update_data','created_by_module','updated_by_module'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [ 'created_at','updated_at'];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
       
    }

  /**
   * This method is used to save or update if id exists the changes
   * of Model in database
   *
   * @param array $options
   * @return bool
   */
    public function save(array $options = [])
    {
        
        $this->attributes = $options;
        if( isset($this->attributes['id']) ){
            $this->exists = true;
        }

      //If trackModifier is not forbidden, then update created_by & updated_by fields
        if ($this->trackModifier!==false) {
            $userId = (Auth::check() && Auth::user()->id)?Auth::user()->id:null;
            if (!$this->exists) {
                $this->created_by = $userId;
                $this->created_by_ip = $this->getUserIpAddr();
                $this->create_data = json_encode($options);
                $this->created_by_module = Route::getCurrentRoute() ? Route::getCurrentRoute()->getActionName() : null;
            }
            $this->updated_by = $userId;
            $this->updated_by_ip = $this->getUserIpAddr();            
            $this->update_data = json_encode($options);            
            $this->updated_by_module = Route::getCurrentRoute() ? Route::getCurrentRoute()->getActionName() : null;
        }

        return parent::save($options);
    }

    /**
     * Returns the creator of this model
     */
    public function createdBy()
    {
        if ($this->trackModifier!==false) {
            return $this->belongsTo(User::class, 'created_by');
        }
        return null;
    }

    /**
     * Returns the modifier user of this model
     */
    public function updatedBy()
    {
        if ($this->trackModifier!==false) {
            return $this->belongsTo(User::class, 'updated_by');
        }
        return null;
    }

    private function getUserIpAddr(){
        $ip = null;
        if(!empty($_SERVER['HTTP_CLIENT_IP'])){
            //ip from share internet
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
            //ip pass from proxy
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }elseif(!empty($_SERVER['REMOTE_ADDR'])){
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

    public function describe()
    {
        return DB::select(DB::raw("DESCRIBE " . $this->getTable(). ";"));
    }

}
