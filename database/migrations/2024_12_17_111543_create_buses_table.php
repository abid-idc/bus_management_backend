<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buses', function (Blueprint $table) {
            $table->id();

            $table->string('plate_number')->nullable();
            $table->string('qr_code')->nullable();
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->date('entering_date')->nullable();
            $table->enum('status', ['walk', 'broken'])->default('walk')->nullable();
            $table->integer('next_oil_change_in_km')->nullable();
            $table->date('next_oil_change_date')->nullable();

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
        Schema::dropIfExists('buses');
    }
}
