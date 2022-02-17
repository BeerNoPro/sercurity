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
        Schema::create('carbinet', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('work_room_id')->nullable();
            $table->unsignedBigInteger('member_id')->nullable();
            $table->timestamps();
            $table->string('deleted_at')->nullable();
            $table->foreign('work_room_id')->references('id')->on('work_room');
            $table->foreign('member_id')->references('id')->on('member');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('carbinet');
    }
};
