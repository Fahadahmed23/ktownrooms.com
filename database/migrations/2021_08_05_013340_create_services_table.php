<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateServicesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('services', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('service_type_id')->index('service_type_id');
			$table->integer('hotel_id')->nullable();
			$table->integer('department_id');
			$table->integer('inventory_id')->nullable();
			$table->string('Service', 100);
			$table->string('IconPath', 150)->nullable();
			$table->decimal('Charges', 15)->default(0.00);
			$table->string('ServingTime', 50);
			$table->time('service_start_time')->nullable();
			$table->time('service_end_time')->nullable();
			$table->boolean('IsShowDelayAlert')->nullable()->default(0);
			$table->boolean('IsInventory')->nullable()->default(0);
			$table->boolean('IsQuantitative')->nullable();
			$table->softDeletes();
			$table->timestamps();
			$table->string('CreationIP', 50);
			$table->integer('created_by')->index('created_by');
			$table->string('CreatedByModule', 100);
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
		Schema::drop('services');
	}

}
