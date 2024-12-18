<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, HasPermissions;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    protected function google2faSecret(): Attribute
    {
        return new Attribute(
            get: fn($value) => $value,
            set: fn($value) => $value,
        );
    }

    public function role() : BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function designation() : BelongsTo
    {
        return $this->belongsTo(DesignationDetails::class , 'designation_id' , 'id');
    }

    public function address() : HasOne
    {
        return $this->hasOne(EmployeeAddressDetails::class , 'employee_id' , 'id');
    }

    public function educations() : HasMany
    {
        return $this->hasMany(EmployeeEducationDetails::class , 'employee_id' , 'id');
    }

    public function experiences() : HasMany
    {
        return $this->hasMany(EmployeeExperienceDetails::class , 'employee_id' , 'id');
    }

    public function documents() : HasMany
    {
        return $this->hasMany(EmployeeDocumentsDetails::class , 'employee_id' , 'id');
    }

    public function leaveBalance() : HasOne
    {
        return $this->hasOne(LeaveBalance::class , 'employee_id');
    }
}
