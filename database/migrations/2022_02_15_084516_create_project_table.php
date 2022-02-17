<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->date('time_start');
            $table->date('time_completed');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->unsignedBigInteger('work_room_id')->nullable();
            $table->timestamps();
            $table->string('deleted_at')->nullable();
            $table->foreign('company_id')->references('id')->on('company');
            $table->foreign('work_room_id')->references('id')->on('work_room'); //->nullOnDelete()
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('project');
    }
};
