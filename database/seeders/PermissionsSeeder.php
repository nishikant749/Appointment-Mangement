<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionsSeeder extends Seeder
{
    /**
     * Create the initial roles and permissions.
     *
     * @return void
     */
    public function run()
    {
        # Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        #Set Permissions Array
        $permissions = [
            'appointment_create',
            'appointment_edit',
            'appointment_delete',
            'appointment_show',
            'appointment_status_update',
            'doctor.show',
            'doctor.create',
            'doctor.edit',
            'doctor.delete',
            'patient.show',
            'patient.create',
            'patient.edit',
            'patient.delete',
        ];

        #Create the permissions
        foreach ($permissions as $key => $permission) {
            #validate Permisiion
            $permissionModel = Permission::where('name', $permission)->get();

            #Cerate
            if($permissionModel->isEmpty()) {
                Permission::create(['name' => $permission]);
            }
        }
        
        #FEtch roles
        $roles = Role::get();

        #Set patientPermissions
        $patientPermissions = [
            'appointment_create',
            'appointment_edit',
            'appointment_delete',
            'appointment_show',
        ];

        #Set doctorPermissions
        $doctorPermissions = [
            'appointment_show',
            'appointment_status_update',
            'doctor.edit',
        ];

        #validate and assign Permissions
        if($roles->isNotEmpty()) {
            foreach($roles as $key => $role) {
                #Fetch role Name
                $roleName = $role->name;

                #Set permissions
                if($roleName == 'admin') {
                    $permissionsToSet = $permissions;
                } elseif ($roleName == 'patient') {
                    $permissionsToSet = $patientPermissions;
                } elseif ($roleName == 'doctor') {
                    $permissionsToSet = $doctorPermissions;
                }

                #assign the permissions to role
                foreach ($permissionsToSet as $key => $permission) {
                    #validate Permission set on Role 
                    if(!$role->hasPermissionTo($permission)) {
                        $role->givePermissionTo($permission);
                    }
                }
            }
        }
    }
}