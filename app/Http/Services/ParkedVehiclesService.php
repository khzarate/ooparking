<?php

namespace App\Http\Services;

use Illuminate\Http\Request;

use App\Models\ParkingSlots;
use App\Models\ParkedVehicles;

class ParkedVehiclesService // extends BaseService
{

    public function checkParkedVehicle($plate_number){
      return ParkedVehicles::where('plate_number', $plate_number)->orderBy('updated_at', 'DESC')->first();
    }

    public function saveVehicleParking($data){
      return ParkedVehicles::create([
        'plate_number' => $data['plate_number'],
        'vehicle_type' => $data['vehicle_type'],
        'parking_slot_id' => $data['parking_slot_id'],
        'time_in' => $data['time_in'],
        'entry_point' => $data['entry_point']
      ]);
    }

    public function updateParkedVehicle($id, $parking_slot_id, $entry_point){
      return ParkedVehicles::where('id', $id)->update(['time_out' => NULL, 'parking_fee' => NULL, 'parking_slot_id' => $parking_slot_id, 'entry_point' => $entry_point, 'exit_point' => NULL]);
    }

    public function unparkVehicle($id, $time_out, $exit_point, $parking_fee){
      return ParkedVehicles::where('id', $id)->update(['time_out' => $time_out, 'exit_point' => $exit_point, 'parking_fee' => $parking_fee]);
    }

}