<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class SpGetTrialBalance extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $procedure = "
            CREATE PROCEDURE `GetTrialBalance`(LevelNoSent INT,  
            FiscalYearMasterID INT, 
            FromDate DATE,  
            ToDate DATE, 
            HotelId INT)
            BEGIN
                DECLARE LevelInDB INT;
                DECLARE TotalLevelDigitLength INT;  
                DECLARE Separat VARCHAR(3);
                DROP TEMPORARY TABLE IF EXISTS TrialBalance;
                CREATE TEMPORARY TABLE TrialBalance  
                (  
                AccountTitle VARCHAR(100),  
                AccountCode VARCHAR(50),  
                AccountLevel VARCHAR(50),
                AccountType INT,  
                Debit DECIMAL(18,2),  
                Credit DECIMAL(18,2),  
                Diff DECIMAL(18,2),   
                FiscalYear VARCHAR(100)  
                );
                SET TotalLevelDigitLength = (SELECT SUM(LENGTH) FROM account_levels WHERE  Is_Active = 1 AND Level_No <= LevelNoSent LIMIT 1);
                IF LevelNoSent = 5
                THEN
                SET TotalLevelDigitLength = TotalLevelDigitLength+1;
                END IF;
                INSERT INTO TrialBalance
                SELECT GL1.Title AS AccountTitle, TB.AccountCode ,GL1.Account_Level_id AS AccountLevel, GL1.account_type_id,  
                        CASE WHEN SUM(TB.DR) >= SUM(TB.CR) THEN SUM(TB.DR) - SUM(TB.CR) ELSE 0 END AS Debit,  
                        CASE WHEN SUM(TB.CR) > SUM(TB.DR) THEN SUM(TB.CR) - SUM(TB.DR) ELSE 0 END AS Credit,  
                    SUM(TB.DR) - SUM(TB.CR) AS Diff , TB.FiscalYear  
                    FROM  
                    (  
                    SELECT  InnerTB.Account_GL_Code,SUBSTRING(InnerTB.Account_GL_Code ,1,TotalLevelDigitLength+LevelNoSent-1 )AS AccountCode ,  
                        SUM(InnerTB.DR) AS DR , SUM(InnerTB.CR) AS CR ,  
                        SUM(InnerTB.DR) - SUM(InnerTB.CR) AS Diff , InnerTB.FiscalYear 
                    FROM    
                    (    
                        SELECT GL.Title, GL.Account_Level_id, GL.Account_GL_Code ,   
                        CASE WHEN IFNULL(GL.Opening_Balance , 0 ) >= 0 THEN IFNULL(GL.Opening_Balance , 0 ) ELSE 0 END AS DR ,   
                        CASE WHEN IFNULL(GL.Opening_Balance , 0 ) <  0 THEN ABS(IFNULL(GL.Opening_Balance , 0 )) ELSE 0 END AS CR ,  
                        FY.Title AS FiscalYear  
                        FROM account_gl AS GL INNER JOIN account_fiscalyears_master AS FY ON   
                        GL.account_Fiscal_Years_Master_ID = FY.ID AND  
                        GL.account_Fiscal_Years_Master_ID = FiscalYearMasterID 
                        UNION ALL  
                        SELECT GL.Title,GL.Account_Level_id, GL.Account_GL_Code , SUM(VD.DR_Amount) AS DR ,   
                        SUM(VD.CR_Amount) AS CR ,FY.Title AS FiscalYear  
                        FROM account_gl AS GL  INNER JOIN vouchers_master AS VM  ON  
                        GL.account_Fiscal_Years_Master_ID = VM.Fiscal_Year_Master_ID  
                        AND GL.account_Fiscal_Years_Master_ID = FiscalYearMasterID  INNER JOIN voucher_details AS VD  ON  
                        VM.ID = VD.Voucher_Master_ID AND GL.ID = VD.account_gl_id 
                        INNER JOIN account_fiscalyears_master AS FY ON GL.account_Fiscal_Years_Master_ID = FY.ID  
                        AND VM.Fiscal_Year_Master_ID = FY.ID  
                        WHERE  VM.date BETWEEN IFNULL(FromDate , VM.date ) AND IFNULL(ToDate, VM.date )  AND 
                        VM.Post = 'approved'
                        AND IFNULL(HotelId, VM.hotel_id)   
                        GROUP BY GL.Title,GL.Account_Level_id, GL.Account_GL_Code  , FY.Title  
                        )InnerTB   
                    GROUP BY InnerTB.Account_GL_Code ,InnerTB.Account_Level_id, InnerTB.FiscalYear   
                    )TB INNER JOIN account_gl AS GL1 ON  
                    TB.AccountCode = GL1.Account_GL_Code AND   
                    GL1.account_Fiscal_Years_Master_ID = FiscalYearMasterID   
                GROUP BY GL1.Title ,GL1.Account_Level_id, TB.AccountCode ,TB.FiscalYear    
                ORDER BY TB.AccountCode; 
                
                
                SELECT AccountTitle ,AccountLevel,AccountCode,AccountType, IFNULL(Debit,0.00) AS Debit , IFNULL(Credit,0.00) AS Credit FROM TrialBalance AS TrialBalance  
                    WHERE (Debit IS NOT NULL AND Credit IS NULL) OR   
                    (Debit IS NULL AND Credit IS NOT NULL) OR   
                    (Debit IS NOT NULL AND Credit IS NOT NULL); 
            END
        ";

        DB::unprepared("DROP procedure IF EXISTS GetTrialBalance");
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
