<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('name', 573)->nullable();
			$table->string('email', 573)->nullable();
			$table->string('password', 573)->nullable();
			$table->string('type', 150)->nullable();
			$table->dateTime('last_login_time')->nullable();
			$table->string('remember_token', 300)->nullable();
			$table->timestamps();
			$table->string('first_name', 300)->nullable();
			$table->string('last_name', 300)->nullable();
			$table->string('phone_no', 300)->nullable();
			$table->string('picture', 1500)->nullable();
			$table->text('greeting_msg', 65535)->nullable();
			$table->enum('user_status', array('active','inactive','retired'))->nullable();
			$table->boolean('first_login')->nullable();
			$table->integer('city_id')->nullable()->index('city_id');
			$table->integer('hotel_id')->nullable()->index('hotel_id');
			$table->integer('department_id')->nullable()->index('department_id');
			$table->integer('designation_id')->nullable()->index('designation_id');
			$table->string('reference_name', 100)->nullable();
			$table->string('reference_designation', 100)->nullable();
			$table->string('reference_department', 100)->nullable();
			$table->decimal('max_allowed_discount', 11)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users');
	}

}
