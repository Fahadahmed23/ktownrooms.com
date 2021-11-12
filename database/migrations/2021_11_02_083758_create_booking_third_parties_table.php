<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBookingThirdPartiesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('booking_third_parties', function(Blueprint $table)
		{
			$table->integer('id')->nullable();
			$table->string('booking_no', 100)->nullable();
			$table->string('first_name', 191)->nullable();
			$table->string('last_name', 191)->nullable();
			$table->string('phone', 191)->nullable();
			$table->string('email', 191)->nullable();
			$table->integer('total_rooms')->nullable();
			$table->float('total_cost', 10)->nullable();
			$table->enum('payment_mode', array('Cash','Credit'))->nullable()->default('Cash');
			$table->boolean('payment_status')->nullable()->default(0);
			$table->integer('hotel_id')->nullable();
			$table->string('hotel_name', 191)->nullable();
			$table->dateTime('booking_date')->nullable();
			$table->date('booking_from')->nullable();
			$table->date('booking_to')->nullable();
			$table->smallInteger('no_occupants')->nullable();
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
		Schema::drop('booking_third_parties');
	}

}
