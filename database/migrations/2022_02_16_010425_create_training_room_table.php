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
        Schema::create('training_room', function (Blueprint $table) {
            // $table->id();
            $table->unsignedBigInteger('training_id')->nullable();
            $table->unsignedBigInteger('member_id')->nullable();
            $table->date('date_start');
            $table->date('date_completed');
            $table->string('result');
            $table->text('note');
            $table->timestamps();
            $table->string('deleted_at')->nullable();
            $table->primary(['training_id', 'member_id']);
            $table->foreign('training_id')->references('id')->on('training');
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
        Schema::dropIfExists('training_room');
    }
};
