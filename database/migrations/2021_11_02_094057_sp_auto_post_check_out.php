<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class SpAutoPostCheckOut extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $procedure = "
            CREATE PROCEDURE `AutoPostCheckout`(b_id INT, u_id INT, nights INT)
            BEGIN
                DECLARE acct_gl_code VARCHAR(50) DEFAULT NULL;
                DECLARE is_d TINYINT(4) DEFAULT 0;
                DROP TEMPORARY TABLE IF EXISTS rules;
                CREATE TEMPORARY TABLE rules (
                    id INT,
                    account_gl_id VARCHAR(50),
                    is_dr TINYINT(4),
                    is_cr TINYINT(4)
                );
                
                SET @narration = 'Checkout for ';
                
                -- Get net_total of booking
                SET @net_total = (SELECT per_night_charges FROM booking_invoices WHERE booking_id = b_id);                                                                                                                                                                                         
                
                -- Get account_auto_posting_type.id for checkedin
                SET @type_id = (SELECT id FROM account_auto_posting_type a WHERE a.is_active = 1 AND a.title='checkedin' LIMIT 1);
                
                -- Get account_auto_posting rules
                INSERT INTO rules SELECT id, account_gl_code, is_dr, is_cr FROM account_auto_posting WHERE auto_posting_type_id=@type_id;
                
                -- Get current Fiscal Year
                SET @fiscal_year_title =  '';
                SET @fiscal_year_id = 1;
                SELECT id, account_fiscalyears_master.title INTO @fiscal_year_id, @fiscal_year_title FROM account_fiscalyears_master WHERE STATUS='active' LIMIT 1;
                
                -- insert into vouchers_master
                SET @v_type_id = (SELECT id FROM voucher_types  WHERE voucher_types.title = 'Auto Posting');
                SET @b_no = '';
                SET @hotel_id = 0;
                SELECT booking_no, hotel_id INTO @b_no, @hotel_id FROM bookings WHERE id = b_id LIMIT 1;
                
                INSERT INTO vouchers_master (voucher_type_id, description, DATE, post_date, post, fiscal_year_master_id, current_fiscal_year, booking_id, hotel_id, CreatedBy) VALUES (@v_type_id, CONCAT(@narration, @b_no), CURDATE(), CURDATE(), 'approved', @fiscal_year_id, @fiscal_year_title, b_id, @hotel_id, u_id);
                SET @v_master_id = (SELECT LAST_INSERT_ID());
                
                SET @cnt_rules = (SELECT COUNT(*) FROM rules);
                
                SET @l = 0;
                SET @i = 0;
                
                -- SELECT * FROM rules;
                -- SELECT @v_master_id, @cnt_rules;
                
                WHILE @i < @cnt_rules DO
                    SET @gl_code = '';
                    SET @is_dr = 0;
                    
                    SET @dr_amount = 0;
                    SET @cr_amount = 0;
                    
                    SELECT id, account_gl_id, is_dr INTO @l, @gl_code, @is_dr FROM rules WHERE id > @l LIMIT 1;
                    -- SELECT @l, @gl_code, @is_dr;
                    SET @gl_id = (SELECT id FROM account_gl WHERE account_gl_code=@gl_code LIMIT 1);
                    
                    IF @is_dr > 0 THEN
                        SET @cr_amount = @net_total * nights;
                    ELSE
                        SET @dr_amount = @net_total * nights;
                    END IF;
                    -- SELECT @cr_amount, @dr_amount;
                    INSERT INTO voucher_details (voucher_master_id, account_gl_id, dr_amount, cr_amount, narration, created_by) VALUES(@v_master_id, @gl_id, @dr_amount, @cr_amount, CONCAT(@narration, @b_no) ,u_id);
                    SET @i = @i + 1;
                END WHILE;
                SELECT @i;
            END
        ";

        DB::unprepared("DROP procedure IF EXISTS AutoPostCheckout");
        DB::unprepared($procedure);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
