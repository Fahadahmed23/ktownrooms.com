<?php

use App\Models\ContactType;
use Illuminate\Database\Seeder;

class ContactTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ContactType::create([
            'ContactType' => 'Email',
            'masking_format' => 'email_mask',
        ]);
        ContactType::create([
            'ContactType' => 'Phone',
            'masking_format' => 'phone_us',
        ]);
    }
}
