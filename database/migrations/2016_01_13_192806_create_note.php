<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNote extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notes', function ($table) {
            $table->increments('id');
            $table->integer('lead_id')->unsigned()->nullable();
            $table->boolean('job_id')->unsigned()->nullable();
            $table->string('note');
            $table->string('user_id');
            $table->timestamp();
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('note');
    }
}
