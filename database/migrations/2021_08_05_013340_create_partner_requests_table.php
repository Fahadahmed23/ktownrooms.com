<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePartnerRequestsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('partner_requests', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('FullName');
			$table->string('HotelName')->nullable();
			$table->string('EmailAddress');
			$table->string('ContactNo', 20);
			$table->integer('NoOfRooms');
			$table->string('Location');
			$table->text('Description', 65535);
			$table->boolean('Status');
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
		Schema::drop('partner_requests');
	}

}
