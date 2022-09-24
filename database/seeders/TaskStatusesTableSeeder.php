<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TaskStatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('task_statuses')->delete();
        \DB::table('task_statuses')->insert(array (
            0 => 
            array (
                'status' => 'NOT_STARTED',
                'created_at' => '2022-09-21 09:14:10',
                'updated_at' => '2022-09-21 09:14:10',
            ),
            1 => 
            array (
                'status' => 'IN_PROGRESS',
                'created_at' => '2022-09-21 09:14:10',
                'updated_at' => '2022-09-21 09:14:10',
            ),
            2 => 
            array (
                'status' => 'READY_FOR_TEST',
                'created_at' => '2022-09-21 09:14:10',
                'updated_at' => '2022-09-21 09:14:10',
            ),
            3 => 
            array (
                'status' => 'COMPLETED',
                'created_at' => '2022-09-21 09:14:10',
                'updated_at' => '2022-09-21 09:14:10',
            ),
        ));
    }
}
