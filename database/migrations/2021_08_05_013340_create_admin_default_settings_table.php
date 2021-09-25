<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAdminDefaultSettingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('admin_default_settings', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('museum_name', 100)->nullable();
			$table->string('email', 500)->nullable();
			$table->string('phone', 100)->nullable();
			$table->string('designation', 100)->nullable();
			$table->string('designation_number', 100)->nullable();
			$table->string('latitude', 100)->nullable();
			$table->string('longitude', 100)->nullable();
			$table->string('phone_ext', 100)->nullable();
			$table->string('country', 100)->nullable();
			$table->string('state', 100)->nullable();
			$table->string('zip', 100)->nullable();
			$table->string('city', 100)->nullable();
			$table->string('address', 1000)->nullable();
			$table->integer('no_of_cars_daily_limit')->unsigned();
			$table->integer('no_of_cars_weekly_limit')->unsigned();
			$table->integer('no_of_cars_monthly_limit')->unsigned();
			$table->integer('no_of_cars_annual_limit')->unsigned();
			$table->integer('no_of_cars_per_slot')->unsigned();
			$table->string('picture', 500)->nullable();
			$table->integer('tour_visitors_limit')->unsigned();
			$table->integer('tours_limit_per_slot')->unsigned();
			$table->integer('visitors_limit_per_slot')->unsigned();
			$table->time('opening_time');
			$table->time('closing_time');
			$table->float('adult_charges', 10, 0)->unsigned();
			$table->float('infant_charges', 10, 0)->unsigned();
			$table->float('car_charges', 10, 0)->unsigned();
			$table->float('convenience_charges', 10, 0)->unsigned()->default(0);
			$table->string('convenience_charges_type', 50)->nullable();
			$table->float('payment_processing_fee', 10, 0)->unsigned();
			$table->timestamps();
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
		Schema::drop('admin_default_settings');
	}

}
