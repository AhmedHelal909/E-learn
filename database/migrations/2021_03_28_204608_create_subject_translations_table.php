<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubjectTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subject_translations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('subject_id')->unsigned();
            $table->string('locale')->index();
            $table->string('name');
            $table->timestamps();
            $table->unique(['subject_id', 'locale']);
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');
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
