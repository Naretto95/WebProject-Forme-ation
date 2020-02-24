<?php

use App\Models\Training;
use App\Models\User;
use Illuminate\Foundation\Inspiring;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->describe('Display an inspiring quote');

Artisan::command('ach-interim:clean-database', function () {
    $this->info('Cleaning database...');
    Training::expired()->delete();
    $this->info('Database cleaned.');
})->describe('Clean database');

Artisan::command('ach-interim:create-superadmin', function () {
    $this->info('Creating...');
    User::create([
            'name' => "Thomas MARTIN",
            'email' => "t.martin93300@gmail.com",
            'status' => "super-admin",
            'password' => Hash::make("12345678"),
        ]);
    $this->info('Super admin created.');
})->describe('Create Super Admin account');
