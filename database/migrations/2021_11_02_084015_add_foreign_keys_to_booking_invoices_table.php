<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToBookingInvoicesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('booking_invoices', function(Blueprint $table)
		{
			$table->foreign('booking_id', 'FK_bi_Booking_id')->references('id')->on('bookings')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('customer_id', 'booking_invoices_ibfk_1')->references('id')->on('customers')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('promo_id', 'booking_invoices_ibfk_6')->references('id')->on('promotions')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('hotel_id', 'booking_invoices_ibfk_7')->references('id')->on('hotels')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('city_id', 'booking_invoices_ibfk_8')->references('id')->on('cities')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('booking_invoices', function(Blueprint $table)
		{
			$table->dropForeign('FK_bi_Booking_id');
			$table->dropForeign('booking_invoices_ibfk_1');
			$table->dropForeign('booking_invoices_ibfk_6');
			$table->dropForeign('booking_invoices_ibfk_7');
			$table->dropForeign('booking_invoices_ibfk_8');
		});
	}

}
