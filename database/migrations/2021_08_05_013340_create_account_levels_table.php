<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAccountLevelsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('account_levels', function(Blueprint $table)
		{
			$table->smallInteger('id', true);
			$table->string('level_no', 15)->nullable();
			$table->string('name', 50)->nullable();
			$table->integer('length')->nullable();
			$table->boolean('is_entry_level')->nullable();
			$table->boolean('is_active')->nullable()->default(1);
			$table->string('separator', 2)->nullable();
			$table->smallInteger('company_id')->nullable();
			$table->integer('created_by')->nullable();
			$table->string('CreationIP', 50)->nullable();
			$table->string('CreatedByModule', 100)->nullable();
			$table->dateTime('CreatedOn')->nullable();
			$table->boolean('IsDeleted')->nullable()->default(0);
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
		Schema::drop('account_levels');
	}

}
