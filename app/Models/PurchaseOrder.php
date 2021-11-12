<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    protected $appends = ['HotelName','InventoryCount','VendorName'];

    public function details(){
        return $this->hasMany(PurchaseOrderDetail::class);
    }
    public function hotel(){
        return $this->belongsTo(Hotel::class, 'hotel_id', 'id');
    }
    public function vendor(){
        return $this->belongsTo(Vendor::class, 'vendor_id', 'id');
    }
    public function getInventoryCountAttribute()
    {
        return $this->details()->count();
    }
    public function getHotelNameAttribute(){
        return $this->hotel->HotelName ?? null;
    }
    public function getVendorNameAttribute(){
        return $this->vendor->Name ?? null;
    }
}
