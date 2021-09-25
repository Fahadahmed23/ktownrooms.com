<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateVoucherTypesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('voucher_types', function(Blueprint $table)
		{
			$table->smallInteger('id', true);
			$table->string('title', 100)->nullable()->unique('title');
			$table->string('description', 300)->nullable();
			$table->string('abbreviation', 10);
			$table->dateTime('CreationDate')->nullable()->default(\DB::raw('CURRENT_TIMESTAMP'));
			$table->string('CreationIP', 50)->nullable();
			$table->integer('created_by')->nullable();
			$table->string('CreatedByModule', 100)->nullable();
			$table->dateTime('UpdationDate')->nullable();
			$table->string('UpdationIP', 50)->nullable();
			$table->integer('UpdatedByUser')->nullable();
			$table->string('UpdatedByModule', 100)->nullable();
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
		Schema::drop('voucher_types');
	}

}
