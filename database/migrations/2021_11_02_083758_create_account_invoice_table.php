<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAccountInvoiceTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('account_invoice', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('booking_id')->nullable()->index('booking_id');
			$table->integer('customer_id')->nullable()->index('customer_id');
			$table->string('invoice_no', 30)->nullable();
			$table->boolean('is_yearly')->nullable()->default(0);
			$table->integer('quarter')->nullable();
			$table->boolean('is_archive')->nullable()->default(0);
			$table->integer('invoice_created_by')->nullable();
			$table->dateTime('creation_date')->nullable();
			$table->boolean('is_manual')->nullable()->default(0);
			$table->boolean('is_active')->nullable()->default(1);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('account_invoice');
	}

}
