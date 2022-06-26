<?php

namespace App\Http\Services;

use Illuminate\Http\Request;

use App\Models\ParkingSlots;
use App\Models\ParkedVehicles;

class ParkingSlotsService 
{
    public function getParkingSlot($id){
        return ParkingSlots::where('id', $id)->first();
    }

    public function getClosestAndAvailableSlot($entry_point, $vehicle_type){
        $available_slot = ParkingSlots::where('parked_vehicle_id', NULL);
        switch ($vehicle_type) {
            case 'S':
                $available_slot = $available_slot->whereIn('slot_type', ['1', '2', '3']);
                break;
            case 'M':
                $available_slot = $available_slot->whereIn('slot_type', ['2', '3']);
                break;
            case 'L':
                $available_slot = $available_slot->whereIn('slot_type', ['3']);
                break;
        }

        $available_slot = $available_slot->orderBy('slot_type', 'ASC');

        switch ($entry_point) {
            case '1':
                $available_slot = $available_slot->orderBy('entry_1_distance', 'ASC');
                break;
            case '2':
                $available_slot = $available_slot->orderBy('entry_2_distance', 'ASC');
                break;
            case '3':
                $available_slot = $available_slot->orderBy('entry_3_distance', 'ASC');
                break;
        }

        $available_slot = $available_slot->first();

        return ($available_slot);
    }

    public function updateParkingSlot($id, $parked_vehicle_id){
        return ParkingSlots::where('id', $id)->update(['parked_vehicle_id' => $parked_vehicle_id]);
    }

}