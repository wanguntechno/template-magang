<?php

namespace Database\Seeders;

use App\Helpers\Generate;
use App\Models\User;
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
        User::insert([
            [
                'uuid' => '60aa43cc-4ed7-11ef-a624-9a039bff5563',
                'username' => 'master_admin',
                'password' => bcrypt('password'),
            ],
        ]);
    }
}
