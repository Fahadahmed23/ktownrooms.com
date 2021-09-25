<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCustomerpaymentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('customerpayments', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('customer_id');
			$table->dateTime('PaymentDate');
			$table->decimal('Amount', 15);
			$table->decimal('Discount', 15);
			$table->boolean('IsBookingPayment', 1)->default(0);
			$table->boolean('IsReceived', 1)->default(0);
			$table->integer('PaymentModeCode');
			$table->decimal('IsOnlinePayment', 15)->default(0.00);
			$table->softDeletes();
			$table->timestamps();
			$table->string('CreationIP', 50);
			$table->integer('created_by');
			$table->string('CreatedByModule', 100);
			$table->string('UpdationIP', 50)->nullable();
			$table->integer('updated_by')->nullable();
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
		Schema::drop('customerpayments');
	}

}
