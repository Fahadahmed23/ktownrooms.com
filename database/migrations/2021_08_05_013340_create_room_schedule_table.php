<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRoomScheduleTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('room_schedule', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('room_id')->index('room_id');
			$table->date('start_date')->nullable();
			$table->date('end_date')->nullable();
			$table->timestamps();
			$table->softDeletes();
			$table->integer('created_by')->nullable()->index('created_by');
			$table->integer('booking_id')->nullable()->index('booking_id');
			$table->enum('booking_status', array('Pending','Confirmed','Cancelled','CheckedIn','CheckedOut'))->nullable();
			$table->integer('updated_by')->nullable()->index('updated_by');
			$table->boolean('status')->nullable()->default(1);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('room_schedule');
	}

}
