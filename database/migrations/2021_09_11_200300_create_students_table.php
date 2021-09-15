<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('password');
            $table->bigInteger('country_id');
            $table->bigInteger('classroom_id');
            $table->bigInteger('term_id');
            $table->string('device_serial');
            $table->date('start_trial_date')->nullable();
            $table->date('end_trial_date')->nullable();
            $table->text('note')->nullable();
            $table->date('start_paid_date')->nullable();
            $table->date('end_paid_date')->nullable();
            $table->string('block')->comment('yes=> blocked ,no=>unblocked');
            $table->string('paid')->comment('yes=> pay ,no=>not pay');
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
        Schema::dropIfExists('students');
    }
}
