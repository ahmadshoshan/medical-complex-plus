<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class MakeFilamentUser extends Command
{
    protected $signature = 'filament:userx'; // اسم جديد للأمر
    protected $description = 'Create a new Filament user with username';

    public function handle()
    {
        $name = $this->ask('Name');
        $username = $this->ask('Username');
        $email = $this->ask('Email address');
        $password = $this->secret('Password');

        $user = User::create([
            'name'     => $name,
            'username' => $username,
            'email'    => $email,
            'password' => Hash::make($password),
        ]);

        $this->info("User [{$user->name}] with username [{$user->username}] created successfully!");
    }
}
