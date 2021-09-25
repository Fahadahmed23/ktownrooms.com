<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAccountAutoPostSetupTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('account_auto_post_setup', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('head_title', 100)->nullable();
			$table->string('account_gl_id', 50)->nullable();
			$table->string('account_gl_title', 100)->nullable();
			$table->smallInteger('account_level')->nullable();
			$table->string('posting_type', 10)->nullable();
			$table->integer('account_type_id')->nullable();
			$table->boolean('is_bank_account')->nullable()->default(0);
			$table->boolean('is_default_account')->nullable()->default(0);
			$table->boolean('is_active')->nullable()->default(1);
			$table->dateTime('CreationDate')->nullable()->default(\DB::raw('CURRENT_TIMESTAMP'));
			$table->string('CreationIP', 50)->nullable();
			$table->integer('CreatedByUser')->nullable();
			$table->string('CreatedByModule', 100)->nullable();
			$table->dateTime('UpdationDate')->nullable();
			$table->string('UpdationIP', 50)->nullable();
			$table->integer('UpdatedByUser')->nullable();
			$table->string('UpdatedByModule', 100)->nullable();
			$table->boolean('IsDeleted')->nullable()->default(0);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('account_auto_post_setup');
	}

}
