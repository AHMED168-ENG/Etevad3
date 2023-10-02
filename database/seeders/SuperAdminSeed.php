<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
class SuperAdminSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
          //Admin Seeder
        $user = User::create([
            'name' => 'ahmed begada',
            'email' => 'ahmed@ahmed.com',
            'status' => true,
            'password' => bcrypt('01024756410ahmed')
        ]);

        $user->assignRole("super Admin");


    }
}
