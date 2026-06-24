<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admins = [
            [
            'name' => 'Admin',
            'email' => 'superadmin@gmail.com',
            'password' => '12345678',
            ],
        ];

        foreach($admins as $admin)
        {
            Admin::updateOrCreate([
                'email' => $admin['email'],
            ], [
                'name' => $admin['name'],
                'password' => Hash::make($admin['password'])
            ]);
        }
    }
}
