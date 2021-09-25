<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccountGeneralLedgerMapping extends Model
{
    protected $table = 'account_gl_mapping';
    protected $guarded = [];

    public function account () {
        return $this->belongsTo(AccountGeneralLedger::class, 'account_gl_id', 'id');
    }
    
}
