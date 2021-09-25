<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAccountSalesTaxesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('account_sales_taxes', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('title', 50)->nullable();
			$table->float('tax_rate', 15)->nullable();
			$table->boolean('is_active')->nullable()->default(1);
			$table->dateTime('CreationDate')->nullable()->default(\DB::raw('CURRENT_TIMESTAMP'));
			$table->string('CreationIP', 50)->nullable();
			$table->integer('created_by')->nullable();
			$table->integer('CreatedByUser')->nullable();
			$table->timestamps();
			$table->softDeletes();
			$table->string('CreatedByModule', 100)->nullable();
			$table->dateTime('UpdationDate');
			$table->string('UpdationIP', 50)->nullable();
			$table->integer('UpdatedByUser')->nullable();
			$table->string('UpdatedByModule', 100)->nullable();
			$table->boolean('IsDeleted')->nullable()->default(0);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('account_sales_taxes');
	}

}
