<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateItemstocklogsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('itemstocklogs', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('ItemStockCode');
			$table->integer('ItemCategoryCode');
			$table->integer('ItemCode');
			$table->integer('HotelCode');
			$table->integer('CurrentQuantity');
			$table->dateTime('LogDate');
			$table->softDeletes();
			$table->timestamps();
			$table->string('CreationIP', 50);
			$table->integer('created_by');
			$table->string('CreatedByModule', 100);
			$table->string('UpdationIP', 50)->nullable();
			$table->integer('updated_by')->nullable();
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
		Schema::drop('itemstocklogs');
	}

}
