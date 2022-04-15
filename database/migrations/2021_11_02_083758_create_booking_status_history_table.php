<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBookingStatusHistoryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('booking_status_history', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('booking_id')->nullable()->index('booking_id');
			$table->string('status', 50)->nullable();
			$table->integer('user_id')->nullable()->index('user_id');
			$table->dateTime('status_date')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('booking_status_history');
	}

}
