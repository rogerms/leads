<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJob extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function($table)
        {
            $table->increments('id');
            $table->integer('lead_id')->unsigned();
            $table->integer('size');
            $table->string('customer_type');
            $table->string('contractor');
            $table->dateTime('date_sold');
            $table->string('job_type');
            $table->decimal('sqft_price', 6, 2);
            $table->decimal('proposal_amount', 10, 2); //may need one-to-many relationship
            $table->decimal('invoiced_amount', 10, 2);
            $table->boolean('pavers_ordered');
            $table->boolean('prelien');
            $table->boolean('bluestakes');
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
        Schema::drop('job');
    }
}
