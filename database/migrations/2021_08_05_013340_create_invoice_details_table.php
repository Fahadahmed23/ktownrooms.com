<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateInvoiceDetailsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('invoice_details', function(Blueprint $table)
		{
			$table->string('title', 100)->nullable();
			$table->enum('type', array('service','payment','early checkin','late checkout', 'refund'))->nullable();
			$table->integer('booking_id')->nullable()->index('booking_id');
			$table->string('booking_no', 25)->nullable();
			$table->string('invoice_no', 25)->nullable();
			$table->decimal('rate', 11)->nullable();
			$table->integer('quantity')->nullable();
			$table->decimal('amount', 10)->nullable();
			$table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('invoice_details');
	}

}
