<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGoodsReceiveNotesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('goods_receive_notes', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('purchase_order_id');
			$table->string('GRN_Number', 20);
			$table->string('InvoiceNumber', 20);
			$table->decimal('gTotal', 15)->nullable();
			$table->date('GRN_Date');
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
		Schema::drop('goods_receive_notes');
	}

}
