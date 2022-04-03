<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

#Use Seeder classes 
use Database\Seeders\RoleSeeder;
use Database\Seeders\AdminSeeder;
use Database\Seeders\PermissionsSeeder;
use Database\Seeders\AppointmentSlotSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        #Call the Seeders
        $this->call([
            RoleSeeder::class,
            AdminSeeder::class,
            PermissionsSeeder::class,
            AppointmentSlotSeeder::class,
        ]);
    }
}
