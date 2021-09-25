<?php

use App\Models\PaymentType;
use Illuminate\Database\Seeder;

class PaymentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PaymentType::create([
            'PaymentMode' => 'Cash',
        ]);
        PaymentType::create([
            'PaymentMode' => 'Cheque',
        ]);
        PaymentType::create([
            'PaymentMode' => 'Credit Card',
        ]);
    }
}
