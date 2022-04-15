<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSmsLogsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sms_logs', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('booking_id')->nullable();
			$table->integer('sender_id')->nullable();
			$table->integer('receiver_id')->nullable();
			$table->string('receiver_phone', 25)->nullable();
			$table->string('sent_message', 500)->nullable();
			$table->timestamp('sent_time')->default(DB::raw('CURRENT_TIMESTAMP'));
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('sms_logs');
	}

}
