<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use SoftDeletes;
    // public $timestamps = false;


    public function department()
    {
      return $this->belongsTo(Department::class,'department_id','id' );
    }

    // public function service_type()
    // {
    //     return $this->belongsTo(ServiceType::class,'service_type_id', 'id');
    // }
    protected $fillable = [
        'service_type_id','department_id','Service',
        'Charges','ServingTime','IsShowDelayAlert',
        'IsActive', 'deleted_at', 'created_at', 
        'CreationIP', 'created_by', 'CreatedByModule', 'updated_at', 
        'UpdationIP', 'updated_by', 'UpdatedByModule'
    ];

}

