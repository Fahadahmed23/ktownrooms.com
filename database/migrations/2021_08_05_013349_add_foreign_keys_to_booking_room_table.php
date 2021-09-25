<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToBookingRoomTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('booking_room', function(Blueprint $table)
		{
			$table->foreign('booking_id', 'booking_room_ibfk_1')->references('id')->on('bookings')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('room_id', 'booking_room_ibfk_2')->references('id')->on('rooms')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('booking_room', function(Blueprint $table)
		{
			$table->dropForeign('booking_room_ibfk_1');
			$table->dropForeign('booking_room_ibfk_2');
		});
	}

}
