<?php

use Illuminate\Database\Seeder;

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
            'name' => 'Member',
            'email' => 'member@member.com',
            'password' => bcrypt('member'),
            'phone_number' => '081234567890',
            'gender' => 'Male',
            'address' => 'Kemanggisan',
            'role' => 'User',
            'profile_picture' => 'public/profile_picture/unknown.png'
        ]);
    }
}
