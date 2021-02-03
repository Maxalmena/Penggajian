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
            'provider' => 'test',
            'provider_id' => 'test',
            'phone_number' => '081234567890',
            'gender' => 'Male',
            'address' => 'Kemanggisan',
            'role' => 'Member',
            'profile_picture' => 'public/profile_picture/unknown.png'
        ]);
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('admin'),
            'provider' => 'test',
            'provider_id' => 'test',
            'phone_number' => '081234567890',
            'gender' => 'Male',
            'address' => 'Kemanggisan',
            'role' => 'Admin',
            'profile_picture' => 'public/profile_picture/unknown.png'
        ]);
    }
}
