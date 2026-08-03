<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    /** @use HasFactory<\Database\Factories\EmployeeFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'position',
        'hire_date',
        'salary',
        'user_id',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function salaryPayments()
    {
        return $this->hasMany(\App\Models\SalaryPayment::class);
    }

    public function advances()
    {
        return $this->hasMany(\App\Models\EmployeeAdvance::class);
    }
}
