<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCustomersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('customers', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('FirstName', 100);
			$table->string('LastName', 100);
			$table->string('Email', 50);
			$table->string('Phone', 50);
			$table->boolean('IsActive')->default(1);
			$table->string('CNIC', 25)->nullable();
			$table->boolean('is_cnic');
			$table->string('nationality', 100)->nullable();
			$table->string('iso', 10)->nullable();
			$table->boolean('black_list')->nullable();
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
		Schema::drop('customers');
	}

}
