<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Create User using seeder
        $user = [
            ['name'=>'Admin','email'=>'admin@aspireapp.com','is_admin'=>1,'password'=>Hash::make('admin123')],
            ['name'=>'Arun','email'=>'arun@aspireapp.com','is_admin'=>0,'password'=>Hash::make('user123')]
        ];

        User::insert($user);
    }
}
