<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VoucherDetail extends Model
{
    protected $table = 'voucher_details';
    protected $appends = ['VoucherName', 'AccountHeadName','AccountHeadCode'];

    public function voucher()
    {
        return $this->belongsTo(VoucherMaster::class,'voucher_master_id' , 'id');
    }

    public function account_head () {
        return $this->belongsTo(AccountGeneralLedger::class, 'account_gl_id', 'id');
    }
    public function getAccountHeadCodeAttribute()
    {
        return $this->account_head->account_gl_code ?? '';

    }
    public function getVoucherNameAttribute() {
        return $this->voucher->voucher_no ?? '';
    }
    public function getAccountHeadNameAttribute() {
        return $this->account_head->title ?? '';
    }
}
