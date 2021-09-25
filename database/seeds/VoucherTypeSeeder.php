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
            'title' => 'Bank Payment Voucher',
            'description' => 'Bank Payment Voucher',
            'abbreviation' => 'BPV',
        ]);
        VoucherType::create([
            'title' => 'Bank Receipt Voucher',
            'description' => 'Bank Receipt Voucher',
            'abbreviation' => 'BRV',
        ]);
        VoucherType::create([
            'title' => 'Cash Receipt Voucher',
            'description' => 'Cash Receipt Voucher',
            'abbreviation' => 'CRV',
        ]);
        VoucherType::create([
            'title' => 'Petty Cash',
            'description' => 'Petty Cash',
            'abbreviation' => 'PC',
        ]);
        VoucherType::create([
            'title' => 'Sales Invoice Voucher',
            'description' => 'Sales Invoice Voucher',
            'abbreviation' => 'SIV',
        ]);
        VoucherType::create([
            'title' => 'Cash Payment Voucher',
            'description' => 'Cash Payment Voucher',
            'abbreviation' => 'CPV',
        ]);
        VoucherType::create([
            'title' => 'Auto Posting',
            'description' => 'Auto Posting',
            'abbreviation' => 'AP',
        ]);
    }
}
