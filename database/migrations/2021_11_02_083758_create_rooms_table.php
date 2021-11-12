<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRoomsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('rooms', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('hotel_id')->index('hotel_id');
			$table->string('room_title');
			$table->string('thumbnail', 1500)->nullable();
			$table->integer('room_type_id')->index('room_type_id');
			$table->integer('room_category_id')->index('room_category_id');
			$table->string('RoomNumber', 50);
			$table->integer('FloorNo');
			$table->decimal('RoomCharges', 15);
			$table->integer('tax_rate_id')->nullable()->index('tax_rate_id');
			$table->softDeletes();
			$table->timestamps();
			$table->string('CreationIP', 50)->nullable();
			$table->integer('created_by')->nullable()->index('created_by');
			$table->string('CreatedByModule', 100)->nullable();
			$table->string('UpdationIP', 50)->nullable();
			$table->integer('updated_by')->nullable()->index('updated_by');
			$table->string('UpdatedByModule', 100)->nullable();
			$table->integer('room_status_id')->nullable();
			$table->boolean('is_available')->default(1);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('rooms');
	}

}
