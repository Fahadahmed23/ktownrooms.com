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
            'RoomType' => 'Budget',
        ]);
        RoomType::create([
            'RoomType' => 'Quad Room',
        ]);
        RoomType::create([
            'RoomType' => 'Deluxe Room',
        ]);
        RoomType::create([
            'RoomType' => 'Family Hall',
        ]);
    }
}
