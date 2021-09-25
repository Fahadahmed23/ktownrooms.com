<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGoodsReceiveNoteDetailsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('goods_receive_note_details', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('goods_receive_note_id');
			$table->integer('inventory_id');
			$table->string('Description', 225);
			$table->integer('ReceivedQuantity');
			$table->decimal('Rate', 15);
			$table->decimal('Total', 15)->nullable();
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
		Schema::drop('goods_receive_note_details');
	}

}
