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
        User::create([
            'email' => 'admin@demo.com',
            'phone' => '',
            'password' => Hash::make('admin'),
            'name' => 'Bách Nguyễn',
            'referral_code' => 'PTIT2019',
            'referrer_id' => '',
            'role_id' => 2,
            'remember_token' => '',
            'is_active' => 1,
        ]);
    }
}
