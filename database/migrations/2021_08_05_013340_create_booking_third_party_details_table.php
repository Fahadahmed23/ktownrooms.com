<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBookingThirdPartyDetailsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('booking_third_party_details', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('booking_third_party_id')->nullable();
			$table->float('partner_price', 10)->nullable();
			$table->float('selling_price', 10)->nullable();
			$table->integer('hotel_id')->nullable();
			$table->string('hotel_name', 191)->nullable();
			$table->string('room_type_name', 191)->nullable();
			$table->integer('no_of_rooms')->nullable();
			$table->integer('cost_of_rooms')->nullable();
			$table->integer('occupants')->nullable();
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('booking_third_party_details');
	}

}
