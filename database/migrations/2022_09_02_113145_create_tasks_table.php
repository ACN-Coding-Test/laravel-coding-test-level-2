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
            $table->string('title');
            $table->string('description')->nullable();
            $table->unsignedBigInteger('status_id')->default(1);
            $table->uuid('project_id');
            $table->uuid('user_id');
            $table->timestamps();

            $table->foreign('project_id')->on('projects')->references('id');
            $table->foreign('user_id')->on('users')->references('id');
            $table->foreign('status_id')->on('statuses')->references('id');
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
