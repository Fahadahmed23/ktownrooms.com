<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToAccountInvoiceTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('account_invoice', function(Blueprint $table)
		{
			$table->foreign('booking_id', 'booking_id')->references('id')->on('bookings')->onUpdate('RESTRICT')->onDelete('RESTRICT');
			$table->foreign('customer_id', 'customer_id')->references('id')->on('customers')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('account_invoice', function(Blueprint $table)
		{
			$table->dropForeign('booking_id');
			$table->dropForeign('customer_id');
		});
	}

}
