<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateExperiencesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('experiences', function(Blueprint $table)
		{
			$table->bigInteger('ExperiencesID', true);
			$table->string('OriginalExperiencesName')->nullable();
			$table->integer('CityID')->default(0);
			$table->string('Slug')->nullable();
			$table->string('OwnerName', 50)->nullable();
			$table->string('ExperiencesName')->nullable();
			$table->string('Address')->nullable();
			$table->string('Address2')->nullable();
			$table->bigInteger('PartnerRequestID')->default(0);
			$table->integer('ExperiencesTypeID')->default(0)->index('HotelTypeID');
			$table->date('AgreementStartDate')->nullable();
			$table->date('AgreementEndDate')->nullable();
			$table->decimal('PartnerPrice', 11)->default(0.00);
			$table->decimal('SellingPrice', 11)->default(0.00);
			$table->integer('NoOfGuests')->comment('per room');
			$table->integer('NoOfRooms')->default(0)->comment('total rooms');
			$table->decimal('AdultCharges', 11)->default(0.00)->comment('per adult (if more than one adult)');
			$table->text('Description', 65535)->nullable();
			$table->text('MetaTitle', 65535)->nullable();
			$table->text('MetaKeywords', 65535)->nullable();
			$table->text('MetaDescription', 65535)->nullable();
			$table->text('ActiveDates', 65535)->nullable();
			$table->boolean('Rating')->default(0)->comment('1-5');
			$table->integer('Discount')->default(0)->comment('in percent');
			$table->string('Image')->nullable();
			$table->string('Thumbnail')->nullable();
			$table->boolean('Status');
			$table->boolean('AutoApprove')->default(0)->comment('on booking auto approve booking or not');
			$table->string('HostImage')->nullable();
			$table->text('HostDescription', 65535)->nullable();
			$table->dateTime('DateAdded');
			$table->dateTime('DateModified')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('experiences');
	}

}
