<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoodsReceiveNote extends Model
{
    public function puchase_order(){
        return $this->belongsTo(PurchaseOrder::class,'purchase_order_id', 'id');
    }
    public function grn_details()
    {
        return $this->hasMany(GoodsReceiveNoteDetail::class);
    }
}
