<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Services\ParkedVehiclesService;
use App\Http\Services\ParkingSlotsService;

class ParkedVehicleController extends Controller
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
    }


}
