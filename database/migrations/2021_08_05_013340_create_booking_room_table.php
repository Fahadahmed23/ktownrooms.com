<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBookingRoomTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('booking_room', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('booking_id')->index('booking_id');
			$table->integer('room_id')->index('room_id');
			$table->decimal('room_charges', 10)->nullable();
			$table->decimal('room_charges_onbooking', 10)->nullable();
			$table->softDeletes();
			$table->timestamps();
			$table->string('CreationIP', 50)->nullable();
			$table->integer('created_by')->nullable()->index('created_by');
			$table->string('CreatedByModule', 100)->nullable();
			$table->string('UpdationIP', 50)->nullable();
			$table->integer('updated_by')->nullable()->index('updated_by');
			$table->string('UpdatedByModule', 100)->nullable();
			$table->integer('allowed_occupants')->nullable();
			$table->integer('occupants')->nullable();
			$table->integer('max_allowed_occupants')->nullable();
			$table->string('room_title')->nullable();
			$table->integer('additional_occupants')->nullable()->default(0);
			$table->decimal('additional_guest_charges', 11)->nullable()->default(0.00);
			$table->decimal('additional_guest_rate', 11)->nullable();
			$table->boolean('transferred')->nullable()->default(0);
			$table->integer('transferred_to')->nullable()->default(0);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('booking_room');
	}

}
