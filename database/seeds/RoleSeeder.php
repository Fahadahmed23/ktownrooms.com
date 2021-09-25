<?php

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'name' => 'Admin',
            'display_name' => 'Admin',
            'landing_page' => '/reports',
            'preference' => 1,
            'is_system' => 1,
            'has_discount_priviledge' => 1,
            'created_by' => 1,
            'updated_by' => 1,
            'created_by_module' => 'Role Seeder',
            'created_by_ip' => '0.0.0.0'
        ];
        $role = new Role();
        $role->fill($data);
        $role->save($data);
        
    }
}
