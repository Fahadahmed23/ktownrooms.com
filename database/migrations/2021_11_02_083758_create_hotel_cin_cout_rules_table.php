<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateHotelCinCoutRulesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('hotel_cin_cout_rules', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('hotel_id')->nullable()->index('hotel_id');
			$table->integer('cin_cout_rule_id')->nullable()->index('cin_cout_rule_id');
			$table->enum('rule_type', array('early_check_in','late_check_out'));
			$table->time('threshold_time');
			$table->time('start_time');
			$table->time('end_time');
			$table->time('check_in_limit')->nullable();
			$table->time('check_out_limit')->nullable();
			$table->float('charges');
			$table->softDeletes();
			$table->timestamps();
			$table->string('CreationIP', 50)->nullable();
			$table->integer('created_by')->nullable()->index('created_by');
			$table->string('CreatedByModule', 100)->nullable();
			$table->string('UpdationIP', 50)->nullable();
			$table->integer('updated_by')->nullable()->index('updated_by');
			$table->string('UpdatedByModule', 100)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('hotel_cin_cout_rules');
	}

}
