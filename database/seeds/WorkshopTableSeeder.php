<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WorkshopTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Truncate Table
        DB::table('workshops')->truncate();

        //Insert workshop data
        DB::table('workshops')->insert([

            [ 'time' => 'June 1st 9AM - 12PM', 'max_guests' => 5, 'created_at' => date('Y-m-d H:i:s')],
            [ 'time' => 'June 1st 12PM - 3PM', 'max_guests' => 5, 'created_at' => date('Y-m-d H:i:s')],
            [ 'time' => 'June 1st 3PM - 6PM',  'max_guests' => 7, 'created_at' => date('Y-m-d H:i:s')],
            [ 'time' => 'June 2st 9AM - 12PM', 'max_guests' => 5, 'created_at' => date('Y-m-d H:i:s')],
            [ 'time' => 'June 2st 12PM - 3PM', 'max_guests' => 5, 'created_at' => date('Y-m-d H:i:s')],
            [ 'time' => 'June 2st 3PM - 6PM',  'max_guests' => 12,'created_at' => date('Y-m-d H:i:s')],
            [ 'time' => 'June 3st 9AM - 12PM', 'max_guests' => 5, 'created_at' => date('Y-m-d H:i:s')],
            [ 'time' => 'June 3st 12PM - 3PM', 'max_guests' => 7, 'created_at' => date('Y-m-d H:i:s')],
            [ 'time' => 'June 3st 3PM - 6PM',  'max_guests' => 5, 'created_at' => date('Y-m-d H:i:s')],

        ]);
    }
}
