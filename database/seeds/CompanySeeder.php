<?php

use App\Models\Company;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Company::create([
            'CompanyName' => 'KTown Rooms and Homes',
            'IsActive' => '1',
        ]);
    }
}
