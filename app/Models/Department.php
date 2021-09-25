<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    use SoftDeletes;
    
    public $timestamps = false;

    protected $appends = ['CompanyName'];
    public function services()
    {
        return $this->hasMany(Service::class);
    }
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    public function getCompanyNameAttribute()
    {   
        return $this->company->CompanyName ?? null;
    }


    protected $fillable = [
        'company_id','Department','state_id','IsActive', 'deleted_at', 
        'created_at', 'CreationIP', 'created_by', 'CreatedByModule', 'updated_at', 
        'UpdationIP', 'updated_by', 'UpdatedByModule'
    ];
}
