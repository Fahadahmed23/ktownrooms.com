<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CorporateType extends Model
{
    use SoftDeletes;
    protected $table = 'corporate_types';
}
