<?php

use App\Models\Channel;
use Illuminate\Database\Seeder;

class ChannelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Channel::create([
            'Channel' => 'Walk-In',
            'additionalInfo' => '0',
            'isShowPropertyLevel' => '0',
        ]);
        Channel::create([
            'Channel' => 'On Call',
            'additionalInfo' => '0',
            'isShowPropertyLevel' => '0',
        ]);
        Channel::create([
            'Channel' => 'Email',
            'additionalInfo' => '0',
            'isShowPropertyLevel' => '0',
        ]);
        Channel::create([
            'Channel' => 'Phone',
            'additionalInfo' => '0',
            'isShowPropertyLevel' => '0',
        ]);
        Channel::create([
            'Channel' => 'Aggregators',
            'additionalInfo' => '0',
            'isShowPropertyLevel' => '0',
        ]);
        Channel::create([
            'Channel' => 'Ktown Website',
            'additionalInfo' => '0',
            'isShowPropertyLevel' => '0',
        ]);
    }
}
