<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToRoomScheduleTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('room_schedule', function(Blueprint $table)
		{
			$table->foreign('room_id', 'room_schedule_ibfk_1')->references('id')->on('rooms')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('booking_id', 'room_schedule_ibfk_4')->references('id')->on('bookings')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('room_schedule', function(Blueprint $table)
		{
			$table->dropForeign('room_schedule_ibfk_1');
			$table->dropForeign('room_schedule_ibfk_4');
		});
	}

}
