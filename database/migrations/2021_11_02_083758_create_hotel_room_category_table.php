<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateHotelRoomCategoryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('hotel_room_category', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('hotel_id')->nullable()->index('hotel_id');
			$table->integer('room_category_id')->nullable()->index('room_category_id');
			$table->integer('allowed')->nullable();
			$table->integer('max_allowed')->nullable();
			$table->boolean('status')->nullable();
			$table->decimal('additional_guest_charges', 11)->nullable()->default(0.00);
			$table->timestamps();
			$table->softDeletes();
			$table->integer('created_by')->nullable()->index('created_by');
			$table->integer('updated_by')->index('updated_by');
			$table->string('CreatedByModule', 100);
			$table->string('UpdatedByModule', 100);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('hotel_room_category');
	}

}
