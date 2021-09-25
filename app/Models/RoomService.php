<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoomService extends Model
{
    use SoftDeletes;   
    protected $table = "room_services";
    // public $timestamps = false;

    // protected $fillable = [
    //     'CompanyName','IsActive', 'deleted_at', 'created_at', 
    //     'CreationIP', 'created_by', 'CreatedByModule', 'updated_at', 
    //     'UpdationIP', 'updated_by', 'UpdatedByModule'
    // ];

}
