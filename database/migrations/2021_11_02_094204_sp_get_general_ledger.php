<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class SpGetGeneralLedger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $procedure = "
            CREATE PROCEDURE `GetGeneralLedger`(DateFrom VARCHAR (25), DateTo VARCHAR (25),AccountGLName VARCHAR (191),STATUS VARCHAR (25),HotelId INT)
            BEGIN
            DECLARE idx INT; 
            DECLARE slice TEXT;
            DROP TABLE IF EXISTS Result;
            CREATE TEMPORARY TABLE Result  
            (  
             Items VARCHAR(200)
            );
            DROP TABLE IF EXISTS Result2;
            CREATE TEMPORARY TABLE Result2  
            (  
             Items VARCHAR(200)
            );
            SET idx = 1;
            IF LENGTH(AccountGLName)<1 OR AccountGLName IS NULL THEN
             SET AccountGLName = NULL; 
            ELSE
            WHILE idx!= 0 && LENGTH(AccountGLName) !=0
            DO
                SET idx = (SELECT LOCATE(',',AccountGLName));   
                    SET slice = (SELECT IF(idx <> 0, (SELECT LEFT(AccountGLName,idx - 1)), AccountGLName));
                    IF(LENGTH(slice)>0)
                    THEN  
                        INSERT INTO Result(Items) VALUES(slice);
                        INSERT INTO Result2(Items) VALUES(slice);       
                END IF;
                    SET AccountGLName = RIGHT(AccountGLName,LENGTH(AccountGLName) - idx);   
            END WHILE;
            END IF; 
             
              IF (AccountGLName = '') 
              THEN SET AccountGLName = NULL ;
              END IF;
              IF (DateFrom = '') THEN
              SET DateFrom = NULL ;
              END IF;
              IF (DateTo = '') THEN
              SET DateTo = NULL ;
              END IF;
              IF (STATUS = 'All') THEN
              SET STATUS = NULL ;
              END IF;
              
              
              SELECT 
                Ledger.Title,
                Ledger.VoucherName,
                Ledger.AccountHead,
                Ledger.AccountGlCode,
                Ledger.VoucherNo,
                Ledger.ChequeNo,
                Ledger.Description,
                Ledger.CreateDate,
                Ledger.PostDate,
                Ledger.RefNo,
                Ledger.Narration,
                Ledger.PartyName 
              FROM
                (SELECT 
                  '' Title,
                  '' AS VoucherName,
                  GL.`title` AS AccountHead,
                  GL.`account_gl_code` AS AccountGlCode,
                  '' AS VoucherNo,
                  '' AS ChequeNo,
                  '' AS Description,
                  '' AS CreateDate,
                  '' AS PostDate,
                  -- '' AS CostCenter,
                  '' AS RefNo,
                  'Opening Balance As Of : ' + IFNULL(DateFrom, '') AS Narration,
                  '' AS PartyName 
                FROM
                  `account_gl` GL 
                  LEFT JOIN `account_fiscalyears_master` FY 
                    ON GL.`account_fiscal_years_master_id` = FY.`id` 
                  LEFT JOIN `account_levels` AL 
                    ON GL.`account_level_id` = AL.`id` 
                WHERE FY.`status` = 'active' 
                  AND AL.`is_entry_level` = 1 
                  AND (GL.`id` IN (SELECT items FROM Result) OR AccountGLName IS NULL) -- and GL.[Title]='Employee GL'			
                UNION
                ALL 
                SELECT 
                  VT.`title` AS Title,
                  VT.`description` AS VoucherName,
                  GL.`title` AS AccountHead,
                  GL.`account_gl_code` AS AccountGlCode,
                  VM.`voucher_no` AS VoucherNo,
                  VM.`cheque_no` AS ChequeNo,
                  VM.`description` AS Description,
                  VM.`date` AS CreateDate,
                  VM.`post_date` AS PostDate,
                  -- ,CC.DepartmentTitle AS CostCenter
                  VD.`ref_no` AS RefNo,
                  VD.`narration` AS Narration,
                  '' AS PartyName 
                FROM
                  `account_gl` GL 
                  LEFT JOIN `account_fiscalyears_master` FY 
                    ON GL.`account_fiscal_years_master_id` = FY.`id` 
                  LEFT JOIN `voucher_details` VD 
                    ON GL.`id` = VD.`account_gl_id` 
                  LEFT JOIN `vouchers_master` VM 
                    ON VD.`voucher_master_id` = VM.`id` 
                    AND VM.`date` BETWEEN IFNULL(DateFrom, VM.`date`) 
                    AND IFNULL(DateTo, VM.`date`) -- LEFT JOIN  General_Department CC ON VD.CostCenterID = CC.DepartmentID
                  LEFT JOIN `voucher_types` VT 
                    ON VM.`voucher_type_id` = VT.`id` 
                  LEFT JOIN `account_levels` AL 
                    ON GL.`account_level_id` = AL.`id` 
                WHERE FY.`status` = 'active' 
                  AND AL.`is_entry_level` = 1 
                  AND IFNULL(HotelId, VM.hotel_id)
                  AND (GL.`id` IN (SELECT items FROM Result2) OR AccountGLName IS NULL) -- and GL.[Title]='Employee GL'
                  AND VM.`post` LIKE CONCAT('%', IFNULL(STATUS, ''), '%'))Ledger ;
            END
        ";

        DB::unprepared("DROP procedure IF EXISTS GetGeneralLedger");
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
