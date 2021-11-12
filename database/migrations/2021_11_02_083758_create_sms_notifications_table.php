<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSmsNotificationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sms_notifications', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('type')->nullable();
			$table->string('message', 1000)->nullable();
			$table->enum('contact_type', array('customer','admin'))->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('sms_notifications');
	}

}
