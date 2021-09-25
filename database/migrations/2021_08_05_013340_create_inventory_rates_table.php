<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateInventoryRatesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('inventory_rates', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('inventory_id')->index('inventory_id');
			$table->decimal('rate', 10);
			$table->timestamps();
			$table->string('created_by_ip', 50)->nullable();
			$table->integer('created_by')->nullable()->index('created_by');
			$table->string('created_by_module', 100)->nullable();
			$table->string('updated_by_ip', 50)->nullable();
			$table->integer('updated_by')->nullable()->index('updated_by');
			$table->string('updated_by_module', 50)->nullable();
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
		Schema::drop('inventory_rates');
	}

}
