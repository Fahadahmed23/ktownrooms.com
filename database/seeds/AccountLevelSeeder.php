<?php

use App\Models\AccountLevel;
use Illuminate\Database\Seeder;

class AccountLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AccountLevel::create([
            'level_no' => '1',
            'name' => 'First',
            'length' => '2',
            'is_entry_level' => '0',
            'is_active' => '1',
            'separator' => '-',
        ]);
        AccountLevel::create([
            'level_no' => '2',
            'name' => 'Second',
            'length' => '2',
            'is_entry_level' => '0',
            'is_active' => '1',
            'separator' => '-',
        ]);
        AccountLevel::create([
            'level_no' => '3',
            'name' => 'Third',
            'length' => '2',
            'is_entry_level' => '0',
            'is_active' => '1',
            'separator' => '-',
        ]);
        AccountLevel::create([
            'level_no' => '4',
            'name' => 'Fourth',
            'length' => '2',
            'is_entry_level' => '0',
            'is_active' => '1',
            'separator' => '-',
        ]);
        AccountLevel::create([
            'level_no' => '5',
            'name' => 'Fifth',
            'length' => '3',
            'is_entry_level' => '1',
            'is_active' => '1',
            'separator' => '-',
        ]);
    }
}
