<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBookingMappingStatusesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('booking_mapping_statuses', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('booking_third_party_id')->nullable();
			$table->integer('booking_mapping_id')->nullable();
			$table->string('booking_mapping_type', 191)->nullable();
			$table->boolean('status')->nullable();
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
		Schema::drop('booking_mapping_statuses');
	}

}
