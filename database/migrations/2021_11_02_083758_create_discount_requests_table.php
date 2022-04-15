<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDiscountRequestsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('discount_requests', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('booking_id')->nullable()->index('booking_id');
			$table->enum('discount_type', array('CheckIn','CheckOut'))->nullable()->default('CheckIn');
			$table->integer('hotel_id')->nullable();
			$table->integer('requester_id')->nullable()->index('requester_id');
			$table->decimal('requested_amount', 11)->nullable();
			$table->decimal('allowed_discount', 11)->nullable();
			$table->enum('status', array('Pending','Approved','Declined'))->nullable();
			$table->text('reason', 65535)->nullable();
			$table->integer('supervisor_id')->nullable();
			$table->text('supervisor_comments', 65535)->nullable();
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
		Schema::drop('discount_requests');
	}

}
