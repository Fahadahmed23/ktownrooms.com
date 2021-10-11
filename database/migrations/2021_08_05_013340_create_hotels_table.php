<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateHotelsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('hotels', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('HotelName', 100);
			$table->string('Address', 200);
			$table->string('ZipCode', 7);
			$table->string('Longitude', 25);
			$table->string('Latitude', 25);
			$table->integer('city_id')->index('city_id');
			$table->integer('company_id')->index('company_id');
			$table->integer('partner_id')->nullable();
			// $table->integer('hotel_category_id')->nullable();
			$table->string('partnerPrice', 25)->nullable();
			$table->string('Rating', 25)->nullable();
			$table->string('Description')->nullable();
			$table->string('Code', 25)->nullable();
			$table->string('mapimage', 1500)->nullable();
			$table->string('metaTitle')->nullable();
			$table->string('metaKeyword')->nullable();
			$table->text('metaDescription', 65535)->nullable();
			$table->date('AgreStartDate')->nullable();
			$table->date('AgreEndDate')->nullable();
			$table->softDeletes();
			$table->timestamps();
			$table->string('CreationIP', 50);
			$table->integer('created_by')->index('created_by');
			$table->string('CreatedByModule', 100);
			$table->string('UpdationIP', 50)->nullable();
			$table->integer('updated_by')->nullable()->index('updated_by');
			$table->string('UpdatedByModule', 100)->nullable();
			$table->boolean('has_tax')->nullable()->default(0);
			$table->integer('tax_rate_id')->nullable()->default(0);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('hotels');
	}

}
