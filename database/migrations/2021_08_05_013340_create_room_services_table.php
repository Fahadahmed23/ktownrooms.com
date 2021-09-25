<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRoomServicesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('room_services', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('room_id')->index('room_id');
			$table->integer('service_id')->index('service_id');
			$table->integer('limit')->nullable();
			$table->boolean('IsServiceForAll', 1)->nullable();
			$table->integer('AllowedServiceForPersons')->nullable();
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
		Schema::drop('room_services');
	}

}
