<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToCustomerComplainsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('customer_complains', function(Blueprint $table)
		{
			$table->foreign('customer_id', 'customer_complains_ibfk_1')->references('id')->on('customers')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('complain_status_id', 'customer_complains_ibfk_3')->references('id')->on('complain_statuses')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('room_id', 'customer_complains_ibfk_4')->references('id')->on('rooms')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('booking_id', 'customer_complains_ibfk_5')->references('id')->on('bookings')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('customer_complains', function(Blueprint $table)
		{
			$table->dropForeign('customer_complains_ibfk_1');
			$table->dropForeign('customer_complains_ibfk_3');
			$table->dropForeign('customer_complains_ibfk_4');
			$table->dropForeign('customer_complains_ibfk_5');
		});
	}

}
