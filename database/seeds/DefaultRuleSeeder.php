<?php

use App\Models\DefaultRule;
use Illuminate\Database\Seeder;

class DefaultRuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DefaultRule::create([
            'checkin_time' => '14:00:00',
            'checkout_time' => '12:00:00',
        ]);
    }
}
