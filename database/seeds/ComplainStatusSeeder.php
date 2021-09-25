<?php

use App\Models\ComplainStatus;
use Illuminate\Database\Seeder;

class ComplainStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ComplainStatus::create([
            'ComplainStatus' => 'Open',
            'style_class' => 'bg-grey-300',
        ]);
        ComplainStatus::create([
            'ComplainStatus' => 'On Hold',
            'style_class' => 'bg-warning',
        ]);
        ComplainStatus::create([
            'ComplainStatus' => 'Resolved',
            'style_class' => 'bg-success',
        ]);
        ComplainStatus::create([
            'ComplainStatus' => 'Closed',
            'style_class' => 'bg-danger',
        ]);
        ComplainStatus::create([
            'ComplainStatus' => 'Duplicate',
            'style_class' => 'bg-info',
        ]);
    }
}
