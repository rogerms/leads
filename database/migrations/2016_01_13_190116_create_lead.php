<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLead extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leads', function($table)
        {
            $table->increments('id');
            $table->string('customer_name');
            $table->string('contact_name');
            $table->string('email');
            $table->string('phone');
            $table->string('street');
            $table->string('city');
            $table->string('zip');
            $table->char('state', 2);
            $table->dateTime('appointment');
            $table->integer('taken_by_id')->unsigned();
            $table->integer('source_id')->unsigned();
            $table->integer('status_id')->unsigned();
            $table->integer('sales_rep_id')->unsigned();
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
        Schema::drop('lead');
    }
}
