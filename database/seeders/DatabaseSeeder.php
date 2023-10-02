<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\PermissionSeed;
use Database\Seeders\SuperAdminSeed;
use Database\Seeders\AddSetingSeed;
use Database\Seeders\AboutUsSeed;
use Database\Seeders\RolesSeed;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            PermissionSeed::class,
            RolesSeed::class,
            AddSetingSeed::class,
            AboutUsSeed::class,
            SuperAdminSeed::class,
        ]);
    }
}
