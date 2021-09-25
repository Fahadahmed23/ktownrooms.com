<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateInventoriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('inventories', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('hotel_id')->index('hotel_id');
			$table->string('Title');
			$table->string('Image')->nullable();
			$table->integer('Quantity');
			$table->text('Description', 65535);
			$table->decimal('Rate', 10);
			$table->integer('LowStockAlert')->nullable();
			$table->boolean('Status')->default(1);
			$table->softDeletes();
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
		Schema::drop('inventories');
	}

}
