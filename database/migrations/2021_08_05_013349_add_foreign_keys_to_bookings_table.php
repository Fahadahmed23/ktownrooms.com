<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToBookingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('bookings', function(Blueprint $table)
		{
			$table->foreign('customer_id', 'bookings_ibfk_1')->references('id')->on('customers')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('hotel_id', 'bookings_ibfk_3')->references('id')->on('hotels')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('promotion_id', 'bookings_ibfk_4')->references('id')->on('promotions')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('bookings', function(Blueprint $table)
		{
			$table->dropForeign('bookings_ibfk_1');
			$table->dropForeign('bookings_ibfk_3');
			$table->dropForeign('bookings_ibfk_4');
		});
	}

}
