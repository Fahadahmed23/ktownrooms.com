<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToBookingOccupantsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('booking_occupants', function(Blueprint $table)
		{
			$table->foreign('booking_id', 'booking_occupants_ibfk_1')->references('id')->on('bookings')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('booking_occupants', function(Blueprint $table)
		{
			$table->dropForeign('booking_occupants_ibfk_1');
		});
	}

}
