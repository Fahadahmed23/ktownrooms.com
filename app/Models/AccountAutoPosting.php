<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccountAutoPosting extends Model
{
    protected $table = 'account_auto_posting';
    protected $appends = ['PostingTypeName'];


    public function posting_type () {
        return $this->belongsTo(AccountAutoPostingType::class, 'auto_posting_type_id', 'id');
    }
    public function getPostingTypeNameAttribute() {
        return $this->posting_type->title ??'';
    }
}
