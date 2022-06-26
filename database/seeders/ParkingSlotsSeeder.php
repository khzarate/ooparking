<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\ParkingSlots;

class ParkingSlotsSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //Small (S) Type
        ParkingSlots::create([
          'slot_type' => '1',
          'entry_1_distance' => 1,
          'entry_2_distance' => 5,
          'entry_3_distance' => 9,
        ]);
        ParkingSlots::create([
          'slot_type' => '1',
          'entry_1_distance' => 2,
          'entry_2_distance' => 4,
          'entry_3_distance' => 8,
        ]);
        ParkingSlots::create([
          'slot_type' => '1',
          'entry_1_distance' => 3,
          'entry_2_distance' => 3,
          'entry_3_distance' => 7,
        ]);


        //Medium (M) Type
        ParkingSlots::create([
          'slot_type' => '2',
          'entry_1_distance' => 4,
          'entry_2_distance' => 2,
          'entry_3_distance' => 6,
        ]);
        ParkingSlots::create([
          'slot_type' => '2',
          'entry_1_distance' => 5,
          'entry_2_distance' => 1,
          'entry_3_distance' => 5,
        ]);
        ParkingSlots::create([
          'slot_type' => '2',
          'entry_1_distance' => 6,
          'entry_2_distance' => 2,
          'entry_3_distance' => 4,
        ]);

        //Large (L) Type
        ParkingSlots::create([
          'slot_type' => '3',
          'entry_1_distance' => 7,
          'entry_2_distance' => 3,
          'entry_3_distance' => 3,
        ]);
        ParkingSlots::create([
          'slot_type' => '3',
          'entry_1_distance' => 8,
          'entry_2_distance' => 4,
          'entry_3_distance' => 2,
        ]);
        ParkingSlots::create([
          'slot_type' => '3',
          'entry_1_distance' => 9,
          'entry_2_distance' => 5,
          'entry_3_distance' => 1,
        ]);
    }
}
