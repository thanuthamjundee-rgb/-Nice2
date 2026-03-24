<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
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
        DB::table('users')->insert([
            'firstname' => 'admin',
            'lastname' => 'admin',
            'email' => 'devtai@gmail.com',
            'mobile' => '098xxxxxxx',
            'password' => Hash::make('12345678'),
            'p_id' => 1,
            'dep_id' => 1,
            'level_id' => 1,
            'created_at' => now(),
            'updated_at' => now(), 
        ]);
    }
}
