<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            
            $table->uuid('id')->primary();
            $table->string('title')->nullable(false);
            $table->string('description')->nullable();
            $table->enum('status',['NOT_STARTED','IN_PROGRESS','READY_FOR_TEST','COMPLETED'])->default('NOT_STARTED');
            $table->uuid('project_id');
            $table->foreign('project_id')
                  ->references('id')
                  ->on('projects')
                  ->nullable(false)
                  ->onDelete('restrict')
                  ->onUpdate('restrict');
            $table->uuid('user_id');
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->nullable(false)
                  ->onDelete('restrict')
                  ->onUpdate('restrict');

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
        Schema::dropIfExists('tasks');
    }
}
