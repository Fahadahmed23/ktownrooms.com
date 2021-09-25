<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToInventoryRatesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('inventory_rates', function(Blueprint $table)
		{
			$table->foreign('inventory_id', 'inventories_ibfk_1')->references('id')->on('inventories')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('inventory_rates', function(Blueprint $table)
		{
			$table->dropForeign('inventories_ibfk_1');
		});
	}

}
