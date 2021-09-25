<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTransactionLogsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('transaction_logs', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('booking_id');
			$table->decimal('amount', 11)->nullable();
			$table->integer('payment_type_id')->nullable();
			$table->string('payment_type_name', 25);
			$table->string('payment_details', 25)->nullable();
			$table->timestamps();
			$table->softDeletes();
			$table->integer('created_by');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('transaction_logs');
	}

}
