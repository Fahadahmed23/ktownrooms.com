<?php

use App\Models\TaxRate;
use Illuminate\Database\Seeder;

class TaxRateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TaxRate::create([
            'Tax' => 'GST',
            'TaxValue' => '13.00',
            'IsDefault' => '1',
            'IsActive' => '1',
        ]);
    }
}
