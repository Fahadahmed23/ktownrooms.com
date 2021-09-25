<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentMode extends Model
{
    use SoftDeletes;
    
    public $timestamps = false;

    protected $fillable = [
        'PaymentMode', 'deleted_at', 'created_at', 
        'CreationIP', 'created_by', 'CreatedByModule', 'updated_at', 
        'UpdationIP', 'updated_by', 'UpdatedByModule'
    ];

}
