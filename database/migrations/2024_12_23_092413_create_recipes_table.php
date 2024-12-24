<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecipesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recipes', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('notebook_id')->nullable();
            $table->foreign('notebook_id')->references('id')->on('notebooks')->cascadeOnDelete();

            $table->double('amount')->nullable();

            $table->integer('current_index')->nullable();
            $table->integer('last_index')->nullable();

            $table->unsignedBigInteger('line_id')->nullable();
            $table->foreign('line_id')->references('id')->on('lines')->cascadeOnDelete();

            $table->unsignedBigInteger('bus_id')->nullable();
            $table->foreign('bus_id')->references('id')->on('buses')->cascadeOnDelete();

            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();

            $table->unsignedBigInteger('employee_id')->nullable();
            $table->foreign('employee_id')->references('id')->on('employees')->cascadeOnDelete();

            $table->string('observation')->nullable();

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
        Schema::dropIfExists('recipes');
    }
}
