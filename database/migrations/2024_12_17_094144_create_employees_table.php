<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();

            $table->string('name')->nullable();
            $table->string('email')->nullable()->unique();
            $table->string('phone_number')->unique();
            $table->string('password')->nullable();
            $table->string('image')->nullable();
            $table->date('recruitment_date')->nullable();

            $table->unsignedBigInteger('specialty_id')->nullable();
            $table->foreign('specialty_id')->references('id')->on('specialties')->cascadeOnDelete();

            $table->enum('role', ['user', 'admin', 'consultant', 'driver', 'receiver', 'controller', 'accountant', 'workshop_responsible', 'intervener'])->default('user')->nullable();

            $table->rememberToken();

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
        Schema::dropIfExists('employees');
    }
}
