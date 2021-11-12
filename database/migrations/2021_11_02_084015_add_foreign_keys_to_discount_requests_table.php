<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToDiscountRequestsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('discount_requests', function(Blueprint $table)
		{
			$table->foreign('booking_id', 'discount_requests_ibfk_1')->references('id')->on('bookings')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('requester_id', 'discount_requests_ibfk_2')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('discount_requests', function(Blueprint $table)
		{
			$table->dropForeign('discount_requests_ibfk_1');
			$table->dropForeign('discount_requests_ibfk_2');
		});
	}

}
