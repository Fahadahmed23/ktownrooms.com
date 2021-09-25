<?php

use App\Models\AccountAutoPostingType;
use Illuminate\Database\Seeder;

class AccountAutoPostingTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AccountAutoPostingType::create([
            'title' => 'checkedin',
            'is_active' => '1',
        ]);
        AccountAutoPostingType::create([
            'title' => 'accept service',
            'is_active' => '1',
        ]);
        AccountAutoPostingType::create([
            'title' => 'partial payment',
            'is_active' => '1',
        ]);
        AccountAutoPostingType::create([
            'title' => 'booking extended',
            'is_active' => '1',
        ]);
    }
}
