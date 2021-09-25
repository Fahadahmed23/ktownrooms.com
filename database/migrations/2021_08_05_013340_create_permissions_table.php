<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePermissionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('permissions', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('name', 573)->nullable();
			$table->string('display_name', 573)->nullable();
			$table->string('description', 573)->nullable();
			$table->string('url', 573)->nullable();
			$table->string('view_name', 573)->nullable();
			$table->string('group', 573)->nullable();
			$table->boolean('is_active')->nullable();
			$table->timestamps();
			$table->integer('created_by')->nullable()->index('created_by');
			$table->integer('updated_by')->nullable()->index('updated_by');
			$table->string('created_by_ip', 150)->nullable();
			$table->string('updated_by_ip', 150)->nullable();
			$table->text('create_data', 65535)->nullable();
			$table->text('update_data', 65535)->nullable();
			$table->string('created_by_module', 300)->nullable();
			$table->string('updated_by_module', 300)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('permissions');
	}

}
