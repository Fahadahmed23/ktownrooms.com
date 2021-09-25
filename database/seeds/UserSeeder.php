<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@test.com',
            'password' => bcrypt('password12'),
            'first_name' => 'Super',
            'last_name' => 'Admin',
            'phone_no' => '0323-8228708',
        ]);
    }
}
