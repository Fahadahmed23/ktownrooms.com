<?php

namespace App\Console\Commands;

use App\Models\Booking;
use App\Models\CronLog;
use App\Models\DefaultRule;
use Illuminate\Console\Command;

class ReminderCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminder:message';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reminder fo upcoming bookings';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function cron_logs($message)
    {
        # create logs if success or error comes
        $data = [
            'message' => $message,
        ]; 
        CronLog::create($data);
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            //code...
            $default_rule = DefaultRule::first();
            if($default_rule->reminder_before){
                $add_days_To_current_date = date('Y-m-d', strtotime($default_rule->reminder_before.' days'));
                $bookings = Booking::where('is_notified', 0)->whereDate('BookingFrom', $add_days_To_current_date)->get();
                foreach ($bookings as $key => $booking) {
                    # code...
                    $booking->sendReminderSms();
                    $booking->update(['is_notified'=>1]);
                    $this->cron_logs('Cron runs successfully for booking no: '.$booking->id);
                }
            }
            echo 'Reminder Successfully';
        } catch (\Throwable $th) {
            //throw $th;
            $this->cron_logs($th->getMessage());
            echo 'Check Log';
        }
    }
}
