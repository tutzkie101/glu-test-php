<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('processor_id')->nullable();
            $table->string('submitters_id');
            $table->integer('priority');
            $table->string('status')->nullable();
            $table->json('package');
            $table->timestamps();
        });

        Schema::create('processor', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('task_id')->nullable();
            $table->string('name');
            $table->string('process_time')->nullable();
            $table->timestamps();

            //FK
            $table->foreign('task_id')->references('id')->on('tasks');

            //UK
            $table->unique(['task_id']);

        });

        Schema::table('tasks', function (Blueprint $table) {
            //FK
            $table->foreign('processor_id')->references('id')->on('processor');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('processor');
        Schema::dropIfExists('tasks');
        Schema::enableForeignKeyConstraints();
    }
}
