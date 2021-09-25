<?php

use App\Models\RoomType;
use Illuminate\Database\Seeder;

class RoomTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RoomType::create([
            'RoomType' => 'Premium',
        ]);
        RoomType::create([
            'RoomType' => 'Elite',
        ]);
        RoomType::create([
            'RoomType' => 'Classic',
        ]);
    }
}
