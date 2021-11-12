<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class SpGetNetIncome extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $procedure = "
            CREATE PROCEDURE `GetNetIncome`(LevelNoSent INT,
            FiscalYearMasterID INT,
            FromDate DATE ,
            ToDate DATE,
            HotelId INT,
            OUT Result decimal)
            BEGIN
                -- DECLARE LevelNoSent INT;
                DECLARE LevelInDB INT;
                DECLARE TotalLevelDigitLength INT;  
                DECLARE Separat VARCHAR(3);
                DROP TEMPORARY TABLE IF EXISTS TrialBalance;
                DROP TABLE IF EXISTS IncomeStatement;
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
                CREATE TEMPORARY TABLE IncomeStatement  
                (  
                    OrderNo INT,
                    GroupNo INT,
                    AccountTitle VARCHAR(100),
                    AccountLevel INT,
                    AccountType INT, 
                    AccountCode VARCHAR(50),
                    Debit DECIMAL(18,2),
                    Credit DECIMAL(18,2),	
                    Total DECIMAL(18,2),	
                    FiscalYear INT  
                );
                SET TotalLevelDigitLength = (SELECT SUM(LENGTH) FROM account_levels WHERE  Is_Active = 1 AND Level_No <= LevelNoSent LIMIT 1);
                IF LevelNoSent = 5
                THEN
                SET TotalLevelDigitLength = TotalLevelDigitLength+1;
                END IF;
                
                
                
                SELECT 1 ,1 , 'Income', 1 ,4,'0',  0.00, 0.00,SUM(IFNULL(Total,0.00)),FiscalYearMasterID 
                INTO @OrderNotv ,@GroupNotv ,@AccountTitletv ,@AccountLeveltv,@AccountTypetv ,@AccountCodetv,@Debittv ,@Credittv ,@Totaltv ,@FiscalYeartv 
                FROM IncomeStatement Limit 1;
                INSERT INTO IncomeStatement
                VALUES(@OrderNotv ,
                        @GroupNotv ,
                        @AccountTitletv ,
                        @AccountLeveltv ,
                        @AccountTypetv ,
                        @AccountCodetv,
                        @Debittv ,
                        @Credittv ,	
                        @Totaltv ,	
                        @FiscalYeartv);
                
                
                INSERT INTO TrialBalance
                SELECT GL1.Title AS AccountTitle, TB.AccountCode ,GL1.Account_Level_id AS AccountLevel, GL1.account_type_id,  
                        CASE WHEN SUM(TB.DR) >= SUM(TB.CR) THEN SUM(TB.DR) - SUM(TB.CR) ELSE 0 END AS Debit,  
                        CASE WHEN SUM(TB.CR) > SUM(TB.DR) THEN SUM(TB.CR) - SUM(TB.DR) ELSE 0 END AS Credit,  
                        TB.CR - TB.DR AS Diff , TB.FiscalYear  
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
                    AND GL1.account_type_id IN (4,5) and GL1.Account_Level_id <> 1
                GROUP BY GL1.Title ,GL1.Account_Level_id, TB.AccountCode ,TB.FiscalYear    
                ORDER BY TB.AccountCode; 
                INSERT INTO IncomeStatement
                SELECT   2 AS OrderNo, 
                            1 AS GroupNo, 
                            t.AccountTitle,
                            t.AccountLevel, 
                            t.AccountType,
                            t.AccountCode,
                            t.Debit, 
                            t.Credit,						
                        t.Diff AS Total,			
                        FiscalYearMasterID AS FiscalYear 
                        FROM TrialBalance t WHERE t.AccountType = 4;  
                
                SELECT 3 ,1 , 'Total Income', 1,4 ,'0',  0.00, 0.00,SUM(i.Credit),FiscalYearMasterID 
                INTO @OrderNotv ,@GroupNotv ,@AccountTitletv ,@AccountLeveltv,@AccountTypetv  ,@AccountCodetv,@Debittv ,@Credittv ,@Totaltv ,@FiscalYeartv 
                FROM IncomeStatement i
                WHERE i.OrderNo IN(2)AND i.AccountType = 4;
                INSERT INTO IncomeStatement
                VALUES(@OrderNotv ,
                        @GroupNotv ,
                        @AccountTitletv ,
                        @AccountLeveltv ,
                        @AccountTypetv ,
                        @AccountCodetv,
                        @Debittv ,
                        @Credittv ,	
                        @Totaltv ,	
                        @FiscalYeartv); 
                SELECT 1 ,2 , 'Expense', 1 ,5,'0',  0.00, 0.00,0.00,FiscalYearMasterID 
                INTO @OrderNotv ,@GroupNotv ,@AccountTitletv ,@AccountLeveltv,@AccountTypetv ,@AccountCodetv,@Debittv ,@Credittv ,@Totaltv ,@FiscalYeartv 
                FROM IncomeStatement LIMIT 1;
                INSERT INTO IncomeStatement
                VALUES(@OrderNotv ,
                        @GroupNotv ,
                        @AccountTitletv ,
                        @AccountLeveltv ,
                        @AccountTypetv ,
                        @AccountCodetv,
                        @Debittv ,
                        @Credittv ,	
                        @Totaltv ,	
                        @FiscalYeartv);   
                        
                        
                        
                INSERT INTO IncomeStatement
                SELECT   2 AS OrderNo, 
                            2 AS GroupNo, 
                            t.AccountTitle,
                            t.AccountLevel, 
                            t.AccountType,
                            t.AccountCode,
                            t.Debit, 
                            t.Credit,						
                        t.Diff AS Total,			
                        FiscalYearMasterID AS FiscalYear 
                        FROM TrialBalance t WHERE t.AccountType = 5;  
                        
                SELECT 3 ,2 , 'Total Expense', 1,5 ,'0',  0.00, 0.00,SUM(i.Credit),FiscalYearMasterID 
                INTO @OrderNotv ,@GroupNotv ,@AccountTitletv ,@AccountLeveltv,@AccountTypetv  ,@AccountCodetv,@Debittv ,@Credittv ,@Totaltv ,@FiscalYeartv 
                FROM IncomeStatement i
                WHERE i.OrderNo IN(2)AND i.AccountType = 5;
                INSERT INTO IncomeStatement
                VALUES(@OrderNotv ,
                        @GroupNotv ,
                        @AccountTitletv ,
                        @AccountLeveltv ,
                        @AccountTypetv ,
                        @AccountCodetv,
                        @Debittv ,
                        @Credittv ,	
                        @Totaltv ,	
                        @FiscalYeartv);
                        
                        
                SET @OrderNotv=0;
                SET @GroupNotv=3;
                SET @AccountTitletv='Net Income';
                SET @AccountLeveltv=1;
                SET @AccountTypetv=0;
                SET @AccountCodetv='0';
                SET @Debittv=0.00;
                SET @Credittv=0.00;
                SET @TotalIncome=(Select Total from IncomeStatement where OrderNo=3 and GroupNo=1 limit 1 );
                SET @TotalExpense=(SELECT Total FROM IncomeStatement WHERE OrderNo=3 AND GroupNo=2 LIMIT 1 );
                SET @Totaltv = @TotalIncome - @TotalExpense;
                SET @FiscalYeartv = FiscalYearMasterID;
                        
                INSERT INTO IncomeStatement
                VALUES(@OrderNotv ,
                        @GroupNotv ,
                        @AccountTitletv ,
                        @AccountLeveltv ,
                        @AccountTypetv ,
                        @AccountCodetv,
                        @Debittv ,
                        @Credittv ,	
                        @Totaltv ,	
                        @FiscalYeartv);
                        
                SET Result = (SELECT Total FROM IncomeStatement WHERE OrderNo = 0 AND GroupNo=3 AND AccountTitle='Net Income' LIMIT 1);
              
            END
        ";

        DB::unprepared("DROP procedure IF EXISTS GetNetIncome");
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
