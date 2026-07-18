<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;



class User extends Authenticatable
// implements FilamentUser
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * Determine if the user can access the Filament panel.
     *
     * @param \Filament\Panel $panel
     * @return bool
     */


    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'home_page',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }





    public function doctor(): HasOne
    {
        return $this->hasOne(Doctor::class);
    }

    public function employee()
    {
        return $this->hasOne(\App\Models\Employee::class);
    }






    // public function canAccessPanel(\Filament\Panel $panel): bool
    // {
    //     // $this->getFilamentUrl();
    //     //    dd($this->getFilamentUrl());
    //     // dd ($this->hasRole('admin'));
    //     // Example: Only users with 'admin' role can access the panel
    //     // return $this->hasRole(['admin','doctor','user']);


    //     return true;
    // }



}
