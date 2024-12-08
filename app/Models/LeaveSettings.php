<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveSettings extends Model
{
    use HasFactory;

    protected $table = 'leave_settings';
    protected $guarded = [];

    protected $casts = [
        'details' => 'array'
    ];
}
