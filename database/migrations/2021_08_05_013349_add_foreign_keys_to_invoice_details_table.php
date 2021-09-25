<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToInvoiceDetailsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('invoice_details', function(Blueprint $table)
		{
			$table->foreign('booking_id', 'invoice_details_ibfk_1')->references('id')->on('bookings')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('invoice_details', function(Blueprint $table)
		{
			$table->dropForeign('invoice_details_ibfk_1');
		});
	}

}
