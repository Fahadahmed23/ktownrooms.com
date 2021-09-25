<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoomCategory extends Model
{
    use SoftDeletes;
    
    public function facilities()
    {
        return $this->belongsToMany(Facility::class, 'category_facilities');
    }

    protected $fillable = [
        'RoomCategory','AllowedOccupants','MaxAllowedOccupants','deleted_at','created_at', 
        'CreationIP', 'created_by', 'CreatedByModule','updated_at', 
        'UpdationIP', 'updated_by', 'UpdatedByModule'
    ];
}
