<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * @method Create the initial roles 
     *
     * @return void
     */
    public function run()
    {
        #Set roles array
        $roles = ['admin', 'patient', 'doctor'];

        #Create the roles
        foreach ($roles as $key => $role) {
            #Fetch role model on name
            $roleModel = Role::where('name', $role)->get();

            #Validate role 
            if($roleModel->isEmpty()) {
                #Create the new role
                Role::create(['name' => $role]);
            } else {
                #update the role
                $roleModel->first()->update(['name' => $role]);
            }
        }
    }
}