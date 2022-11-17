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
            $table->foreignUuid('project_id')->index()->references('id')->on('projects');
            $table->foreignUuid('user_id')->index()->references('id')->on('users');
            $table->string('title')->index();
            $table->string('description');
            $table->string('status');
            $table->integer('priority')->default(1);
            $table->integer('points')->default(1);
            $table->date('dateline');
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
