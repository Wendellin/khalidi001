<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name'=>'Admin',
            'email'=>'admin@gmail.com',
            'role_id'=>1,
            'password'=>Hash::make('admin@gmail.com')
        ]);

        DB::table('users')->insert([
            'name'=>'Doctor',
            'email'=>'doctor@gmail.com',
            'role_id'=>2,
            'password'=>Hash::make('doctor@gmail.com')
        ]);

        DB::table('users')->insert([
            'name'=>'Assistant',
            'email'=>'assistant@gmail.com',
            'role_id'=>3,
            'password'=>Hash::make('assistant@gmail.com')
        ]);

        DB::table('users')->insert([
            'name'=>'Patient',
            'email'=>'patient@gmail.com',
            'role_id'=>4,
            'password'=>Hash::make('patient@gmail.com')
        ]);
    }
}
