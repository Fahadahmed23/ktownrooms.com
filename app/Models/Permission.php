<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Zizaco\Entrust\EntrustPermission;
use Illuminate\Support\Facades\Auth;

class Permission extends EntrustPermission
{
    // use HasFactory;

    // protected $fillable = [
    //     'id', 'name', 'display_name', 'description', 'url', 'view_name', 'group', 'is_active'
    // ];
    use BaseModelTrait;

	public function __construct()
    {
        parent::__construct();
    }   
}
