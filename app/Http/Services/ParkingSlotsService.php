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

        //get possible parking slot type for the specific vehicle type
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

        //get the closest available slot from the vehicle's entry_point
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

    public function parkingSlotsCount(){
        $count = array();

        $SP = ParkingSlots::where('slot_type', 1)->get();
        $s_count = 0; $s_parked = 0;
        foreach($SP as $p){
            if($p->parked_vehicle_id != null){
                $s_parked++;
            }
            $s_count++;
        }
        $count['SP'][0] = $s_parked;
        $count['SP'][1] = $s_count;

        $MP = ParkingSlots::where('slot_type', 2)->get();
        $m_count = 0; $m_parked = 0;
        foreach($MP as $p){
            if($p->parked_vehicle_id != null){
                $m_parked++;
            }
            $m_count++;
        }
        $count['MP'][0] = $m_parked;
        $count['MP'][1] = $m_count;

        $LP = ParkingSlots::where('slot_type', 3)->get();
        $l_count = 0; $l_parked = 0;
        foreach($LP as $p){
            if($p->parked_vehicle_id != null){
                $l_parked++;
            }
            $l_count++;
        }
        $count['LP'][0] = $l_parked;
        $count['LP'][1] = $l_count;

        return $count;
    
    }

}