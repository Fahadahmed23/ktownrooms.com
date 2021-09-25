<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateVendorsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('vendors', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('Name', 191);
			$table->string('Email', 100);
			$table->string('Phone', 50);
			$table->string('Address', 150);
			$table->integer('CountryCode')->nullable();
			$table->integer('StateCode')->nullable();
			$table->integer('CityCode')->nullable();
			$table->string('ZipCode', 10)->nullable();
			$table->softDeletes();
			$table->timestamps();
			$table->string('created_by_ip', 50);
			$table->integer('created_by');
			$table->string('created_by_module', 100);
			$table->string('updated_by_ip', 50)->nullable();
			$table->integer('updated_by')->nullable();
			$table->string('updated_by_module', 100)->nullable();
			$table->text('create_data', 65535)->nullable();
			$table->text('update_data', 65535)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('vendors');
	}

}
