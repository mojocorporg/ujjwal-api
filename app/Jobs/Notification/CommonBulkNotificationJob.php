<?php

namespace App\Jobs\Notification;

use LaravelFCM\Facades\FCM;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class CommonBulkNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $tokens,$data;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($tokens,$data)
    {
        $this->tokens = $tokens;
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try{
            $downstreamResponse = FCM::sendTo($this->tokens, null, null, $this->data);
        }catch(\Exception $e){
            \Log::info('Exception From FCM Bulk Notification'. json_encode((string)$e));
        }catch(\Error $e){
            \Log::info('Error From FCM Bulk Notification'. json_encode((string)$e));
        }
    }
}
