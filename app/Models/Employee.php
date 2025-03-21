<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $table = 'employees'; // Tên bảng

    protected $fillable = [
        'name',
        'email',
        'phone',
        'date_of_birth',
        'address',
        'position',
        'salary',
    ];
}