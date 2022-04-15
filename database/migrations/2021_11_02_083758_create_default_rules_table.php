<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDefaultRulesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('default_rules', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('name', 191)->nullable();
			$table->string('email', 50)->nullable();
			$table->string('phone', 20)->nullable();
			$table->string('address')->nullable();
			$table->string('website')->nullable();
			$table->time('checkin_time');
			$table->time('checkout_time');
			$table->text('confirm_message')->nullable();
			$table->text('cancel_message')->nullable();
			$table->text('amendment_message')->nullable();
			$table->text('checkin_message')->nullable();
			$table->text('checkout_message')->nullable();
			$table->text('client_key')->nullable();
			$table->text('secret_key')->nullable();
			$table->string('picture')->nullable();
			$table->text('reminder_message')->nullable();
			$table->integer('reminder_before')->nullable()->comment('no of days before reminder will sent to user');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('default_rules');
	}

}
