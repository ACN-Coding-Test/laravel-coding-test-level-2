<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class MasterRole extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('master_role')->insert([
            [
                "name" => "MEMBER"
            ],
            [
                "name" => "PRODUCT_OWNER"
            ],
            [
                "name" => "ADMIN"
            ]
        ]);
    }
}
