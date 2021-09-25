<?php

use App\Models\AccountType;
use Illuminate\Database\Seeder;

class AccountTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AccountType::create([
            'title' => 'Assets',
            'initial_state' => '10',
            'interval' => '2',
            'description' => 'Assets',
            'posting_type' => 'BS',
        ]);
        AccountType::create([
            'title' => 'Liability',
            'initial_state' => '20',
            'interval' => '2',
            'description' => 'Liability',
            'posting_type' => 'BS',
        ]);
        AccountType::create([
            'title' => 'Equity ',
            'initial_state' => '30',
            'interval' => '2',
            'description' => 'Equity ',
            'posting_type' => 'BS',
        ]);
        AccountType::create([
            'title' => 'Revenue',
            'initial_state' => '40',
            'interval' => '2',
            'description' => 'Revenue',
            'posting_type' => 'PL',
        ]);
        AccountType::create([
            'title' => 'Expense',
            'initial_state' => '50',
            'interval' => '2',
            'description' => 'Expense',
            'posting_type' => 'PL',
        ]);
        AccountType::create([
            'title' => 'Capital',
            'initial_state' => '60',
            'interval' => '2',
            'description' => 'Capital',
            'posting_type' => 'PL',
        ]);
    }
}
