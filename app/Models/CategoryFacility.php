<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoryFacility extends Model
{
    use SoftDeletes;

    // public function facilities() {
    //     return $this->belongsToMany(Facility::class);
    // }
    protected $fillable = [
        'roomcategory_id','facility_id','IsDeleted','deleted_at', 'created_at', 
        'CreationIP', 'created_by', 'CreatedByModule', 'updated_at', 
        'UpdationIP', 'updated_by', 'UpdatedByModule'
    ];

}
