<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePurchaseOrderDetailsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('purchase_order_details', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('purchase_order_id');
			$table->integer('inventory_id');
			$table->integer('ItemCategoryCode')->nullable();
			$table->string('Description', 191);
			$table->integer('Quantity');
			$table->decimal('Rate', 15);
			$table->decimal('Total', 15);
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
		Schema::drop('purchase_order_details');
	}

}
