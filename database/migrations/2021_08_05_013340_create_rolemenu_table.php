<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRolemenuTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('rolemenu', function(Blueprint $table)
		{
			$table->integer('id');
			$table->integer('RoleCode');
			$table->integer('MenuCode');
			$table->boolean('CanAdd')->nullable();
			$table->boolean('CanUpdate')->nullable();
			$table->boolean('CanDelete')->nullable();
			$table->timestamps();
			$table->string('CreationIP', 50)->nullable();
			$table->integer('created_by')->nullable();
			$table->string('CreatedByModule', 100)->nullable();
			$table->string('UpdationIP', 50)->nullable();
			$table->integer('updated_by')->nullable();
			$table->string('UpdatedByModule', 100)->nullable();
			$table->softDeletes();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('rolemenu');
	}

}
