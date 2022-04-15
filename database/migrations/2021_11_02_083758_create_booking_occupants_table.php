<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBookingOccupantsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('booking_occupants', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('booking_id')->index('booking_id');
			$table->string('FirstName', 100);
			$table->string('LastName', 100);
			$table->boolean('Over18')->nullable();
			$table->string('CNIC', 25);
			$table->string('Passport', 25)->nullable();
			$table->integer('RelationCode')->nullable();
			$table->softDeletes();
			$table->timestamps();
			$table->string('CreationIP', 50)->nullable();
			$table->integer('created_by')->nullable()->index('created_by');
			$table->string('CreatedByModule', 100)->nullable();
			$table->string('UpdationIP', 50)->nullable();
			$table->integer('updated_by')->nullable()->index('updated_by');
			$table->string('UpdatedByModule', 100)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('booking_occupants');
	}

}
