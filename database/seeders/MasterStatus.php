<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class MasterStatus extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('master_status')->insert([
            [
                "name" => "NOT_STARTED"
            ],
            [
                "name" => "IN_PROGRESS"
            ],
            [
                "name" => "READY_FOR_TEST"
            ],
            [
                "name" => "COMPLETED"
            ]
        ]);
    }
}
