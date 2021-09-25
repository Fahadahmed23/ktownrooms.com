<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Authenticatable
{
    use Notifiable;
    
    use EntrustUserTrait;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'dob',
        'email',
        'password',
        'phone_no',
        'gender',
        'picture',
        'first_login'
    ];

    protected $appends = 
    [
    'HotelName',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function addresses() {
        return $this->hasMany(UserAddress::class);
    }

    public function experiences() {
        return $this->hasMany(UserExperience::class);
    }

    /**
    * @param string|array $roles
    */
    public function authorizeRoles($roles)
    {
        if (is_array($roles)) {
            return $this->hasAnyRole($roles) || abort(401, 'This action is unauthorized.');                    
        }
        
        return $this->hasRole($roles) || abort(401, 'This action is unauthorized.');
                
    }
    /**
    * Check multiple roles
    * @param array $roles
    */
    public function hasAnyRole($roles)
    {
      return null !== $this->roles()->whereIn('name', $roles)->first();
    }

    public function hotel()
    {
        return $this->belongsTo(Hotel::class, 'hotel_id', 'id');
    }
    public function getHotelNameAttribute()
    {
        return $this->hotel->HotelName ?? null;
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id','id');
    }
}
