<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PupulateTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        //populate table
        $created = date('Y-m-d H:i:s');
        DB::table('features')->insert(array(
            array('name' => 'BBQ', 'created_at' => $created),
            array('name' => 'BP', 'created_at' => $created),
            array('name' => 'DW', 'created_at' => $created),
            array('name' => 'FP', 'created_at' => $created),
            array('name' => 'Fpit', 'created_at' => $created),
            array('name' => 'Gas Fpit', 'created_at' => $created),
            array('name' => 'Pavilion', 'created_at' => $created),
            array('name' => 'Pch', 'created_at' => $created),
            array('name' => 'Pergola', 'created_at' => $created),
            array('name' => 'Pizza Oven', 'created_at' => $created),
            array('name' => 'Pool', 'created_at' => $created),
            array('name' => 'Rad.Heat', 'created_at' => $created),
            array('name' => 'RW', 'created_at' => $created),
            array('name' => 'Sealer', 'created_at' => $created),
            array('name' => 'Steps', 'created_at' => $created),
            array('name' => 'SW', 'created_at' => $created),
            array('name' => 'Wat. Feat.', 'created_at' => $created),
            array('name' => 'WW', 'created_at' => $created)
        ));

        //populate table
        $created = date('Y-m-d H:i:s');
        DB::table('taken_bys')->insert(array(
            array('name' => 'Andrea', 'created_at' => $created),
            array('name' => 'Karen', 'created_at' => $created),
            array('name' => 'Martha', 'created_at' => $created),
            array('name' => 'Rebeca', 'created_at' => $created),
            array('name' => 'Sam', 'created_at' => $created),
            array('name' => 'Valdo', 'created_at' => $created),
            array('name' => 'Vianna', 'created_at' => $created),
            array('name' => 'Vianney', 'created_at' => $created),
            array('name' => 'Other', 'created_at' => $created)
        ));


        //populate table
        $created = date('Y-m-d H:i:s');
        DB::table('sources')->insert(array(
            array('name' => 'Ad', 'created_at' => $created),
            array('name' => 'Billboard', 'created_at' => $created),
            array('name' => 'Cold Call', 'created_at' => $created),
            array('name' => 'Drive By', 'created_at' => $created),
            array('name' => 'Existing Customer', 'created_at' => $created),
            array('name' => 'Flyer', 'created_at' => $created),
            array('name' => 'Homeshow', 'created_at' => $created),
            array('name' => 'Hometown Values', 'created_at' => $created),
            array('name' => 'Referral', 'created_at' => $created),
            array('name' => 'Truck', 'created_at' => $created),
            array('name' => 'Unknown', 'created_at' => $created),
            array('name' => 'Website', 'created_at' => $created),
            array('name' => 'Youtube', 'created_at' => $created),
            array('name' => 'Other', 'created_at' => $created)
        ));

                //populate table
        $created = date('Y-m-d H:i:s');
        DB::table('status')->insert(array(
            array('name' => 'Cancelled', 'created_at' => $created),
            array('name' => 'Cancelled Appt', 'created_at' => $created),
            array('name' => 'Cancelled Bid', 'created_at' => $created),
            array('name' => 'Dead Lead', 'created_at' => $created),
            array('name' => 'Pending', 'created_at' => $created),
            array('name' => 'Re-Scheduled', 'created_at' => $created),
            array('name' => 'Sold', 'created_at' => $created)
        ));

        $created = date('Y-m-d H:i:s');
        DB::table('sales_reps')->insert(array(
            array('name' => 'Sam', 'created_at' => $created),
            array('name' => 'Vianna', 'created_at' => $created),
            array('name' => 'Valdo', 'created_at' => $created)
        ));

        $create = date('Y-m-d H:i:s');
        DB::table('job_types')->insert(array(
            array('name' => 'New', 'created_at' => $create),
            array('name' => 'Remodel', 'created_at' => $create),
            array('name' => 'Repair', 'created_at' => $create)
        ));

                //populate table
        $created = date('Y-m-d H:i:s');
        DB::table('removals')->insert(array(
            array('name' => 'Asphalt', 'created_at' => $created),
            array('name' => 'Brick', 'created_at' => $created), 
            array('name' => 'Deck', 'created_at' => $created),
            array('name' => 'Dirt', 'created_at' => $created),
            array('name' => 'Grass', 'created_at' => $created),
            array('name' => 'Gravel', 'created_at' => $created), 
            array('name' => 'Rock', 'created_at' => $created),
            array('name' => 'Sod', 'created_at' => $created),
            array('name' => 'Stone', 'created_at' => $created), 
            array('name' => 'Wood', 'created_at' => $created)
        ));


        //populate table
        $created = date('Y-m-d H:i:s');
        DB::table('paver_manufacturers')->insert(array(
            array('name' => 'AJ Construction', 'created_at' => $created),
            array('name' => 'C Blake Homes', 'created_at' => $created),
            array('name' => 'CD Construction', 'created_at' => $created),
            array('name' => 'Cloward Construction', 'created_at' => $created),
            array('name' => 'Collins Stewart (The Awning Co.)', 'created_at' => $created),
            array('name' => 'Craig Archer Construction', 'created_at' => $created),
            array('name' => 'Dave Holt', 'created_at' => $created),
            array('name' => 'Fine Remodeling', 'created_at' => $created),
            array('name' => 'Golden Landscaping', 'created_at' => $created),
            array('name' => 'H & S Construction', 'created_at' => $created),
            array('name' => 'Homeowner', 'created_at' => $created),
            array('name' => 'JD Construction', 'created_at' => $created),
            array('name' => 'Magleby Const.', 'created_at' => $created),
            array('name' => 'Perry Newman', 'created_at' => $created),
            array('name' => 'Randy Cloward', 'created_at' => $created),
            array('name' => 'Rays Gardening', 'created_at' => $created),
            array('name' => 'Snake Creek Landscape', 'created_at' => $created),
            array('name' => 'Spencer Smith', 'created_at' => $created),
            array('name' => 'Sunset Pools Jeff', 'created_at' => $created),
            array('name' => 'Tabco Construction', 'created_at' => $created),
            array('name' => 'TJ Barham', 'created_at' => $created),
            array('name' => 'UHB', 'created_at' => $created),
            array('name' => 'Wildbrook Homes', 'created_at' => $created),
            array('name' => 'Yardworx', 'created_at' => $created)
        ));

        $created = date('Y-m-d H:i:s');
        DB::table('districts')->insert(array(
            array('name' => 'North', 'created_at' => $created),
            array('name' => 'South', 'created_at' => $created)
        ));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
