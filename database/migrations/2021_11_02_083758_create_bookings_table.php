<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBookingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('bookings', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->string('booking_no', 100)->nullable();
			$table->string('booking_code', 50)->nullable();
			$table->string('booking_title')->nullable();
			$table->enum('status', array('Pending','Confirmed','Cancelled','CheckedIn','CheckedOut'))->nullable();
			$table->boolean('agent_id')->nullable();
			$table->integer('customer_id')->index('customer_id');
			$table->integer('tax_rate_id')->nullable()->index('tax_rate_id');
			$table->integer('hotel_id')->nullable()->index('hotel_id');
			$table->dateTime('BookingDate');
			$table->date('BookingFrom');
			$table->date('BookingTo');
			$table->smallInteger('no_occupants')->nullable();
			$table->integer('promotion_id')->nullable()->index('promotion_id');
			$table->boolean('IsDocumentSubmitted', 1)->default(0);
			$table->boolean('IsCheckedIn')->default(0);
			$table->boolean('IsCheckedOut')->default(0);
			$table->softDeletes();
			$table->timestamps();
			$table->string('CreationIP', 50)->nullable();
			$table->integer('created_by')->nullable()->index('created_by');
			$table->string('CreatedByModule', 100)->nullable();
			$table->string('UpdationIP', 50)->nullable();
			$table->integer('updated_by')->nullable()->index('updated_by');
			$table->string('UpdatedByModule', 100)->nullable();
			$table->string('CancelReason')->nullable();
			$table->string('channel', 50)->nullable();
			$table->boolean('is_corporate')->nullable()->default(0);
			$table->boolean('is_bed_dead')->default(0);
			$table->string('purpose_of_stay', 100)->nullable();
			$table->string('special_request', 100)->nullable();
			$table->string('discount_reason')->nullable();
			$table->string('origin', 50)->nullable();
			$table->string('additional_comments')->nullable();
			$table->dateTime('checkin_time')->nullable();
			$table->dateTime('checkout_time')->nullable();
			$table->boolean('is_third_party')->default(0);
			$table->integer('booking_third_party_id')->nullable();
			$table->boolean('is_central_booking')->nullable();
			$table->boolean('is_notified')->nullable()->default(0);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('bookings');
	}

}
