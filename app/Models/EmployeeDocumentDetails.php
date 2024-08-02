<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeDocumentDetails extends Model
{
    use HasFactory;

    protected $fillable=[
        'employee_id',
        'file_type',
        'file_name',
        'file_path',
        'file_extension',
        'file_size'
    ];
}
