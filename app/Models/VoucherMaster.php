<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VoucherMaster extends Model
{
    protected $table = 'vouchers_master';

    protected $appends = ['VoucherTypeName', 'FiscalYearName','UserName'];

    public function voucher_type () {
        return $this->belongsTo(VoucherType::class, 'voucher_type_id', 'id');
    }

    public function fiscal_year () {
        return $this->belongsTo(AccountFiscalYearMaster::class, 'fiscal_year_master_id', 'id');
    }

    public function getVoucherTypeNameAttribute() {
        return $this->voucher_type->title ??'';
    }

    public function getFiscalYearNameAttribute() {
        return $this->fiscal_year->title ?? '';
    }
    

    public function post_user()
    {
        return $this->belongsTo(User::class, 'post_user_id', 'id');
    }

    public function getUserNameAttribute() {
        return $this->post_user->name ?? null;;
    }

    public function voucher_details()
    {
        return $this->hasMany(VoucherDetail::class);
    }
    

}
