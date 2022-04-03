<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableAppointments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('patient_id')->index()->default(0);
            $table->unsignedInteger('doctor_id')->index();
            $table->unsignedInteger('slot_id')->index();
            $table->string('email', 100)->index()->nullable();
            $table->string('disease')->index()->nullable();
            $table->dateTime('visit_date')->index()->nullable();
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
        Schema::dropIfExists('appointments');
    }
}
