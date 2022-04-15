<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCustomerComplainsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('customer_complains', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('customer_id')->index('customer_id');
			$table->string('complain_code', 50)->nullable();
			$table->integer('complain_status_id')->default(1)->index('complain_status_id');
			$table->integer('ComplainResolvedBy');
			$table->string('Comments', 200);
			$table->dateTime('ComplainTime');
			$table->dateTime('ResolveTime')->nullable();
			$table->softDeletes();
			$table->timestamps();
			$table->string('CreationIP', 50)->nullable();
			$table->integer('created_by')->nullable();
			$table->string('CreatedByModule', 100)->nullable();
			$table->string('UpdationIP', 50)->nullable();
			$table->integer('updated_by')->nullable();
			$table->string('UpdatedByModule', 100)->nullable();
			$table->integer('room_id')->index('room_id');
			$table->integer('hotel_id')->nullable();
			$table->integer('booking_id')->index('booking_id');
			$table->string('subject')->nullable();
			$table->string('message')->nullable();
			$table->integer('priority_id')->nullable()->default(1)->index('priority_id');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('customer_complains');
	}

}
