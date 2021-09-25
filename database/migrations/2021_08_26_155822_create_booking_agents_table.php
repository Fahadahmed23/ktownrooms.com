<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookingAgentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_agents', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('hotel_id')->nullable()->index('hotel_id');
            $table->string('name', 191)->nullable();
            $table->string('phone', 50)->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('hotel_id', 'hotel_booking_agents_ibfk_1')->references('id')->on('hotels')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('booking_agents');
    }
}
