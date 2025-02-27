<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('description');
            $table->integer('status')->unsigned()->default(1)->comment('1:To Do 2:In Progress 3:Review 4:Done');
            $table->integer('priority')->unsigned()->default(1)->comment('1:Low 2:Medium 3:High');
            $table->dateTimeTz('deadline');
            $table->unsignedInteger('project_id');
            $table->unsignedInteger('parent_task_id');

            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
            $table->foreign('parent_task_id')->references('id')->on('tasks')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
