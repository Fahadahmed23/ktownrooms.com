<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRoomCategoriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('room_categories', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('RoomCategory', 100);
			$table->integer('AllowedOccupants');
			$table->integer('MaxAllowedOccupants');
			$table->decimal('AdditionalGuestCharges', 11)->nullable()->default(500.00);
			$table->string('Border', 200)->nullable();
			$table->string('Color', 200)->nullable();
			$table->softDeletes();
			$table->timestamps();
			$table->string('CreationIP', 50);
			$table->integer('created_by')->index('created_by');
			$table->string('CreatedByModule', 100);
			$table->string('UpdationIP', 50)->nullable();
			$table->integer('updated_by')->nullable()->index('updated_by');
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
		Schema::drop('room_categories');
	}

}
