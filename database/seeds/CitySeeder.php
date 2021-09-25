<?php

use App\Models\City;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        City::create([
            'id' => '1',
            'CityName' => 'Karachi',
            'country_id' => '1',
            'state_id' => '1',
            'Abbreviation' => 'KHI',
            'IsActive' => '1',
        ]);
        City::create([
            'id' => '2',
            'CityName' => 'Islamabad',
            'country_id' => '1',
            'state_id' => '2',
            'Abbreviation' => 'ISL',
            'IsActive' => '1',
        ]);
    }
}
