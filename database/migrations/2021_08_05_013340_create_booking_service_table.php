<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBookingServiceTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('booking_service', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('booking_id');
			$table->integer('service_id');
			$table->integer('department_id');
			$table->integer('room_id')->nullable();
			$table->string('department_name', 100)->nullable();
			$table->string('service_name', 100)->nullable();
			$table->decimal('service_charges', 11)->nullable();
			$table->time('start_time')->nullable();
			$table->time('end_time')->nullable();
			$table->string('serving_time', 100)->nullable();
			$table->integer('times')->nullable();
			$table->integer('includes')->nullable();
			$table->integer('excludes')->nullable();
			$table->decimal('amount', 11)->nullable();
			$table->string('icon_class')->nullable();
			$table->enum('status', array('awaiting','accepted','rejected','inprogress','completed','cancelled'))->nullable();
			$table->string('cancel_reason', 50)->nullable();
			$table->timestamps();
			$table->softDeletes();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('booking_service');
	}

}
