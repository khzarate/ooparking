<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParkingSlots extends Model
{
    use HasFactory;

    protected $table = 'parking_slots';

    protected $fillable = [
      "slot_type",
      "parked_vehicle_id",
      "entry_1_distance",
      "entry_2_distance",
      "entry_3_distance",
    ];
}
