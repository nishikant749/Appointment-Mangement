<?php

namespace Database\Seeders;

use DB;
use Hash;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    /**
     * @method Create the admin
     *
     * @return void
     */
    public function run()
    {
        #Define admin credentials
        $adminCredentials = [
            'name'      => 'admin',
            'user_type' => 'admin',
            'email'     => 'admin2022@gmail.com', 
            'password'  => Hash::make('Admin@2022')
        ];

        #fetch user
        $userModel = User::where('email', $adminCredentials['email'])->get();

        #Cerate admin
        if($userModel->isEmpty()) {
            DB::beginTransaction();
                #create Admin
                $admin = User::create($adminCredentials);

                #Assign admin role to admin
                $admin->assignRole('admin');
            DB::commit();
        }
    }
}