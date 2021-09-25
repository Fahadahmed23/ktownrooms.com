<?php

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class PermissionRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $permissions = Permission::where('group', '!=', 'Frontdesk')->get();
        $role = Role::where('name', 'Admin')->first();
        $role->permissions()->attach($permissions);
    }
}
