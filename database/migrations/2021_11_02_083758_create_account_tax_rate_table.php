<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAccountTaxRateTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('account_tax_rate', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->float('filer_company_tax_rate', 10, 0)->nullable();
			$table->float('non_filer_company_tax_rate', 10, 0)->nullable();
			$table->float('filer_individual_tax_rate', 10, 0)->nullable();
			$table->float('non_filer_individual_company_tax_rate', 10, 0)->nullable();
			$table->integer('fiscal_year_master_id')->nullable();
			$table->boolean('is_active')->nullable()->default(1);
			$table->boolean('is_archived')->nullable()->default(0);
			$table->dateTime('CreationDate')->nullable()->default(DB::raw('CURRENT_TIMESTAMP'));
			$table->string('CreationIP', 50)->nullable();
			$table->integer('CreatedByUser')->nullable();
			$table->string('CreatedByModule', 100)->nullable();
			$table->dateTime('UpdationDate')->nullable();
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
		Schema::drop('account_tax_rate');
	}

}
