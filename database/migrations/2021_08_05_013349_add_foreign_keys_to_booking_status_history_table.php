<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToBookingStatusHistoryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('booking_status_history', function(Blueprint $table)
		{
			$table->foreign('booking_id', 'booking_status_history_ibfk_1')->references('id')->on('bookings')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('user_id', 'booking_status_history_ibfk_2')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('booking_status_history', function(Blueprint $table)
		{
			$table->dropForeign('booking_status_history_ibfk_1');
			$table->dropForeign('booking_status_history_ibfk_2');
		});
	}

}
