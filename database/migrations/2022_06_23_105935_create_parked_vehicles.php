<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parked_vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('plate_number', 15);
            $table->char('vehicle_type', 1);
            $table->unsignedBigInteger('parking_slot_id');
            $table->dateTime('time_in')->nullable();
            $table->dateTime('time_out')->nullable();
            $table->float('parking_fee')->nullable();
            $table->integer('entry_point')->nullable();
            $table->integer('exit_point')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('parked_vehicles');
    }
};
