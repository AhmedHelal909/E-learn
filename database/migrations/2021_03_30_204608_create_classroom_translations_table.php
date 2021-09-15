<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassroomTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classroom_translations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('classroom_id')->unsigned();
            $table->string('locale')->index();
            $table->string('name');
            $table->timestamps();
            $table->unique(['classroom_id', 'locale']);
            $table->foreign('classroom_id')->references('id')->on('classrooms')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('term_translations');
    }
}
