<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterVoucherDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('voucher_details', function (Blueprint $table) {
            $table->integer('created_by')->after('cr_amount')->nullable()->index('created_by');
			$table->integer('updated_by')->after('created_by')->nullable()->index('updated_by');
            $table->tinyInteger('is_concile')->after('account_gl_id')->default(0);
            $table->foreign('created_by', 'voucher_details_ibfk_1')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('updated_by', 'voucher_details_ibfk_2')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('voucher_details', function (Blueprint $table) {
            $table->dropForeign('voucher_details_ibfk_1');
			$table->dropForeign('voucher_details_ibfk_2');
            $table->dropColumn('is_concile');
        });
    }
}
