<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerComplain extends Model
{
    use SoftDeletes;
    protected $appends = ['CalculateHoursAgo'];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id', 'id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }

    public function status()
    {
        return $this->belongsTo(ComplainStatus::class, 'complain_status_id', 'id');
    }

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id', 'id');
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id', 'id');
    }

    public function priority()
    {
        return $this->belongsTo(TaskPriority::class, 'priority_id', 'id');
    }

    public function getCalculateHoursAgoAttribute()
    {
        $now = Carbon::now();
        $created_at = Carbon::parse($this->created_at);
        // $diffHuman = $created_at->diffForHumans($now); // 3 Months ago
        $diffHours = $created_at->diffInHours($now);
        return $diffHours ?? null;
    }
}