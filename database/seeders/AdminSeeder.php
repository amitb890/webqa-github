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
            'name' => 'Webqa',
            'username' => 'webqa',
            'email' => 'webqa@webqa.co',
            'password' => '12345678',
            ],
        ];

        foreach($admins as $admin)
        {
            Admin::updateOrCreate([
                'username' => $admin['username'],
            ], [
                'name' => $admin['name'],
                'email' => $admin['email'],
                'password' => Hash::make($admin['password'])
            ]);
        }
    }
}
