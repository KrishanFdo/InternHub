<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::create([
            'fname'=>'Aruna',
            'lname'=>'Lorensuhewa',
            'email'=>'aruna@dcs.ruh.ac.lk',
            'password'=>Hash::make('aruna@dcs01')
        ]);

        Admin::create([
            'fname'=>'Krishan',
            'lname'=>'Fernando',
            'email'=>'krishanfernando129@gmail.com',
            'password'=>Hash::make('krish')
        ]);
    }
}
