<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateVouchersMasterTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('vouchers_master', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->smallInteger('voucher_type_id')->nullable();
			$table->string('voucher_no', 20)->nullable();
			$table->string('description', 250)->nullable();
			$table->date('date')->nullable();
			$table->string('cheque_no', 50)->nullable();
			$table->string('status', 50)->nullable();
			$table->enum('post', array('approved','posted'))->nullable();
			$table->dateTime('post_date')->nullable();
			$table->bigInteger('post_user_id')->nullable();
			$table->integer('fiscal_year_master_id')->nullable();
			$table->string('current_fiscal_year', 50)->nullable();
			$table->dateTime('cancel_date')->nullable();
			$table->bigInteger('cancel_user_id')->nullable();
			$table->bigInteger('CreatedBy')->nullable();
			$table->dateTime('CreatedOn')->nullable();
			$table->timestamps();
			$table->softDeletes();
			$table->integer('hotel_id')->nullable();
			$table->integer('booking_id')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('vouchers_master');
	}

}
