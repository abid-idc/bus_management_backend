<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lines', function (Blueprint $table) {
            $table->id();

            $table->string('code')->nullable();
            $table->string('name')->nullable();
            $table->double('price')->nullable();
            $table->boolean('status')->nullable();

            $table->unsignedBigInteger('depart_city_id')->nullable();
            $table->foreign('depart_city_id')->references('id')->on('cities')->cascadeOnDelete();

            $table->unsignedBigInteger('arrival_city_id')->nullable();
            $table->foreign('arrival_city_id')->references('id')->on('cities')->cascadeOnDelete();

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
        Schema::dropIfExists('lines');
    }
}
