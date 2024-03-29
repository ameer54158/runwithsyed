<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //$userRole = config('roles.models.role')::where('name', '=', 'User')->first();
        $adminRole = config('roles.models.role')::where('name', '=', 'Admin')->first();
        $permissions = config('roles.models.permission')::all();

        /*
         * Add Users
         *
         */
        if (config('roles.models.defaultUser')::where('email', '=', 'admin@digitalmx.no')->first() === null) {
            $newUser = config('roles.models.defaultUser')::create([
                'first_name'     => 'DMX',
                'last_name'     => 'Admin',
                'email'    => 'admin@digitalmx.no',
                'status' => 1,
                'password' => bcrypt('gujratdmx123'),
            ]);

            $newUser->attachRole($adminRole);
            foreach ($permissions as $permission) {
                $newUser->attachPermission($permission);
            }
        }
        /* We don't need user role as default
        if (config('roles.models.defaultUser')::where('email', '=', 'user@user.com')->first() === null) {
            $newUser = config('roles.models.defaultUser')::create([
                'name'     => 'User',
                'email'    => 'user@user.com',
                'password' => bcrypt('password'),
            ]);

            $newUser;
            $newUser->attachRole($userRole);
        } */
    }
}
