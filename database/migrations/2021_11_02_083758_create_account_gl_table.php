<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAccountGlTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('account_gl', function(Blueprint $table)
		{
			$table->bigInteger('id', true);
			$table->string('account_gl_code', 50)->nullable();
			$table->string('title', 100)->nullable();
			$table->string('description', 250)->nullable();
			$table->decimal('opening_balance', 18)->nullable();
			$table->enum('dr_cr', array('Debit','Credit'))->nullable();
			$table->integer('hotel_id')->nullable();
			$table->smallInteger('account_fiscal_years_master_id')->nullable()->index('account_fiscal_years_master_id');
			$table->smallInteger('account_type_id')->nullable()->index('account_gl_ibfk_1');
			$table->smallInteger('sub_account_type_id')->nullable();
			$table->enum('posting_type', array('BS','PL'))->nullable();
			$table->smallInteger('account_level_id')->nullable()->index('account_level_id');
			$table->boolean('is_used')->nullable()->default(0);
			$table->boolean('is_active')->nullable()->default(1);
			$table->string('parent_account', 100)->nullable();
			$table->bigInteger('CreatedBy')->nullable();
			$table->date('CreatedOn')->nullable();
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
		Schema::drop('account_gl');
	}

}
