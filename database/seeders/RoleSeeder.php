<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use App\Helpers\Generate;

class RoleSeeder extends Seeder
{
    /**
    * Run the database seeds.
    *
    * @return void
    */
    public function run()
    {
        $roles = [
            [
                'uuid' => 'f8324326-4ed6-11ef-aaf8-9a039bff5563',
                'role' => 'Admin'
            ],
            [
                'uuid' => '41d05a9a-4ed7-11ef-985b-9a039bff5563',
                'role' => 'Tenant'
            ]
        ];

        foreach ($roles as $role) {
            Role::insert([
                [
                    'uuid' => $role['uuid'],
                    'name' => $role['role'],
                    'code' => '',
                    'description' => ''
                ]
            ]);
        }
    }
}
