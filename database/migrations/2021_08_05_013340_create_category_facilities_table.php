<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCategoryFacilitiesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('category_facilities', function(Blueprint $table)
		{
			$table->bigInteger('id', true);
			$table->integer('room_category_id')->index('room_category_id');
			$table->integer('facility_id')->index('facility_id');
			$table->softDeletes();
			$table->timestamps();
			$table->string('CreationIP', 50)->nullable();
			$table->integer('created_by')->nullable()->index('created_by');
			$table->string('CreatedByModule', 100)->nullable();
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
		Schema::drop('category_facilities');
	}

}
