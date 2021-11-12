<?php

use App\Models\State;
use Illuminate\Database\Seeder;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        State::create([
            'id' => '1',
            'StateName' => 'Sindh',
            'country_id' => '1',
            'Abbreviation' => 'SIN',
        ]);
        // State::create([
        //     'id' => '2',
        //     'StateName' => 'Islamabad',
        //     'country_id' => '1',
        //     'Abbreviation' => 'ISL',
        // ]);
    }
}
