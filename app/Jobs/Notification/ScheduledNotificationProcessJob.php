<?php

namespace App\Jobs\Notification;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use App\Jobs\Notification\ChunkedScheduledNotificationJob;

class ScheduledNotificationProcessJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $filter_data;
    protected $notification_data;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($filter_data, $notification_data)
    {
        $this->filter_data = $filter_data;
        $this->notification_data = $notification_data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $notification_data = $this->notification_data;

        $users_data = User::where('notification_token', '!=', null)->where('status', 1)->get();
    
        if (isset($users_data) && count($users_data) > 0) {
            foreach ($users_data->chunk(1000) as $key => $chunkUsersData) {
                // ChunkedScheduledNotificationJob::dispatch($chunkUsersData, $notification_data)->onQueue('notify')->delay(now()->addSeconds($key + 5));
            }
        }
    }
}
