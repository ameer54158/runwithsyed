<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
         * Role Types
         *
         */
        $RoleItems = [
            [
                'name'        => 'Admin',
                'slug'        => 'admin',
                'description' => 'Admin role',
                'level'       => 1,
            ],
            [
                'name'        => 'Ambassador',
                'slug'        => 'ambassador',
                'description' => 'Ambassador role',
                'level'       => 2,
            ],
            [
                'name'        => 'Sponsor',
                'slug'        => 'sponsor',
                'description' => 'Sponsor role',
                'level'       => 3,
            ],
            [
                'name'        => 'Contributor',
                'slug'        => 'contributor',
                'description' => 'Contributor role',
                'level'       => 4,
            ],
        ];

        /*
         * Add Role Items
         *
         */
        foreach ($RoleItems as $RoleItem) {
            $newRoleItem = config('roles.models.role')::where('slug', '=', $RoleItem['slug'])->first();
            if ($newRoleItem === null) {
                $newRoleItem = config('roles.models.role')::create([
                    'name'          => $RoleItem['name'],
                    'slug'          => $RoleItem['slug'],
                    'description'   => $RoleItem['description'],
                    'level'         => $RoleItem['level'],
                ]);
            }
        }
    }
}
