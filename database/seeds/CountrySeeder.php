<?php

use App\Models\Country;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Country::create([
            'id' => '1',
            'CountryName' => 'Pakistan',
            'Abbreviation' => 'PK',
        ]);
    }
}
