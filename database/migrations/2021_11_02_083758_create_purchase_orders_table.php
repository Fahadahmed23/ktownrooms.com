<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePurchaseOrdersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('purchase_orders', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('hotel_id');
			$table->integer('vendor_id');
			$table->string('PurchaseOrderNumber', 50);
			$table->date('PurchaseOrderDate');
			$table->decimal('gTotal', 15)->nullable();
			$table->integer('PreparedBy');
			$table->enum('Status', array('Pending','Approved','Rejected'));
			$table->integer('ApprovedBy');
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
		Schema::drop('purchase_orders');
	}

}
