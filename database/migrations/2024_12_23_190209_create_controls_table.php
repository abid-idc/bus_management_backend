<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateControlsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('controls', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('bus_id')->nullable();
            $table->foreign('bus_id')->references('id')->on('buses')->cascadeOnDelete();

            $table->unsignedBigInteger('employee_id')->nullable();
            $table->foreign('employee_id')->references('id')->on('employees')->cascadeOnDelete();

            $table->unsignedBigInteger('line_id')->nullable();
            $table->foreign('line_id')->references('id')->on('lines')->cascadeOnDelete();

            $table->string('bus_status')->nullable();
            $table->string('driver_status')->nullable();
            $table->string('receiver_status')->nullable();
            $table->string('road_status')->nullable();

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
        Schema::dropIfExists('controls');
    }
}
