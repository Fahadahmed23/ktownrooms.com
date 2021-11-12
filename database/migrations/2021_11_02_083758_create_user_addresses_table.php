<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserAddressesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_addresses', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('user_id')->index('user_id');
			$table->string('type', 50);
			$table->string('country', 100)->nullable();
			$table->integer('state_id')->nullable()->index('state_id');
			$table->integer('zip')->nullable();
			$table->integer('city_id')->nullable()->index('city_id');
			$table->string('address', 1000)->nullable();
			$table->boolean('primary')->nullable()->default(0);
			$table->timestamps();
			$table->softDeletes();
			$table->integer('created_by')->nullable()->index('created_by');
			$table->integer('updated_by')->nullable()->index('updated_by');
			$table->string('created_by_ip', 50)->nullable();
			$table->string('updated_by_ip', 50)->nullable();
			$table->text('create_data', 65535)->nullable();
			$table->text('update_data', 65535)->nullable();
			$table->string('created_by_module', 100)->nullable();
			$table->string('updated_by_module', 100)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('user_addresses');
	}

}
