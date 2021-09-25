<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateConfigurationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('configurations', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('WebsiteTitle', 100)->nullable();
			$table->string('Logo', 100)->nullable();
			$table->string('Contact1', 20)->nullable();
			$table->string('Contact2', 20)->nullable();
			$table->text('Address', 65535)->nullable();
			$table->text('Copyright', 65535)->nullable();
			$table->string('Facebook', 50)->nullable();
			$table->string('Twitter', 50)->nullable();
			$table->string('Google', 50)->nullable();
			$table->string('Instagram', 50)->nullable();
			$table->string('LinkedIn', 50)->nullable();
			$table->string('SignupEmail')->nullable();
			$table->string('ResetPassword')->nullable();
			$table->string('BookingEmail')->nullable();
			$table->string('SupportEmail')->nullable();
			$table->string('AdminPhone', 20)->nullable();
			$table->string('AdminEmail')->nullable();
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
		Schema::drop('configurations');
	}

}
