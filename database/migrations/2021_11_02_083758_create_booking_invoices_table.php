<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBookingInvoicesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('booking_invoices', function(Blueprint $table)
		{
			$table->integer('id', true);
			$table->integer('booking_id')->index('FK_bi_Booking_id');
			$table->integer('customer_id')->nullable()->index('customer_id');
			$table->decimal('total', 10);
			$table->decimal('discount_amount', 10);
			$table->decimal('net_total', 10);
			$table->decimal('checkout_discount', 10)->nullable();
			$table->boolean('paid')->nullable()->default(0);
			$table->integer('payment_mode_id')->index('payment_mode_id');
			$table->dateTime('payment_date')->nullable();
			$table->decimal('payment_amount', 10)->nullable()->default(0.00);
			$table->timestamps();
			$table->integer('created_by')->index('created_by');
			$table->integer('updated_by')->nullable()->index('updated_by');
			$table->softDeletes();
			$table->string('payment_mode_name', 50)->nullable();
			$table->string('payment_mode_details', 50)->nullable();
			$table->string('customer_first_name', 50)->nullable();
			$table->string('customer_last_name', 50)->nullable();
			$table->string('customer_cnic', 50)->nullable();
			$table->string('customer_email', 50)->nullable();
			$table->string('customer_phone', 50)->nullable();
			$table->integer('tax_rate_id')->nullable()->index('tax_rate_id');
			$table->string('tax_name', 50)->nullable();
			$table->decimal('tax_rate', 10)->nullable();
			$table->decimal('tax_charges', 10)->nullable();
			$table->integer('promo_id')->nullable()->index('promo_id');
			$table->string('promo_code', 50)->nullable();
			$table->boolean('promo_is_percentage')->nullable();
			$table->decimal('promo_value', 11)->nullable();
			$table->integer('num_occupants')->nullable();
			$table->string('hotel_name')->nullable();
			$table->integer('hotel_id')->nullable()->index('hotel_id');
			$table->integer('city_id')->nullable()->index('city_id');
			$table->string('city_name')->nullable();
			$table->dateTime('checkin_date')->nullable();
			$table->dateTime('checkout_date')->nullable();
			$table->integer('nights')->nullable();
			$table->integer('num_rooms')->nullable();
			$table->boolean('per_night')->nullable()->default(0);
			$table->decimal('discount_per_night', 11)->nullable()->default(0.00);
			$table->boolean('is_corporate')->nullable()->default(0);
			$table->integer('corporate_client_id')->nullable();
			$table->string('corporate_client_name', 100)->nullable();
			$table->integer('customer_nationality')->nullable();
			$table->decimal('per_night_charges', 10)->nullable();
			$table->boolean('is_corporate')->nullable()->default(0);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('booking_invoices');
	}

}
