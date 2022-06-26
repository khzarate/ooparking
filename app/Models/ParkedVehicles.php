<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParkedVehicles extends Model
{
    use HasFactory;

    protected $table = 'parked_vehicles';

    protected $fillable = [
      "plate_number",
      "vehicle_type",
      "parking_slot_id",
      "time_in",
      "time_out",
      "parking_fee",
      "entry_point",
      "exit_point",
    ];
}
