<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAccountSubTypesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('account_sub_types', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('title', 50)->nullable();
			$table->integer('account_type_id')->nullable();
			$table->string('CreatedByModule', 100)->nullable();
			$table->string('CreationIP', 50)->nullable();
			$table->integer('created_by')->nullable();
			$table->timestamps();
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
		Schema::drop('account_sub_types');
	}

}
