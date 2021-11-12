<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePurchaseordermasterTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('purchaseordermaster', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('HotelCode');
			$table->integer('VendorID');
			$table->string('PurchaseOrderNumber', 50);
			$table->dateTime('PurchaseOrderDate');
			$table->integer('PreparedBy');
			$table->integer('StatusCode');
			$table->integer('ApprovedBy');
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
		Schema::drop('purchaseordermaster');
	}

}
