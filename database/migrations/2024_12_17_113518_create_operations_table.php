<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOperationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('operations', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('type_id')->nullable();
            $table->integer('quantity')->nullable();
            $table->string('observation')->nullable();
            $table->unsignedBigInteger('bus_id')->nullable();
            $table->string('unit')->nullable();
            $table->foreign('type_id')->references('id')->on('types')->cascadeOnDelete();
            $table->foreign('bus_id')->references('id')->on('buses')->cascadeOnDelete();

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
        Schema::dropIfExists('operations');
    }
}
