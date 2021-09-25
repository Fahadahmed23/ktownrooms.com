<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccountGeneralLedger extends Model
{
    protected $table = 'account_gl';
    protected $appends = 
    ['AccountTypeName','AccountLevelName'];
    
    public function account_type() {
        return $this->belongsTo(AccountType::class, 'account_type_id', 'id');
    }

    public function account_level() {
        return $this->belongsTo(AccountLevel::class, 'account_level_id', 'id');
    }

    public function getAccountTypeNameAttribute() {
        return $this->account_type->title ?? null;
    }

    public function getAccountLevelNameAttribute() {
        return $this->account_level->name ?? null;
    }

    
    // public function voucher_details() {
    //     return $this->hasMany(VoucherDetail::class, 'id' , 'account_gl_id');
    // }

    // public function getDebitSumAttribute() {
    //     return $this->voucher_details->sum('dr_amount');
    // }

    // public function getCreditSumAttribute() {
    //     return $this->voucher_details->sum('cr_amount');
    // }



}
