<?php

use App\Models\VoucherType;
use Illuminate\Database\Seeder;

class VoucherTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        VoucherType::create([
            'title' => 'Journal Voucher',
            'description' => 'Journal Voucher',
            'abbreviation' => 'JV',
        ]);
        VoucherType::create([
            'title' => 'Auto Posting',
            'description' => 'Auto Posting',
            'abbreviation' => 'AP',
        ]);
    }
}
