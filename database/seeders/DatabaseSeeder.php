<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

// Import DB and Faker services
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $faker = Faker::create();

    	foreach (range(1,500) as $index) {
            DB::table('company')->insert([
                'CompanyName' => $faker->name,
                'CreationIP' => 'CreationIP',
                'CreatedByUser' =>1,
                'CreatedByModule' =>'company'

            ]);
        }
    }
}
