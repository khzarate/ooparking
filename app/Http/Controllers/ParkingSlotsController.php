<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Services\ParkedVehiclesService;
use App\Http\Services\ParkingSlotsService;

use App\Http\Controllers\ParkingFeeController;

class ParkingSlotsController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->parkedVehiclesService = new ParkedVehiclesService();
        $this->parkingSlotsService = new ParkingSlotsService();
        $this->parkingFeeController = new ParkingFeeController();
    }

    public function fetchSlots(){
        return $this->parkingSlotsService->parkingSlotsCount();
    }

    public function convertSlotType($slot_type){
        Switch($slot_type) {
            case "1":
                return "S";
            case "2":
                return "M";
            case "3":
                return "L";
        }
    }

    public function parkVehicle(Request $request){
        if(isset($request->plate_number) && isset($request->vehicle_type) && isset($request->entry_point) && isset($request->time_in)) {

            //Check the available and closest slots from the entry point 
            $slot = $this->parkingSlotsService->getClosestAndAvailableSlot($request->entry_point, $request->vehicle_type);

            if($slot){   
                $time_in = $request->time_in;
                $data = array();
                $data = [
                    "plate_number" => $request->plate_number,
                    "vehicle_type" => $request->vehicle_type,
                    "parking_slot_id" => $slot->id,
                    "time_in" => $time_in,
                    "entry_point" => $request->entry_point
                ];

                //Check the recent parking status of a specific car
                $vehicle = $this->parkedVehiclesService->checkParkedVehicle($request->plate_number);

                if($vehicle == null){
                    //create new parking 
                    $parked = $this->parkedVehiclesService->saveVehicleParking($data);
                    $this->parkingSlotsService->updateParkingSlot($slot->id, $parked->id);

                    $text = "<p>
                            Plate Number: ".$request->plate_number."<br/>".
                            "Parking Slot: ".$slot->id."-".$this->convertSlotType($slot->slot_type)."<br/>".
                            "Time in: ".$time_in."<br/>".
                            "Entry Point: Gate ".$request->entry_point."<br/>".
                            "</p>";

                    return response()->json(['message' => 'Parking successful', "text" => $text], 200);
                } else {
                    //if the car has exited, check if it is already in the 1 HOUR window for continuous parking
                    if($vehicle->time_out != null){
                        $time = $this->parkingFeeController->getTimeDifference($vehicle->time_out, $request->time_in);
    
                        //regardless if 1-59 minutes gap, will still be rounded to 1
                        if($time > 1){
                            //create new parking entry ticket
                            $parked = $this->parkedVehiclesService->saveVehicleParking($data);
                            $this->parkingSlotsService->updateParkingSlot($slot->id, $parked->id);

                            $text = "<p>
                            Plate Number: ".$request->plate_number."<br/>".
                            "Parking Slot: ".$slot->id."-".$this->convertSlotType($slot->slot_type)."<br/>".
                            "Time in: ".$time_in."<br/>".
                            "Entry Point: Gate ".$request->entry_point."<br/>".
                            "</p>";

                            return response()->json(['message' => 'Parking successful', "text" => $text], 200);

                        } else {
                            //update the existing parking ticket, remove the initial time_out, parking_fee, parking_slot_id, and entry point (if they enter on a different entrance)
                            $parked = $this->parkedVehiclesService->updateParkedVehicle($vehicle->id, $slot->id, $request->entry_point);
                            $this->parkingSlotsService->updateParkingSlot($slot->id, $vehicle->id);

                            $text = "<p>
                            (Continuation Parking)"."<br/>".
                            "Plate Number: ".$request->plate_number."<br/>".
                            "Parking Slot: ".$slot->id."-".$this->convertSlotType($slot->slot_type)."<br/>".
                            "Time in: ".$time_in."<br/>".
                            "Entry Point: Gate ".$request->entry_point."<br/>".
                            "</p>";

                            return response()->json(['message' => 'Parking successful', "text" => $text], 200);
                        }
                    } else {
                        //Specific vehicle already parked
                        return response()->json(['message' => 'Vehicle '.$request->plate_number.' is already parked'], 202);
                    }
                }

            } else {
                return response()->json(['message' => 'Full Parking'], 202); 
            }
        } else {
            return response()->json(['message' => 'invalid or incomplete parameters'], 400);
        }
    }
    
    public function unparkVehicle(Request $request){
        if(isset($request->plate_number) && isset($request->exit_point) && isset($request->time_out)){
            //get parked vehicle data
            $vehicle = $this->parkedVehiclesService->checkParkedVehicle($request->plate_number);
            if($vehicle){
                //Check if the vehicle is still parked
                if($vehicle->time_out == null){
                    $time_out = $request->time_out;
                    $parking_slot = $this->parkingSlotsService->getParkingSlot($vehicle->parking_slot_id);
                    $time = $this->parkingFeeController->getTimeDifference($vehicle->time_in, $time_out);
                    $parking_fee = $this->parkingFeeController->parkingFeeComputation($time, $parking_slot->slot_type);

                    $this->parkedVehiclesService->unparkVehicle($vehicle->id, $time_out, $request->exit_point, $parking_fee);
                    $this->parkingSlotsService->updateParkingSlot($parking_slot->id, NULL);


                    $text = "<p>
                            Plate Number: ".$request->plate_number."<br/>".
                            "Parking Slot: ".$parking_slot->id."-".$this->convertSlotType($parking_slot->slot_type)."<br/>".
                            "Parking Fee: ₱".number_format($parking_fee,2)."<br/>".
                            "Time In: ".$vehicle->time_in."<br/>".
                            "Time Out: ".$time_out."<br/>".
                            "Exit Point: Gate ".$request->exit_point."<br/>".
                            "</p>";


                    return response()->json(['message' => 'Exit parking successful', "text" => $text], 200);

                } else {
                    return response()->json(['message' => 'No parked vehicle found'], 202);
                }

            } else {
                return response()->json(['message' => 'No parked vehicle found'], 202);
            }

        } else {
            return response()->json(['message' => 'invalid or incomplete parameters'], 400);
        }
    }
}
