<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateInventoriesLogTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('inventories_log', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('inventory_id')->nullable();
			$table->enum('type', array('purchase','sale'))->nullable();
			$table->decimal('rate', 11)->nullable();
			$table->integer('quantity')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('inventories_log');
	}

}
