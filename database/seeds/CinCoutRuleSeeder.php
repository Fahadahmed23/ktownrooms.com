<?php

use App\Models\CinCoutRule;
use Illuminate\Database\Seeder;

class CinCoutRuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CinCoutRule::create([
            'rule_type' => 'early_check_in',
            'start_time' => '09:00:00',
            'end_time' => '10:45:00',
            'charges' => '1000.00',
        ]);
        CinCoutRule::create([
            'rule_type' => 'early_check_in',
            'start_time' => '08:00:00',
            'end_time' => '09:00:00',
            'charges' => '1500.00',
        ]);
        CinCoutRule::create([
            'rule_type' => 'early_check_in',
            'start_time' => '06:00:00',
            'end_time' => '07:00:00',
            'charges' => '2500.00',
        ]);
        CinCoutRule::create([
            'rule_type' => 'early_check_in',
            'start_time' => '00:00:00',
            'end_time' => '05:00:00',
            'charges' => '4000.00',
        ]);
        CinCoutRule::create([
            'rule_type' => 'late_check_out',
            'start_time' => '15:00:00',
            'end_time' => '16:00:00',
            'charges' => '1000.00',
        ]);
        CinCoutRule::create([
            'rule_type' => 'late_check_out',
            'start_time' => '17:00:00',
            'end_time' => '18:00:00',
            'charges' => '1500.00',
        ]);
        CinCoutRule::create([
            'rule_type' => 'late_check_out',
            'start_time' => '18:00:00',
            'end_time' => '19:00:00',
            'charges' => '2500.00',
        ]);
        CinCoutRule::create([
            'rule_type' => 'late_check_out',
            'start_time' => '19:00:00',
            'end_time' => '00:00:00',
            'charges' => '4000.00',
        ]);
    }
}
