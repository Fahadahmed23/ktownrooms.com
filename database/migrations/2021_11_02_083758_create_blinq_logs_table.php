<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBlinqLogsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('blinq_logs', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('invoice_detail_id');
			$table->string('InvoiceNumber', 50)->nullable()->comment('Booking Code also');
			$table->string('PaymentCode', 50)->nullable();
			$table->decimal('InvoiceAmount', 11)->nullable();
			$table->decimal('TranFee', 11)->nullable();
			$table->text('ResponseDetail')->nullable();
			$table->text('PaymentResponse')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('blinq_logs');
	}

}
