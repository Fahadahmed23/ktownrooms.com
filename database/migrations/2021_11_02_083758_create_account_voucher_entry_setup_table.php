<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAccountVoucherEntrySetupTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('account_voucher_entry_setup', function(Blueprint $table)
		{
			$table->smallInteger('id', true);
			$table->smallInteger('voucher_type_id');
			$table->string('description', 150)->nullable();
			$table->string('account_gl_code', 50);
			$table->string('account_head_label_header', 50)->nullable();
			$table->boolean('account_level')->nullable();
			$table->boolean('is_dr');
			$table->boolean('is_cr');
			$table->boolean('should_show_pay_received_combo_box');
			$table->string('pay_received_label_header', 50)->nullable();
			$table->boolean('is_active')->default(1);
			$table->boolean('show_balance')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('account_voucher_entry_setup');
	}

}
