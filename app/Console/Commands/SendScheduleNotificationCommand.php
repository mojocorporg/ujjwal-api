<?php

namespace App\Console\Commands;

use App\Models\Notification;
use Illuminate\Console\Command;
use App\Jobs\Notification\ScheduledNotificationProcessJob;

class SendScheduleNotificationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    function calculateTimeDiff($notification_time)
    {
        $data = [];
        $data['send_notification'] = false;
        $current_time = date('H:i');
        $str_current_time = strtotime($current_time);

        $diff_time = \Config::get('app.schedule_frequency');

        $new_time = date("H:i", strtotime("+" . $diff_time . " minutes", $str_current_time));
        
        if ($current_time < $notification_time && $new_time > $notification_time) {

            $startTime = \Carbon\Carbon::parse($notification_time);
            $finishTime = \Carbon\Carbon::parse($current_time);

            $totalDuration = $finishTime->diffInSeconds($startTime);
            $totalDuration = $totalDuration;

            $data['send_notification'] = true;
            $data['delay'] = $totalDuration;
        }

        return $data;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $current_day = date('l');
        $current_date = date('Y-m-d');
        $current_time = date('H:i:s');
        $str_current_time = strtotime($current_time);

        $new_time = date("H:i:s", strtotime('+30 minutes', $str_current_time));

        //Get Notification Data....
        $notification_data = Notification::where('status', 1)
            ->get();

        $this->info("Checking  #" . $notification_data->count() . " notification for process");
        foreach ($notification_data as $notification) {
            switch ($notification->repeat_type) {
                case 'once': // Case for the run notification once...
                    if ($notification->schedule_date == $current_date) {
                        $this->info("once found");
                        $time_data = $this->calculateTimeDiff($notification->schedule_time);
                        if ($time_data['send_notification']) {
                            $this->info("scheduling  Notification ONCE" . $notification->title . " for process " . $time_data['delay'] . " seconds delay");
                            ScheduledNotificationProcessJob::dispatch($notification->filter_data, $notification)->onQueue('notify')->delay(now()->addSeconds($time_data['delay']));
                        }
                        $this->info("once no due");
                    }
                    break;

                case 'every_day': // Case for the run notification every day...
                    $time_data = $this->calculateTimeDiff($notification->schedule_time);
                    $this->info("everyday check");
                    if ($time_data['send_notification']) {
                        $this->info("scheduling  Notification EVERY DAY" . $notification->title . " for process " . $time_data['delay'] . " seconds delay");
                        ScheduledNotificationProcessJob::dispatch($notification->filter_data, $notification)->onQueue('notify')->delay(now()->addSeconds($time_data['delay']));
                    }
                    $this->info("everyday no due");
                    break;
                case 'custom_days': // Case for the run notification Custom days...
                $this->info("custom day check");
                    $days = json_decode($notification->days);
                    $today = false;
                    if (count($days)) {
                        foreach ($days as $key => $day) {
                            if ($day->label == $current_day && $day->checked == true) {
                                $today = true;
                                break;
                            }
                        }
                    }

                    if ($today) {
                        $time_data = $this->calculateTimeDiff($notification->schedule_time);
                        if ($time_data['send_notification']) {

                            $this->info("scheduling CUSTOM DAYS" . $notification->title . " for process " . $time_data['delay'] . " seconds delay");
                            ScheduledNotificationProcessJob::dispatch($notification->filter_data, $notification)->onQueue('notify')->delay(now()->addSeconds($time_data['delay']));
                        }
                        $this->info("custom day no due");
                    }
                    break;
                default:
                $this->info("no due ");
                break;
                
            }
        }                                                                                                                                                                                                                                                                                                                                                                                                                               
        $this->info("No notification due");
        return 'Notification has been send';
    }
}
