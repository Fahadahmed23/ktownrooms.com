<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateVoucherDetailsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('voucher_details', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('voucher_master_id');
			$table->integer('account_gl_id')->nullable();
			$table->integer('cost_center_id')->nullable();
			$table->integer('invoice_id')->nullable();
			$table->string('ref_no', 20)->nullable();
			$table->integer('s_no')->nullable();
			$table->string('amount_status', 50)->nullable();
			$table->decimal('remaining_amount', 18)->nullable()->default(0.00);
			$table->decimal('dr_amount', 15)->nullable();
			$table->decimal('cr_amount', 15)->nullable();
			$table->string('narration', 200)->nullable();
			$table->boolean('is_payble')->nullable();
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
		Schema::drop('voucher_details');
	}

}
