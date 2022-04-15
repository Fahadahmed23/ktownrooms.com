<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateModuleReportsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('module_reports', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('module_id')->nullable()->index('module_id');
			$table->string('role_ids', 191)->nullable();
			$table->string('name', 191)->nullable();
			$table->string('description', 191)->nullable();
			$table->string('report_name', 191)->nullable();
			$table->text('columns', 191)->nullable();
			$table->text('criteria', 191)->nullable();
			$table->text('grouped_columns', 191)->nullable();
			$table->timestamps();
			$table->integer('created_by')->nullable()->index('created_by');
			$table->integer('updated_by')->nullable()->index('updated_by');
			$table->string('created_by_ip', 150)->nullable();
			$table->string('updated_by_ip', 150)->nullable();
			$table->text('create_data', 191)->nullable();
			$table->text('update_data', 191)->nullable();
			$table->string('created_by_module', 191)->nullable();
			$table->string('updated_by_module', 191)->nullable();
			$table->boolean('is_active')->nullable()->default(1);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('module_reports');
	}

}
