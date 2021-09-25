<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateComplainStatusesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('complain_statuses', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('ComplainStatus', 50);
			$table->softDeletes();
			$table->timestamps();
			$table->string('CreationIP', 50)->nullable();
			$table->integer('created_by')->nullable()->index('created_by');
			$table->string('CreatedByModule', 100)->nullable();
			$table->string('UpdationIP', 50)->nullable();
			$table->integer('updated_by')->nullable()->index('updated_by');
			$table->string('UpdatedByModule', 100)->nullable();
			$table->string('style_class', 50)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('complain_statuses');
	}

}
